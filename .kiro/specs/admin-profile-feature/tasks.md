# Implementation Plan

- [x] 1. Create database migrations for admin activity tracking





  - Create migration to add `approved_by` column to givings table
  - Create migration to add `approved_by` column to service_registrations table
  - Create migration to add `approved_by` column to group_member pivot table
  - Create migration to add `created_by` column to events table
  - Create migration to add `last_login_at` column to users table
  - Run migrations
  - _Requirements: 9.1, 9.2, 9.3, 9.4_

- [x] 2. Update models with admin tracking relationships





  - Add `givingsApproved()` relationship to User model
  - Add `serviceRegistrationsApproved()` relationship to User model
  - Add `eventsCreated()` relationship to User model
  - Add `groupApprovalsGiven()` method to User model
  - Add `approvedBy()` relationship to Giving model
  - Add `approvedBy()` relationship to ServiceRegistration model
  - Add `creator()` relationship to Event model
  - _Requirements: 9.5_

- [x] 3. Update existing controllers to track admin actions





  - Update GivingController to record admin_id when approving givings
  - Update ServiceController to record admin_id when confirming payments
  - Update GroupController to record admin_id when approving members
  - Update EventController to record admin_id when creating events
  - Update LoginController to record last_login_at timestamp
  - _Requirements: 9.1, 9.2, 9.3, 9.4_

- [x] 4. Create Admin Profile Controller





  - Create `app/Http/Controllers/Admin/ProfileController.php`
  - Implement `show()` method to display profile page
  - Implement `edit()` method to show edit form
  - Implement `update()` method to update profile
  - Implement `updatePassword()` method to change password
  - Implement helper methods to calculate statistics
  - _Requirements: 2.1, 2.2, 7.1, 8.1_

- [x] 5. Create profile routes





  - Add GET route for `/admin/profile` to show profile
  - Add GET route for `/admin/profile/edit` to edit profile
  - Add PUT route for `/admin/profile` to update profile
  - Add POST route for `/admin/profile/password` to change password
  - Protect all routes with admin middleware
  - _Requirements: 2.1, 7.1, 8.1_

- [x] 6. Create profile dropdown modal component








  - Create profile avatar component in navbar
  - Implement dropdown modal with Alpine.js
  - Add admin name, email, and role display
  - Add "View Profile" link
  - Move logout button to modal
  - Implement click-outside-to-close functionality
  - Implement ESC key to close
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_

- [x] 7. Update sidebar component to remove logout button




  - Remove standalone logout button from sidebar
  - Ensure profile modal is accessible from all admin pages
  - _Requirements: 1.1_

- [x] 8. Create admin profile page view





  - Create `resources/views/admin/profile.blade.php`
  - Implement profile header section with avatar and basic info
  - Implement statistics cards section
  - Add activity history tabs structure
  - Add profile settings section
  - Style with Tailwind CSS matching existing admin design
  - _Requirements: 2.1, 2.2, 2.3, 2.4_

- [x] 9. Implement givings approved history tab




  - Create table to display givings approved by admin
  - Show member name, amount, giving type, approval date
  - Implement pagination (10 per page)
  - Add click handler to navigate to giving details
  - Handle empty state
  - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5_

- [x] 10. Implement service registrations approved history tab





  - Create table to display service registrations approved
  - Show member name, service name, payment amount, approval date
  - Implement pagination (10 per page)
  - Add click handler to navigate to registration details
  - Handle empty state
  - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5_

- [x] 11. Implement group approvals history tab




  - Create table to display group memberships approved
  - Show member name, group name, approval date
  - Implement pagination (10 per page)
  - Add click handler to navigate to group page
  - Handle empty state
  - _Requirements: 5.1, 5.2, 5.3, 5.4, 5.5_

- [x] 12. Implement events posted history tab




  - Create table to display events created by admin
  - Show event title, date, status, creation date
  - Implement pagination (10 per page)
  - Add click handler to navigate to event details
  - Handle empty state
  - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5_

- [x] 13. Implement profile edit functionality





  - Create profile edit form
  - Add fields for name, email, profile image
  - Implement form validation
  - Handle image upload with validation
  - Display success/error messages
  - Redirect back to profile on success
  - _Requirements: 7.1, 7.2, 7.3, 7.4, 7.5_

- [x] 14. Implement password change functionality





  - Create password change form
  - Add fields for current password, new password, confirmation
  - Implement validation (8 character minimum)
  - Verify current password before allowing change
  - Display success/error messages
  - _Requirements: 8.1, 8.2, 8.3, 8.4, 8.5_

- [x] 15. Add profile image upload support





  - Implement image upload to Supabase storage
  - Add fallback to local storage
  - Generate avatar initials for users without images
  - Display profile images in modal and profile page
  - _Requirements: 7.4_

- [ ]* 16. Write unit tests for Profile Controller
  - Test profile show method returns correct data
  - Test profile update with valid data
  - Test profile update with invalid data
  - Test password change with correct current password
  - Test password change with incorrect current password
  - Test statistics calculation methods
  - _Requirements: All_

- [ ]* 17. Write unit tests for model relationships
  - Test User givingsApproved relationship
  - Test User serviceRegistrationsApproved relationship
  - Test User eventsCreated relationship
  - Test User groupApprovalsGiven method
  - _Requirements: 9.5_

- [x] 18. Checkpoint - Ensure all tests pass




  - Ensure all tests pass, ask the user if questions arise.

- [ ]* 19. Write integration tests for admin tracking
  - Test giving approval records admin_id
  - Test service registration approval records admin_id
  - Test group approval records admin_id
  - Test event creation records admin_id
  - Test last_login_at updates on login
  - _Requirements: 9.1, 9.2, 9.3, 9.4_

- [ ]* 20. Write property-based tests
  - **Property 1: Profile statistics accuracy**
  - **Validates: Requirements 2.2**

- [ ]* 21. Write property-based tests
  - **Property 3: Profile update persistence**
  - **Validates: Requirements 7.3**

- [ ]* 22. Write property-based tests
  - **Property 6: Admin tracking on approval**
  - **Validates: Requirements 9.1, 9.2, 9.3**

- [x] 23. Final testing and polish





  - Test profile modal on all admin pages
  - Test all activity history tabs
  - Test profile edit and password change
  - Verify responsive design
  - Test error handling
  - _Requirements: All_

- [x] 24. Final Checkpoint - Ensure all tests pass





  - Ensure all tests pass, ask the user if questions arise.
