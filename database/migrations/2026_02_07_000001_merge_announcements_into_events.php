<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add new columns to events table (check if they don't exist)
        Schema::table('events', function (Blueprint $table) {
            // Content fields
            if (!Schema::hasColumn('events', 'content')) {
                $table->longText('content')->nullable()->after('description');
            }
            
            // Type & categorization
            if (!Schema::hasColumn('events', 'type')) {
                $table->enum('type', ['event', 'announcement'])->default('event')->after('content');
            }
            if (!Schema::hasColumn('events', 'category')) {
                $table->string('category', 100)->nullable()->after('type');
            }
            
            // Unified datetime fields
            if (!Schema::hasColumn('events', 'starts_at')) {
                $table->dateTime('starts_at')->nullable()->after('location');
            }
            if (!Schema::hasColumn('events', 'ends_at')) {
                $table->dateTime('ends_at')->nullable()->after('starts_at');
            }
            if (!Schema::hasColumn('events', 'expires_at')) {
                $table->dateTime('expires_at')->nullable()->after('ends_at');
            }
            
            // Media
            if (!Schema::hasColumn('events', 'image')) {
                $table->string('image')->nullable()->after('expires_at');
            }
            
            // Status & visibility
            if (!Schema::hasColumn('events', 'is_pinned')) {
                $table->boolean('is_pinned')->default(false)->after('image');
            }
            if (!Schema::hasColumn('events', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('is_pinned');
            }
            if (!Schema::hasColumn('events', 'view_count')) {
                $table->integer('view_count')->default(0)->after('is_active');
            }
            
            // Relationships
            if (!Schema::hasColumn('events', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('view_count');
            }
            
            // SEO
            if (!Schema::hasColumn('events', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('title');
            }
            
            // Soft deletes (check if not already added)
            if (!Schema::hasColumn('events', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Step 2: Migrate existing events data to use starts_at
        // Use database-agnostic approach
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            DB::statement("
                UPDATE events 
                SET starts_at = date || ' ' || COALESCE(time, '00:00:00')
                WHERE date IS NOT NULL AND starts_at IS NULL
            ");
        } else {
            // MySQL/PostgreSQL
            DB::statement("
                UPDATE events 
                SET starts_at = CONCAT(date, ' ', COALESCE(time, '00:00:00'))
                WHERE date IS NOT NULL AND starts_at IS NULL
            ");
        }

        // Step 3: Migrate announcements data into events table
        $announcements = DB::table('announcements')->get();
        
        foreach ($announcements as $announcement) {
            DB::table('events')->insert([
                'title' => $announcement->title,
                'description' => substr($announcement->message, 0, 500), // First 500 chars as description
                'content' => $announcement->message, // Full message as content
                'type' => 'announcement',
                'category' => 'General',
                'starts_at' => $announcement->created_at,
                'is_active' => true,
                'is_pinned' => false,
                'created_by' => $announcement->created_by,
                'created_at' => $announcement->created_at,
                'updated_at' => $announcement->updated_at,
            ]);
        }

        // Step 4: Add indexes for performance (with error handling for existing indexes)
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->index('type');
            });
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->index('category');
            });
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->index('starts_at');
            });
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->index('is_active');
            });
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->index('is_pinned');
            });
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->index('created_by');
            });
        } catch (\Exception $e) {
            // Index already exists
        }
        
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->index(['type', 'is_active', 'starts_at'], 'idx_type_active_starts');
            });
        } catch (\Exception $e) {
            // Index already exists
        }

        // Step 5: Add foreign key constraint (with error handling)
        try {
            Schema::table('events', function (Blueprint $table) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            });
        } catch (\Exception $e) {
            // Foreign key already exists
        }

        // Step 6: Remove announcement improvements from the improve_remaining_tables migration
        // (The foreign key and indexes will be dropped when we drop the announcements table later)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });

        // Remove indexes
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['category']);
            $table->dropIndex(['starts_at']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_pinned']);
            $table->dropIndex(['created_by']);
            $table->dropIndex('idx_type_active_starts');
        });

        // Restore announcements data (migrate back from events)
        $announcements = DB::table('events')->where('type', 'announcement')->get();
        
        foreach ($announcements as $announcement) {
            DB::table('announcements')->insert([
                'title' => $announcement->title,
                'message' => $announcement->content ?? $announcement->description,
                'created_by' => $announcement->created_by,
                'created_at' => $announcement->created_at,
                'updated_at' => $announcement->updated_at,
            ]);
        }

        // Delete migrated announcements from events
        DB::table('events')->where('type', 'announcement')->delete();

        // Remove new columns
        Schema::table('events', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'slug',
                'content',
                'type',
                'category',
                'starts_at',
                'ends_at',
                'expires_at',
                'image',
                'is_pinned',
                'is_active',
                'view_count',
                'created_by',
            ]);
        });
    }
};
