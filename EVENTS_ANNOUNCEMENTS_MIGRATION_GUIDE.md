# Events & Announcements Merge - Migration Guide

## Phase 1: Database Migration ✅ COMPLETED

### What Was Done

1. **Created Migration Files**:
   - `2026_02_07_000001_merge_announcements_into_events.php` - Main migration
   - `2026_02_07_000002_cleanup_announcements_table.php` - Cleanup migration

2. **Updated Existing Migration**:
   - Modified `2026_01_03_000004_improve_remaining_tables.php` to remove duplicate improvements

3. **New Events Table Structure**:
   ```
   - title (existing)
   - slug (NEW - SEO friendly URLs)
   - description (existing - short snippet)
   - content (NEW - full rich text content)
   - type (NEW - 'event' or 'announcement')
   - category (NEW - 'Youth', 'Prayer', 'Service', 'General')
   - date (existing - legacy, kept for compatibility)
   - time (existing - legacy, kept for compatibility)
   - location (existing)
   - starts_at (NEW - unified datetime)
   - ends_at (NEW - event end time)
   - expires_at (NEW - auto-hide expired content)
   - image (NEW - visual content)
   - is_pinned (NEW - priority items)
   - is_active (NEW - draft/published status)
   - view_count (NEW - analytics)
   - created_by (NEW - FK to users)
   - created_at, updated_at (existing)
   - deleted_at (NEW - soft deletes)
   ```

4. **Data Migration**:
   - All existing events: `type = 'event'`, `starts_at` populated from `date` + `time`
   - All announcements migrated to events table with `type = 'announcement'`
   - Announcement `message` → Event `content` (full) and `description` (truncated)

5. **Performance Indexes Added**:
   - Single indexes: type, category, starts_at, is_active, is_pinned, created_by
   - Composite index: (type, is_active, starts_at) for common queries

6. **Foreign Key Constraints**:
   - `created_by` → `users.id` (ON DELETE SET NULL)

---

## How to Run the Migration

### Step 1: Backup Your Database (CRITICAL!)
```bash
# For MySQL/MariaDB
mysqldump -u your_user -p your_database > backup_before_merge.sql

# Or use Laravel backup if you have it configured
php artisan backup:run
```

### Step 2: Run the Migration
```bash
# Fresh migration (if starting fresh)
php artisan migrate:fresh --seed

# Or incremental migration (recommended for production)
php artisan migrate
```

### Step 3: Verify Data Migration
```bash
# Check events table
php artisan tinker
>>> DB::table('events')->count()
>>> DB::table('events')->where('type', 'event')->count()
>>> DB::table('events')->where('type', 'announcement')->count()
>>> exit
```

### Step 4: Run Cleanup Migration (ONLY after verification)
```bash
# This will drop the announcements table
php artisan migrate

# Or if you want to be cautious, manually run:
# php artisan migrate --path=/database/migrations/2026_02_07_000002_cleanup_announcements_table.php
```

---

## Rollback Instructions

If something goes wrong:

```bash
# Rollback the cleanup (restores announcements table structure)
php artisan migrate:rollback --step=1

# Rollback the main merge (restores original events table)
php artisan migrate:rollback --step=2
```

**Note**: Rollback will attempt to restore data, but it's safer to restore from backup if needed.

---

## Verification Checklist

After migration, verify:

- [ ] All events are present in events table
- [ ] All announcements are present in events table with `type = 'announcement'`
- [ ] Event registrations still link correctly to events
- [ ] No data loss (compare counts before/after)
- [ ] Indexes are created (check with `SHOW INDEXES FROM events`)
- [ ] Foreign keys are in place (check with `SHOW CREATE TABLE events`)

---

## Next Steps (Upcoming Phases)

### Phase 2: Model Updates
- Update `Event` model with new fields and scopes
- Add type constants and query scopes
- Update relationships

### Phase 3: Controller Updates
- Merge EventController and AnnouncementController
- Add type filtering
- Update validation rules

### Phase 4: Admin Interface
- Redesign admin dashboard with tabs
- Add filters and bulk operations
- Implement rich text editor

### Phase 5: Public Display
- Update events page to show both types
- Add filtering/tabs
- Update announcement partial

### Phase 6: Routes & Cleanup
- Update routes
- Remove deprecated files
- Update navigation

### Phase 7: Testing & Polish
- Test all CRUD operations
- Performance optimization
- Error handling

---

## Troubleshooting

### Issue: Migration fails with "Column already exists"
**Solution**: You may have run the migration before. Check your migrations table:
```bash
php artisan migrate:status
```

### Issue: Data not migrated correctly
**Solution**: Restore from backup and check the migration logic:
```bash
mysql -u your_user -p your_database < backup_before_merge.sql
```

### Issue: Foreign key constraint fails
**Solution**: Ensure users table exists and has the referenced IDs:
```bash
php artisan tinker
>>> DB::table('announcements')->whereNotNull('created_by')->whereNotIn('created_by', DB::table('users')->pluck('id'))->get()
```

---

## Database Schema Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                        EVENTS TABLE                          │
├─────────────────────────────────────────────────────────────┤
│ id (PK)                                                      │
│ title                                                        │
│ slug (UNIQUE)                                                │
│ description (short snippet)                                  │
│ content (full rich text)                                     │
│ type (ENUM: 'event', 'announcement')                        │
│ category (Youth, Prayer, Service, General)                  │
│ date (legacy)                                                │
│ time (legacy)                                                │
│ location                                                     │
│ starts_at (unified datetime)                                 │
│ ends_at                                                      │
│ expires_at                                                   │
│ image                                                        │
│ is_pinned                                                    │
│ is_active                                                    │
│ view_count                                                   │
│ created_by (FK → users.id)                                  │
│ created_at, updated_at, deleted_at                          │
└─────────────────────────────────────────────────────────────┘
                              │
                              │ (1:N)
                              ▼
                  ┌───────────────────────┐
                  │  EVENT_REGISTRATIONS  │
                  └───────────────────────┘
```

---

## Support

If you encounter issues during migration:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check database error logs
3. Restore from backup if needed
4. Review migration code for any custom adjustments needed

---

**Status**: Phase 1 Complete ✅
**Next**: Phase 2 - Model Updates
