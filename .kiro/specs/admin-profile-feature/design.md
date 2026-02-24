# Admin Profile Feature Design Document

## Overview

The admin profile feature provides administrators with a comprehensive view of their activity within the St. Johns Parish Church management system. It includes a profile dropdown modal accessible from any admin page, a detailed profile page showing activity statistics and history, and profile editing capabilities. The design mirrors the existing member profile functionality while adding admin-specific features.

## Architecture

### Component Structure

```
Admin Profile System
├── Profile Dropdown Modal (Navbar Component)
│   ├── Avatar/Trigger
│   ├── User Info Display
│   ├── Navigation Links
│   └── Logout Button
├── Profile Page
│   ├── Profile Header (Avatar, Name, Role, Stats)
│   ├── Activity Statistics Cards
│   ├── Activity History Tabs
│   │   ├── Givings Approved
│   │   ├── Service Registrations Approved
│   │   ├── Group Approvals
│   │   └── Events Posted
│   └── Profile Settings Section
└── Profile Controller
    ├── Show Profile
    ├── Update Profile
    ├── Change Password
    └── Get Activity Data
```

### Database Schema Updates

The following tables need to track admin actions:

1. **givings table** - Add `approved_by` column (foreign key to users.id)
2. **service_registrations table** - Add `approved_by` column (foreign key to users.id)
3. **group_member pivot table** - Add `approved_by` column (foreign key to users.id)
4. **events table** - Add `created_by` column (foreign key to users.id)
5. **users table** - Add `last_login_at` timestamp column

## Components and Interfaces

### 1. Profile Dropdown Modal Component

**Location:** Navbar (replaces current logout button)

**UI Elements:**
- Profile avatar (circular, with fallback initials)
- Dropdown trigger on hover/click
- Modal content:
  - Admin name
  - Admin email
  - Admin role badge
  - "View Profile" link
  - "Logout" button

**Interactions:**
- Hover/click on avatar opens modal
- Click outside closes modal
- ESC key closes modal
- Logout button triggers logout action

### 2. Profile Page Layout

**Route:** `/admin/profile`

**Sections:**

#### Header Section
- Large profile avatar (editable)
- Admin name and role
- Member since date
- Last login timestamp
- Quick stats summary (4 cards)

#### Statistics Cards
- Total Givings Approved (with icon and total amount)
- Service Registrations Approved (with count)
- Group Memberships Approved (with count)
- Events Posted (with count)

#### Activity History Tabs
- Tabbed interface for different activity types
- Each tab shows paginated table of activities
- Consistent table design across all tabs

#### Profile Settings Section
- Edit profile form (collapsible)
- Change password form (collapsible)

### 3. Admin Profile Controller

**Class:** `App\Http\Controllers\Admin\ProfileController`

**Methods:**

```php
public function show()
// Display admin profile with statistics

public function edit()
// Show profile edit form

public function update(Request $request)
// Update admin profile information

public function updatePassword(Request $request)
// Change admin password

public function getGivingsApproved()
// Get paginated list of givings approved by admin

public function getRegistrationsApproved()
// Get paginated list of service registrations approved

public function getGroupApprovalsHistory()
// Get paginated list of group approvals

public function getEventsCreated()
// Get paginated list of events created by admin
```

## Data Models

### User Model Updates

Add relationships to track admin activities:

```php
// In User model
public function givingsApproved()
{
    return $this->hasMany(Giving::class, 'approved_by');
}

public function serviceRegistrationsApproved()
{
    return $this->hasMany(ServiceRegistration::class, 'approved_by');
}

public function eventsCreated()
{
    return $this->hasMany(Event::class, 'created_by');
}

public function groupApprovalsGiven()
{
    // Query group_member pivot where approved_by = this admin
    return DB::table('group_member')
        ->where('approved_by', $this->id)
        ->where('status', 'approved');
}
```

### Migration Requirements

**Migration 1: Add admin tracking columns**

```php
// Add to givings table
$table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

// Add to service_registrations table
$table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

// Add to group_member pivot table
$table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');

// Add to events table
$table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

// Add to users table
$table->timestamp('last_login_at')->nullable();
```

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system-essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Profile statistics accuracy
*For any* admin user, the sum of givings approved count, service registrations approved count, group approvals count, and events created count displayed on their profile should equal the actual count of records in the database where they are recorded as the responsible admin.
**Validates: Requirements 2.2**

### Property 2: Activity history completeness
*For any* admin user viewing their activity history, all records in the database where they are marked as the responsible admin should appear in the corresponding activity history tab.
**Validates: Requirements 3.1, 4.1, 5.1, 6.1**

### Property 3: Profile update persistence
*For any* admin user, when they update their profile information (name, email, or image) and the update is successful, querying their profile immediately after should return the updated values.
**Validates: Requirements 7.3**

### Property 4: Password change security
*For any* admin user attempting to change their password, the system should only allow the change if the provided current password matches the stored password hash.
**Validates: Requirements 8.2**

### Property 5: Modal state consistency
*For any* admin user, when the profile modal is open and they click outside the modal or press ESC, the modal should close and not remain visible.
**Validates: Requirements 1.4**

### Property 6: Admin tracking on approval
*For any* giving, service registration, or group membership that is approved, the system should record the ID of the admin who performed the approval action.
**Validates: Requirements 9.1, 9.2, 9.3**

### Property 7: Logout functionality
*For any* authenticated admin user, when they click the logout button in the profile modal, the system should clear their session and redirect them to the login page.
**Validates: Requirements 1.5**

## Error Handling

### Profile Loading Errors
- If profile data cannot be loaded, display error message and fallback to basic user info
- Log errors for debugging
- Gracefully handle missing relationships

### Profile Update Errors
- Validate all input fields before processing
- Display field-specific error messages
- Rollback changes on failure
- Handle file upload errors gracefully

### Password Change Errors
- Validate current password before allowing change
- Ensure new password meets security requirements
- Display clear error messages for validation failures
- Prevent password change if current password is incorrect

### Activity History Errors
- Handle pagination errors gracefully
- Display empty states when no activities exist
- Log database query errors
- Provide retry mechanisms for failed loads

## Testing Strategy

### Unit Tests

1. **Profile Controller Tests**
   - Test profile page loads with correct data
   - Test profile update with valid data
   - Test profile update with invalid data
   - Test password change with correct current password
   - Test password change with incorrect current password
   - Test activity statistics calculation

2. **Model Relationship Tests**
   - Test User model relationships return correct data
   - Test givingsApproved relationship
   - Test serviceRegistrationsApproved relationship
   - Test eventsCreated relationship
   - Test groupApprovalsGiven query

3. **Middleware Tests**
   - Test admin-only access to profile routes
   - Test redirect for non-admin users

### Property-Based Tests

Property-based tests will use **Pest PHP** with the **Pest Property Testing** plugin for Laravel.

1. **Property Test: Statistics Accuracy**
   - Generate random admin with random number of approvals
   - Verify displayed statistics match database counts
   - **Validates: Property 1**

2. **Property Test: Activity History Completeness**
   - Generate random admin with random activities
   - Verify all activities appear in history tabs
   - **Validates: Property 2**

3. **Property Test: Profile Update Persistence**
   - Generate random valid profile updates
   - Verify updates persist correctly
   - **Validates: Property 3**

4. **Property Test: Password Security**
   - Generate random password combinations
   - Verify only correct current password allows change
   - **Validates: Property 4**

### Integration Tests

1. **Profile Workflow Tests**
   - Test complete profile view → edit → update flow
   - Test profile modal open → navigate → close flow
   - Test activity history pagination
   - Test logout from profile modal

2. **Admin Tracking Tests**
   - Test giving approval records admin_id
   - Test service registration approval records admin_id
   - Test group approval records admin_id
   - Test event creation records admin_id

### UI/Component Tests

1. **Profile Modal Tests**
   - Test modal opens on avatar click/hover
   - Test modal closes on outside click
   - Test modal closes on ESC key
   - Test logout button functionality

2. **Profile Page Tests**
   - Test all sections render correctly
   - Test tab switching works
   - Test pagination works
   - Test edit forms toggle correctly

## Implementation Notes

### Frontend Considerations

- Use Alpine.js for modal interactivity
- Use Tailwind CSS for consistent styling
- Implement smooth transitions for modal and tab switching
- Use loading states for async operations
- Implement optimistic UI updates where appropriate

### Backend Considerations

- Use eager loading to prevent N+1 queries
- Cache statistics for performance
- Implement proper authorization checks
- Use database transactions for profile updates
- Validate file uploads securely

### Security Considerations

- Ensure only admins can access profile routes
- Validate all user inputs
- Sanitize file uploads
- Use CSRF protection on all forms
- Hash passwords using bcrypt
- Implement rate limiting on password changes

### Performance Considerations

- Paginate activity history to limit query size
- Cache profile statistics (invalidate on updates)
- Use database indexes on foreign key columns
- Lazy load activity tabs (only load when clicked)
- Optimize image uploads and storage
