<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, seed the services table with existing hardcoded services
        DB::table('services')->insertOrIgnore([
            [
                'name' => 'Confirmation',
                'description' => 'A powerful moment of personal commitment as young people and adults affirm their baptismal vows and receive the strengthening gift of the Holy Spirit.',
                'schedule' => 'Quarterly',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baptism',
                'description' => 'The joyous beginning of Christian life — welcoming infants, children, and adults into God\'s family through water and the Holy Spirit.',
                'schedule' => 'Monthly - First Sunday',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Holy Matrimony',
                'description' => 'Celebrating the sacred covenant of marriage — two lives becoming one under God\'s blessing, surrounded by family and prayer.',
                'schedule' => 'By appointment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Counseling',
                'description' => 'Compassionate, confidential guidance from our clergy and trained counselors for life\'s challenges, marriage preparation, grief, and spiritual growth.',
                'schedule' => 'By appointment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sunday Service Visit',
                'description' => 'Join us for our regular Sunday worship service and experience the warmth of our community.',
                'schedule' => 'Every Sunday',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        // Add service_id column to service_registrations
        Schema::table('service_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable()->after('id');
        });
        
        // Map existing service enum values to service IDs (Issue #4)
        $serviceMap = [
            'Counseling' => DB::table('services')->where('name', 'Counseling')->value('id'),
            'Baptism' => DB::table('services')->where('name', 'Baptism')->value('id'),
            'Youth Retreat' => DB::table('services')->where('name', 'Youth Retreat')->value('id'),
            'Confirmation' => DB::table('services')->where('name', 'Confirmation')->value('id'),
            'Holy Matrimony' => DB::table('services')->where('name', 'Holy Matrimony')->value('id'),
            'Sunday Service Visit' => DB::table('services')->where('name', 'Sunday Service Visit')->value('id'),
        ];
        
        // Update service_id based on existing service enum
        foreach ($serviceMap as $serviceName => $serviceId) {
            if ($serviceId) {
                DB::table('service_registrations')
                    ->where('service', $serviceName)
                    ->update(['service_id' => $serviceId]);
            }
        }
        
        Schema::table('service_registrations', function (Blueprint $table) {
            // Make service_id required and add foreign key (Issue #4)
            $table->unsignedBigInteger('service_id')->nullable(false)->change();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            
            // Add member_id for existing members (Issue #2)
            $table->foreignId('member_id')->nullable()->after('service_id')->constrained('members')->onDelete('cascade');
            
            // Rename columns for guests (Issue #2)
            $table->renameColumn('full_name', 'guest_full_name');
            $table->renameColumn('email', 'guest_email');
            $table->renameColumn('phone_number', 'guest_phone');
            $table->renameColumn('address', 'guest_address');
            
            // Make guest fields nullable
            $table->string('guest_full_name')->nullable()->change();
            $table->string('guest_email')->nullable()->change();
            
            // Remove the hardcoded service enum
            $table->dropColumn('service');
        });
        
        // Add indexes for performance (Issue #5)
        Schema::table('service_registrations', function (Blueprint $table) {
            $table->index('service_id');
            $table->index('member_id');
            $table->index('guest_email');
        });
    }

    public function down(): void
    {
        Schema::table('service_registrations', function (Blueprint $table) {
            // Remove indexes
            $table->dropIndex(['service_id']);
            $table->dropIndex(['member_id']);
            $table->dropIndex(['guest_email']);
        });
        
        // Add back the service enum column
        Schema::table('service_registrations', function (Blueprint $table) {
            $table->enum('service', ['Counseling', 'Baptism', 'Youth Retreat', 'Confirmation', 'Holy Matrimony', 'Sunday Service Visit'])->after('guest_address');
        });
        
        // Populate service enum from service_id
        $services = DB::table('services')->whereIn('name', ['Counseling', 'Baptism', 'Youth Retreat', 'Confirmation', 'Holy Matrimony', 'Sunday Service Visit'])->get();
        foreach ($services as $service) {
            DB::table('service_registrations')
                ->where('service_id', $service->id)
                ->update(['service' => $service->name]);
        }
        
        Schema::table('service_registrations', function (Blueprint $table) {
            // Remove foreign keys and columns
            $table->dropForeign(['service_id']);
            $table->dropForeign(['member_id']);
            $table->dropColumn(['service_id', 'member_id']);
            
            // Revert column names
            $table->renameColumn('guest_full_name', 'full_name');
            $table->renameColumn('guest_email', 'email');
            $table->renameColumn('guest_phone', 'phone_number');
            $table->renameColumn('guest_address', 'address');
            
            // Make fields required again
            $table->string('full_name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
        });
        
        // Remove seeded services
        DB::table('services')->whereIn('name', ['Counseling', 'Baptism', 'Youth Retreat', 'Confirmation', 'Holy Matrimony', 'Sunday Service Visit'])->delete();
    }
};