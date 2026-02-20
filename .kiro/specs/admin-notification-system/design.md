# Design Document

## Overview

The Admin Notification System provides real-time awareness of critical events within the St. John's Parish Church management system. The system uses Laravel's built-in notification infrastructure with a custom database channel to store and retrieve notifications efficiently.

## Architecture

### High-Level Architecture

```
Event Occurs → Notification Created → Stored in DB → Displayed in UI
     ↓              ↓                      ↓              ↓
  Member         Notification          notifications   Navbar Icon
  Registers      Dispatcher            table           + Dropdown
```

### Components

1. **Notification Models**: Laravel Notification classes for each event type
2. **Notification Controller**: API endpoints for fetching and managing notifications
3. **Frontend Components**: Navbar notification icon, dropdown, and badge
4. **Event Listeners**: Trigger notifications when events occur

## Components and Interfaces

### Backend Components

#### 1. Notification Classes

```php
// app/Notifications/NewMemberRegistered.php
class NewMemberRegistered extends Notification
{
    public function __construct(Member $member)
    public function via($notifiable): array // Returns ['database']
    public function toDatabase($notifiable): array
}

// app/Notifications/NewGivingSubmitted.php
class NewGivingSubmitted extends Notification

// app/Notifications/ServiceRegistrationCreated.php  
class ServiceRegistrationCreated extends Notification

// app/Notifications/MemberJoinedGroup.php
class MemberJoinedGroup extends Notification

// app/Notifications/NewAccountCreated.php
class NewAccountCreated extends Notification
```

#### 2. Notification Controller

```php
// app/Http/Controllers/NotificationController.php
class NotificationController extends Controller
{
    public function getUnreadCount(): JsonResponse
    public function getUnreadNotifications(): JsonResponse  
    public function markAsRead(string $id): JsonResponse
    public function markAllAsRead(): JsonResponse
}
```

#### 3. Helper Service

```php
// app/Services/NotificationService.php
class NotificationService
{
    public function notifyAdmins(Notification $notification): void
    private function getAdminUsers(): Collection
}
```

### Frontend Components

#### 1. Notification Icon (Navbar)

```html
<!-- In partials/navbar.blade.php -->
<div class="notification-container" x-data="notificationWidget()">
    <button @mouseenter="loadNotifications()" class="notification-icon">
        <svg><!-- Bell icon --></svg>
        <span x-show="unreadCount > 0" class="badge">{{ unreadCount }}</span>
    </button>
    
    <div x-show="showDropdown" class="notification-dropdown">
        <!-- Notification list -->
    </div>
</div>
```

#### 2. Alpine.js Component

```javascript
function notificationWidget() {
    return {
        unreadCount: 0,
        notifications: [],
        showDropdown: false,
        loading: false,
        
        init() {
            this.fetchUnreadCount();
            this.startPolling();
        },
        
        async fetchUnreadCount() {},
        async loadNotifications() {},
        async markAsRead(id) {},
        async markAllAsRead() {},
        startPolling() {} // Poll every 30 seconds
    }
}
```

## Data Models

### Notifications Table (Laravel Default)

```php
Schema::create('notifications', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('type'); // Notification class name
    $table->morphs('notifiable'); // user_id + user_type
    $table->text('data'); // JSON data
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});
```

### Notification Data Structure

```json
{
    "type": "member_registered|giving_submitted|service_registered|group_joined|account_created",
    "title": "New Member Registered",
    "message": "John Doe has registered as a new member",
    "icon": "person|money|calendar|group|account",
    "color": "blue|green|purple|orange|indigo",
    "action_url": "/admin/members/123",
    "entity_type": "member|giving|service_registration|group",
    "entity_id": 123,
    "metadata": {
        "member_name": "John Doe",
        "amount": "50000",
        "service_name": "Baptism"
    }
}
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system-essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Notification Creation Completeness
*For any* critical event (member registration, giving submission, service registration, group join), when the event occurs, a notification should be created for all admin users in the system.
**Validates: Requirements 1.1, 2.1, 3.1, 4.1, 10.3**

### Property 2: Unread Count Accuracy
*For any* admin user, the unread notification count displayed should equal the number of notifications in the database where `notifiable_id` matches the user ID and `read_at` is NULL.
**Validates: Requirements 5.2, 5.3**

### Property 3: Mark as Read Idempotence
*For any* notification, marking it as read multiple times should result in the same state as marking it once (read_at timestamp set, unread count decremented once).
**Validates: Requirements 6.4, 7.3**

### Property 4: Notification Data Integrity
*For any* notification created, the data field should contain all required fields (type, title, message, icon, action_url, entity_type, entity_id) and the data should be valid JSON.
**Validates: Requirements 1.2, 2.2, 3.2, 4.2, 10.4**

### Property 5: Admin-Only Notifications
*For any* notification created by the system, the notifiable user should have the role 'admin'.
**Validates: Requirements 10.3**

### Property 6: Timestamp Consistency
*For any* notification, the created_at timestamp should be less than or equal to the current time, and if read_at is set, it should be greater than or equal to created_at.
**Validates: Requirements 8.1, 8.2, 8.3**

### Property 7: Mark All as Read Completeness
*For any* admin user, when "mark all as read" is triggered, all notifications where `notifiable_id` matches the user ID and `read_at` is NULL should have `read_at` set to the current timestamp.
**Validates: Requirements 7.2, 7.3**

## Error Handling

### Notification Creation Failures

- **Strategy**: Wrap notification dispatch in try-catch blocks
- **Behavior**: Log errors but don't block main operations
- **User Impact**: Main operation succeeds even if notification fails

```php
try {
    Notification::send($admins, new NewMemberRegistered($member));
} catch (\Exception $e) {
    \Log::error('Failed to send notification', [
        'type' => 'NewMemberRegistered',
        'member_id' => $member->id,
        'error' => $e->getMessage()
    ]);
}
```

### API Failures

- **Strategy**: Return appropriate HTTP status codes with error messages
- **Behavior**: Frontend shows error toast and retries after delay
- **User Impact**: Notification count may be temporarily stale

### Database Failures

- **Strategy**: Use database transactions for mark-as-read operations
- **Behavior**: Rollback on failure, return error to frontend
- **User Impact**: User sees error message, can retry action

## Testing Strategy

### Unit Tests

1. **Notification Creation Tests**
   - Test each notification class creates correct data structure
   - Test notification is sent to all admins
   - Test notification includes correct entity references

2. **Controller Tests**
   - Test unread count returns correct number
   - Test mark as read updates database correctly
   - Test mark all as read updates all notifications
   - Test unauthorized users cannot access endpoints

3. **Service Tests**
   - Test NotificationService finds all admin users
   - Test notification dispatch handles errors gracefully

### Property-Based Tests

**Property Test 1: Notification Creation for All Admins**
- **Feature: admin-notification-system, Property 1: Notification Creation Completeness**
- Generate random number of admin users (1-10)
- Create a member registration event
- Verify notification count equals admin count
- Verify each admin has exactly one notification

**Property Test 2: Unread Count Accuracy**
- **Feature: admin-notification-system, Property 2: Unread Count Accuracy**
- Generate random notifications (0-50) for an admin
- Randomly mark some as read
- Verify API unread count matches database query count

**Property Test 3: Mark as Read Idempotence**
- **Feature: admin-notification-system, Property 3: Mark as Read Idempotence**
- Create a notification
- Mark as read N times (N = random 1-10)
- Verify read_at is set and unread count decreased by exactly 1

**Property Test 4: Notification Data Integrity**
- **Feature: admin-notification-system, Property 4: Notification Data Integrity**
- Generate random notification data
- Create notification
- Retrieve from database
- Verify all required fields present and valid JSON

### Integration Tests

1. **End-to-End Notification Flow**
   - Create member → Verify notification created → Fetch via API → Mark as read
   - Submit giving → Verify notification created → Check unread count
   - Register for service → Verify notification → Mark all as read

2. **Frontend Integration**
   - Test notification icon updates on new notifications
   - Test dropdown displays correct notifications
   - Test mark as read updates UI immediately

## Implementation Notes

### Performance Considerations

1. **Polling Interval**: 30 seconds to balance freshness vs server load
2. **Notification Limit**: Dropdown shows 10 most recent
3. **Database Indexing**: Index on (notifiable_id, read_at, created_at)
4. **Caching**: Consider caching unread count for 10 seconds

### Security Considerations

1. **Authorization**: All notification endpoints require admin role
2. **Data Exposure**: Notifications only show data admin should see
3. **XSS Prevention**: Sanitize notification messages before display
4. **CSRF Protection**: All POST endpoints require CSRF token

### Scalability Considerations

1. **Notification Pruning**: Consider archiving notifications older than 90 days
2. **Batch Operations**: Mark all as read uses single query
3. **Async Dispatch**: Use queues for notification creation in high-traffic scenarios

## UI/UX Design

### Notification Icon States

- **No notifications**: Gray bell icon
- **Unread notifications**: Blue bell icon with red badge showing count
- **Hover**: Dropdown appears with smooth animation

### Notification Types & Styling

| Type | Icon | Color | Example |
|------|------|-------|---------|
| Member Registered | 👤 | Blue | "John Doe registered as a new member" |
| Account Created | 🔐 | Indigo | "Jane Smith created an account" |
| Giving Submitted | 💰 | Green | "New giving: UGX 50,000 (Mobile Money)" |
| Service Registration | 📅 | Purple | "John Doe registered for Baptism" |
| Group Joined | 👥 | Orange | "Jane Smith joined Youth Ministry" |

### Dropdown Layout

```
┌─────────────────────────────────────┐
│ Notifications          Mark All Read │
├─────────────────────────────────────┤
│ 👤 John Doe registered...  2m ago   │
│ 💰 New giving: UGX 50,000  5m ago   │
│ 📅 Service registration... 10m ago  │
│ ...                                  │
├─────────────────────────────────────┤
│ View All Notifications →            │
└─────────────────────────────────────┘
```

## Additional Notification Suggestions

Beyond the core requirements, consider these additional notifications:

1. **Event Registrations**: When members register for events
2. **Payment Confirmations**: When payment proofs are submitted
3. **Group Approval Requests**: When members request to join private groups
4. **System Errors**: Critical system failures or issues
5. **Low Balance Alerts**: When church account balance is low (if applicable)
6. **Upcoming Service Reminders**: Services scheduled in next 24 hours
7. **Member Birthdays**: Upcoming member birthdays for admin awareness
8. **Inactive Members**: Members who haven't engaged in 90+ days

These can be added incrementally after the core system is implemented.
