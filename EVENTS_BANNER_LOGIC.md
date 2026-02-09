# Events Banner Logic - This Week Only

## Summary
Updated the events page banner to only show events happening in the current week, while the main grid continues to show all upcoming events and announcements.

## Changes Made

### 1. EventController (`app/Http/Controllers/EventController.php`)
Added separate query for "this week's events":

```php
// Get events happening this week for the banner (featured section)
$thisWeekEvents = Event::active()
    ->notExpired()
    ->events() // Only events, not announcements
    ->where(function ($q) {
        $q->whereBetween('starts_at', [now()->startOfWeek(), now()->endOfWeek()])
          ->orWhereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()]);
    })
    ->with('creator')
    ->orderBy('is_pinned', 'desc')
    ->orderBy('starts_at', 'asc')
    ->get();
```

**Criteria for "This Week's Events":**
- ✅ Active (`is_active = true`)
- ✅ Not expired
- ✅ Type is "event" (not announcements)
- ✅ `starts_at` or `date` falls between Monday and Sunday of current week
- ✅ Ordered by pinned status first, then by start date

### 2. Events View (`resources/views/events.blade.php`)
Updated banner section to use `$thisWeekEvents`:

**Banner Logic:**
- Shows pinned event from this week (if any)
- Falls back to first event of this week
- If no events this week, shows placeholder message
- Badge changed from "FEATURED" to "THIS WEEK"
- Carousel indicators dynamically show up to 3 events from this week

**Placeholder (No Events This Week):**
- Shows friendly message: "No Events This Week"
- Encourages users to check upcoming events below
- Uses church primary color gradient

## How It Works

### Banner Section ("What's Happening This Week")
1. Queries events with `starts_at` or `date` in current week (Monday-Sunday)
2. Prioritizes pinned events
3. Shows only events (not announcements)
4. If no events this week → shows placeholder

### Main Grid (All Events & Announcements)
1. Shows ALL active, non-expired events and announcements
2. Includes future events (next week, next month, etc.)
3. Includes both events and announcements
4. Users can filter by "All", "Upcoming Events", or "Announcements"

## Benefits

1. **Relevant Banner**: Users immediately see what's happening THIS WEEK
2. **Clear Timeframe**: "This Week" badge makes it obvious
3. **Complete Visibility**: All future events still visible in main grid
4. **Better Planning**: Users can see both immediate and long-term events
5. **Graceful Fallback**: Shows helpful message when no events this week

## Example Scenarios

### Scenario 1: Event This Week
- **Banner**: Shows "Youth Worship Night - Friday 7:00 PM" with "THIS WEEK" badge
- **Grid**: Shows all upcoming events including next month's retreat

### Scenario 2: No Events This Week
- **Banner**: Shows placeholder "No Events This Week - Check out our upcoming events below!"
- **Grid**: Shows all future events (next week, next month, etc.)

### Scenario 3: Multiple Events This Week
- **Banner**: Shows pinned event (or first event if none pinned)
- **Carousel Indicators**: Shows dots for up to 3 events this week
- **Grid**: Shows all events including the ones in the banner

## Technical Details

**Week Calculation:**
- Uses Laravel's `now()->startOfWeek()` (Monday)
- Uses Laravel's `now()->endOfWeek()` (Sunday)
- Checks both `starts_at` (datetime) and `date` (date) fields

**Query Performance:**
- Two separate queries (optimized)
- Eager loads `creator` relationship
- Indexed date fields for fast filtering

## Files Modified
1. `app/Http/Controllers/EventController.php` - Added `$thisWeekEvents` query
2. `resources/views/events.blade.php` - Updated banner to use `$thisWeekEvents`

## Status: ✅ COMPLETE
Banner now shows only events happening in the current week, while the main grid shows all upcoming events and announcements.
