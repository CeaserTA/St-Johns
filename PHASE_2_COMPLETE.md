# ✅ Phase 2: Model Updates - COMPLETE

## Summary

Successfully updated the Event model with comprehensive functionality to support both events and announcements, including type constants, query scopes, accessors, mutators, and helper methods.

## What Was Accomplished

### 1. **Event Model Enhancements** ✅

#### Type Constants
```php
const TYPE_EVENT = 'event';
const TYPE_ANNOUNCEMENT = 'announcement';
```

#### Category Constants
```php
const CATEGORY_GENERAL = 'General';
const CATEGORY_YOUTH = 'Youth';
const CATEGORY_PRAYER = 'Prayer';
const CATEGORY_SERVICE = 'Service';
const CATEGORY_WORSHIP = 'Worship';
const CATEGORY_FELLOWSHIP = 'Fellowship';
```

#### New Traits
- `SoftDeletes` - For soft delete functionality

#### Updated Fillable Fields
All 18 new fields added to `$fillable` array:
- title, slug, description, content
- type, category
- date, time, location (legacy)
- starts_at, ends_at, expires_at
- image
- is_pinned, is_active, view_count
- created_by

#### Type Casting
```php
'date' => 'date',
'starts_at' => 'datetime',
'ends_at' => 'datetime',
'expires_at' => 'datetime',
'is_pinned' => 'boolean',
'is_active' => 'boolean',
'view_count' => 'integer',
```

#### Auto-Slug Generation
- Automatically generates unique slug from title on create
- Updates slug when title changes
- Handles duplicate slugs with numeric suffixes

### 2. **Relationships** ✅

```php
// Event belongs to User (creator)
public function creator()

// Event has many EventRegistrations
public function registrations()
```

### 3. **Query Scopes** ✅

#### Type Scopes
- `events()` - Get only events
- `announcements()` - Get only announcements

#### Status Scopes
- `active()` - Get active items
- `inactive()` - Get inactive items
- `pinned()` - Get pinned items

#### Date/Time Scopes
- `notExpired()` - Items not expired
- `expired()` - Items that have expired
- `upcoming()` - Future events
- `past()` - Past events

#### Filter Scopes
- `byCategory($category)` - Filter by category

#### Combined Scopes
- `published()` - Active, not expired, and started

**Usage Examples:**
```php
// Get all active events
Event::events()->active()->get();

// Get upcoming announcements
Event::announcements()->upcoming()->get();

// Get pinned, active items
Event::pinned()->active()->get();

// Get published events by category
Event::events()->published()->byCategory('Youth')->get();
```

### 4. **Accessors (Computed Properties)** ✅

#### Type Checks
- `is_event` - Boolean: is this an event?
- `is_announcement` - Boolean: is this an announcement?

#### Status Checks
- `is_expired` - Boolean: has this expired?
- `is_upcoming` - Boolean: is this in the future?
- `is_past` - Boolean: is this in the past?

#### Formatted Dates
- `formatted_date` - "Jan 15, 2026"
- `formatted_time` - "3:30 PM"
- `formatted_date_time` - "Jan 15, 2026 at 3:30 PM"

#### Content
- `excerpt` - First 150 characters of description/content
- `image_url` - Full URL to image (handles storage paths)

**Usage Examples:**
```php
$event = Event::find(1);

if ($event->is_event) {
    echo $event->formatted_date_time;
}

if ($event->is_upcoming) {
    echo "Coming soon!";
}

echo $event->excerpt; // Auto-truncated description
```

### 5. **Helper Methods** ✅

#### View Tracking
```php
$event->incrementViewCount();
```

#### Pin/Unpin
```php
$event->pin();
$event->unpin();
```

#### Activate/Deactivate
```php
$event->activate();
$event->deactivate();
```

#### Expiration Management
```php
$event->setExpiration(now()->addDays(30));
$event->removeExpiration();
```

### 6. **Static Helper Methods** ✅

```php
// Get all available types
Event::getTypes(); 
// Returns: ['event' => 'Event', 'announcement' => 'Announcement']

// Get all available categories
Event::getCategories();
// Returns: ['General', 'Youth', 'Prayer', 'Service', 'Worship', 'Fellowship']
```

### 7. **Announcement Model (Backward Compatibility)** ✅

Updated to extend Event model with:
- Global scope to filter only announcements
- Automatic type setting to 'announcement'
- Marked as `@deprecated` with migration instructions
- `latest()` method for getting most recent announcement

**Usage:**
```php
// Old way (still works)
$announcement = Announcement::latest();

// New way (recommended)
$announcement = Event::announcements()->active()->notExpired()->latest()->first();
```

### 8. **EventRegistration Model Updates** ✅

Added:
- `event()` relationship to Event model
- `full_name` accessor
- `forEvent($eventId)` scope

## Files Modified

1. ✅ `app/Models/Event.php` - Complete rewrite with 300+ lines
2. ✅ `app/Models/Announcement.php` - Updated to extend Event (backward compatibility)
3. ✅ `app/Models/EventRegistration.php` - Added relationships and helpers

## Usage Examples

### Creating Events

```php
// Create an event
$event = Event::create([
    'title' => 'Youth Fellowship',
    'description' => 'Join us for an evening of worship',
    'type' => Event::TYPE_EVENT,
    'category' => Event::CATEGORY_YOUTH,
    'starts_at' => now()->addDays(7),
    'ends_at' => now()->addDays(7)->addHours(2),
    'location' => 'Main Hall',
    'is_active' => true,
    'created_by' => auth()->id(),
]);

// Slug is auto-generated: 'youth-fellowship'
```

### Creating Announcements

```php
// Create an announcement
$announcement = Event::create([
    'title' => 'Service Cancelled',
    'content' => '<p>Due to weather conditions...</p>',
    'type' => Event::TYPE_ANNOUNCEMENT,
    'category' => Event::CATEGORY_GENERAL,
    'is_pinned' => true,
    'expires_at' => now()->addDays(3),
    'created_by' => auth()->id(),
]);
```

### Querying

```php
// Get all upcoming events
$upcomingEvents = Event::events()
    ->upcoming()
    ->active()
    ->orderBy('starts_at')
    ->get();

// Get pinned announcements
$pinnedAnnouncements = Event::announcements()
    ->pinned()
    ->active()
    ->notExpired()
    ->get();

// Get youth events
$youthEvents = Event::events()
    ->byCategory('Youth')
    ->published()
    ->get();

// Get event with registrations
$event = Event::with('registrations')->find(1);
echo "Registrations: " . $event->registrations->count();
```

### Using Accessors

```php
$event = Event::find(1);

// Type checks
if ($event->is_event) {
    echo "This is an event";
}

// Date formatting
echo $event->formatted_date_time; // "Jan 15, 2026 at 3:30 PM"

// Status checks
if ($event->is_upcoming && !$event->is_expired) {
    echo "Coming soon!";
}

// Content
echo $event->excerpt; // Truncated description
echo $event->image_url; // Full image URL
```

### Using Helper Methods

```php
$event = Event::find(1);

// Pin/unpin
$event->pin();
$event->unpin();

// Activate/deactivate
$event->activate();
$event->deactivate();

// Set expiration
$event->setExpiration(now()->addDays(30));
$event->removeExpiration();

// Track views
$event->incrementViewCount();
```

## Testing Checklist

- [x] Model loads without errors
- [x] Type constants defined
- [x] Category constants defined
- [x] Fillable fields include all new columns
- [x] Type casting works correctly
- [x] Slug auto-generation works
- [x] Relationships defined
- [x] Query scopes work
- [x] Accessors return correct values
- [x] Helper methods work
- [x] Backward compatibility maintained

## Next Steps

### Phase 3: Controller Consolidation (READY TO START)
- Merge EventController and AnnouncementController
- Add type filtering in index method
- Update validation rules for both types
- Add methods for pinning, activation, expiration
- Handle image uploads
- Implement slug generation in controller
- Add bulk operations

### Phase 4: Admin Interface Redesign
- Create unified admin dashboard with tabs
- Add filters (category, status, pinned, expired)
- Implement card-based layout
- Add bulk operations UI
- Add image upload UI
- Add rich text editor for content

### Phase 5: Public Display Updates
- Update events page to show both types
- Add filtering/tabs
- Update announcement partial
- Add detail pages with slug URLs

### Phase 6: Routes & Cleanup
- Update routes
- Remove deprecated announcement routes
- Update navigation

### Phase 7: Testing & Polish
- Test all CRUD operations
- Performance optimization
- Error handling

---

## Model API Reference

### Event Model

#### Constants
```php
Event::TYPE_EVENT
Event::TYPE_ANNOUNCEMENT
Event::CATEGORY_GENERAL
Event::CATEGORY_YOUTH
Event::CATEGORY_PRAYER
Event::CATEGORY_SERVICE
Event::CATEGORY_WORSHIP
Event::CATEGORY_FELLOWSHIP
```

#### Scopes
```php
->events()
->announcements()
->active()
->inactive()
->pinned()
->notExpired()
->expired()
->upcoming()
->past()
->byCategory($category)
->published()
```

#### Accessors
```php
$event->is_event
$event->is_announcement
$event->is_expired
$event->is_upcoming
$event->is_past
$event->formatted_date
$event->formatted_time
$event->formatted_date_time
$event->excerpt
$event->image_url
```

#### Methods
```php
$event->incrementViewCount()
$event->pin()
$event->unpin()
$event->activate()
$event->deactivate()
$event->setExpiration($date)
$event->removeExpiration()
Event::getTypes()
Event::getCategories()
```

#### Relationships
```php
$event->creator // User who created it
$event->registrations // EventRegistrations
```

---

**Status**: ✅ PHASE 2 COMPLETE
**Date**: February 7, 2026
**Next Phase**: Phase 3 - Controller Consolidation
