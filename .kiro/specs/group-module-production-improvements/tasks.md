# Implementation Plan

- [x] 1. Database schema enhancements

  - [x] 1.1 Create migration for new group fields


    - Add `icon`, `image_url`, and `category` columns to groups table
    - Add database indexes for `is_active` and `sort_order` for query performance
    - _Requirements: 1.5_

- [x] 2. Dynamic homepage group loading

  - [x] 2.1 Create HomeController for homepage logic


    - Implement index method that retrieves active groups with member counts
    - Determine authenticated user's current group memberships
    - Pass groups and memberGroupIds to view
    - _Requirements: 1.1, 1.2_
  
  - [ ]* 2.2 Write property test for active groups query
    - **Property 1: Active groups query returns only active groups in correct order**
    - **Validates: Requirements 1.1**
  
  - [ ]* 2.3 Write property test for member count accuracy
    - **Property 2: Group member count accuracy**
    - **Validates: Requirements 1.2**
  
  - [x] 2.4 Update homepage route to use HomeController


    - Replace closure with controller action
    - Ensure proper data passing to view
    - _Requirements: 1.1, 1.2_
  
  - [x] 2.5 Update index.blade.php to handle dynamic groups


    - Remove any hardcoded group data
    - Ensure proper handling of optional icon/image fields
    - Display member counts from database
    - _Requirements: 1.1, 1.2, 1.4, 1.5_
  
  - [ ]* 2.6 Write property test for group display fields
    - **Property 3: Group display includes all required fields**
    - **Validates: Requirements 1.4**
  
  - [ ]* 2.7 Write property test for icon display
    - **Property 4: Groups with icons display visual elements**
    - **Validates: Requirements 1.5**

- [x] 3. Authentication-based group joining

  - [x] 3.1 Add auth middleware to GroupJoinController


    - Apply middleware in constructor
    - Remove email input field from join logic
    - _Requirements: 2.1, 2.5_
  
  - [x] 3.2 Update join method to use authenticated user's member

    - Use Auth::user()->member instead of email lookup
    - Add validation for missing member record
    - Return appropriate error messages
    - _Requirements: 2.2, 2.3_
  
  - [ ]* 3.3 Write property test for member record linkage
    - **Property 5: Authenticated users use linked member records for joining**
    - **Validates: Requirements 2.2**
  
  - [x] 3.4 Update join method to return JSON responses

    - Convert responses to JSON format for AJAX
    - Include success status and messages
    - Handle error cases with appropriate JSON responses
    - _Requirements: 3.3_
  
  - [ ]* 3.5 Write property test for JSON responses
    - **Property 8: Join responses return valid JSON**
    - **Validates: Requirements 3.3**
  
  - [x] 3.6 Update homepage view for authentication states

    - Hide join button for guests or show login prompt
    - Display "Already a member" for existing memberships
    - Show message for users without member records
    - _Requirements: 2.4, 3.1_
  
  - [ ]* 3.7 Write property test for already-member indicator
    - **Property 6: Already-member indicator appears for existing memberships**
    - **Validates: Requirements 3.1**

- [x] 4. Duplicate membership prevention

  - [x] 4.1 Ensure syncWithoutDetaching is used in join logic

    - Verify existing implementation prevents duplicates
    - Add explicit tests for idempotence
    - _Requirements: 3.2_
  
  - [ ]* 4.2 Write property test for duplicate prevention
    - **Property 7: Duplicate membership prevention (idempotence)**
    - **Validates: Requirements 3.2**

- [x] 5. AJAX group joining functionality


  - [x] 5.1 Create JavaScript for AJAX join requests


    - Handle join button clicks
    - Send AJAX POST requests to join endpoint
    - Include CSRF token in requests
    - _Requirements: 3.3, 3.5_
  
  - [x] 5.2 Implement loading states in JavaScript

    - Show loading indicator during request
    - Disable join button while processing
    - _Requirements: 3.4_
  
  - [x] 5.3 Implement UI updates on join completion


    - Update button to "Already a member" on success
    - Display success/error messages
    - Update UI without page reload
    - _Requirements: 3.5_

- [ ] 6. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 7. Card-based admin dashboard redesign


  - [x] 7.1 Create new admin dashboard layout with card grid


    - Replace table layout with responsive card grid
    - Use Tailwind CSS for card styling
    - Ensure responsive design for mobile/tablet/desktop
    - _Requirements: 4.1_
  
  - [x] 7.2 Design group card component

    - Display name, truncated description, meeting day, location
    - Show member count with icon
    - Add edit and delete action buttons
    - _Requirements: 4.2_
  
  - [ ]* 7.3 Write property test for card content
    - **Property 9: Group cards contain all required information**
    - **Validates: Requirements 4.2**
  
  - [x] 7.4 Create modal or sidebar for group create/edit

    - Implement modal component with form
    - Include all group fields (name, description, meeting_day, location, icon, image_url, category, is_active, sort_order)
    - Add form validation
    - _Requirements: 4.3_
  
  - [x] 7.5 Implement empty state for no groups

    - Create empty state component
    - Display helpful message and create button
    - _Requirements: 4.5_
  
  - [x] 7.6 Add inline validation and feedback messages

    - Display validation errors inline with form fields
    - Show success/error messages after actions
    - Use consistent styling with admin area
    - _Requirements: 4.6, 4.7_
  
  - [ ]* 7.7 Write property test for admin action feedback
    - **Property 10: Admin actions return appropriate feedback messages**
    - **Validates: Requirements 4.6**

- [x] 8. Member management interface




  - [x] 8.1 Create expandable member list for each group card

    - Implement expandable/collapsible member list
    - Display member names and basic info
    - Add remove button for each member
    - _Requirements: 4.4, 5.2_
  
  - [x] 8.2 Implement add member functionality

    - Create modal or inline form for adding members
    - Add search/filter for finding members
    - Support selecting multiple members
    - _Requirements: 5.1_
  
  - [x] 8.3 Implement remove member functionality

    - Add remove button for each member in list
    - Show confirmation dialog
    - Update UI after removal
    - _Requirements: 5.3_
  
  - [ ]* 8.4 Write property test for member removal
    - **Property 11: Member removal updates membership immediately**
    - **Validates: Requirements 5.3**
  
  - [x] 8.5 Add bulk member operations (optional enhancement)

    - Implement bulk add functionality
    - Implement bulk remove functionality
    - Add checkboxes for member selection
    - _Requirements: 5.4_
  
  - [x] 8.6 Add confirmation messages for member operations

    - Display success message after adding member
    - Display success message after removing member
    - Show error messages for failed operations
    - _Requirements: 5.5_
  
  - [ ]* 8.7 Write property test for member management confirmation
    - **Property 12: Member management actions provide confirmation**
    - **Validates: Requirements 5.5**

- [x] 9. Update routes and middleware



  - [x] 9.1 Update web routes for new controllers


    - Add HomeController route for homepage
    - Ensure GroupJoinController routes have auth middleware
    - Verify admin routes have admin middleware
    - _Requirements: 2.1_

- [ ] 10. Final checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.
