# Implementation Plan

- [x] 1. Set up notification infrastructure





  - Create notifications table migration (Laravel default)
  - Create NotificationService helper class
  - Add notification routes to web.php
  - _Requirements: 10.4_

- [x] 2. Create notification classes





  - [x] 2.1 Create NewMemberRegistered notification


    - Implement notification class with member data
    - Include member name, email, and profile link
    - _Requirements: 1.1, 1.2, 1.3_


  - [x] 2.2 Create NewAccountCreated notification

    - Implement notification class with user/member data
    - Include account email and member name
    - _Requirements: 1.4_


  - [x] 2.3 Create NewGivingSubmitted notification

    - Implement notification class with giving data
    - Include amount, type, payment method, giver name
    - _Requirements: 3.1, 3.2, 3.3, 3.4_


  - [x] 2.4 Create ServiceRegistrationCreated notification

    - Implement notification class with service registration data
    - Include service name, member name, registration date
    - _Requirements: 2.1, 2.2, 2.3_


  - [x] 2.5 Create ServicePaymentSubmitted notification

    - Implement notification class with payment proof data
    - Include service name, amount, payment method
    - _Requirements: 2.4_

  - [x] 2.6 Create MemberJoinedGroup notification


    - Implement notification class with group membership data
    - Include group name and member name
    - _Requirements: 4.1, 4.2, 4.3_

- [x] 3. Implement NotificationController




  - [x] 3.1 Create getUnreadCount endpoint

    - Query notifications where read_at is null
    - Return count as JSON
    - Require admin authentication
    - _Requirements: 5.2, 5.3, 5.4_


  - [x] 3.2 Create getUnreadNotifications endpoint

    - Query 10 most recent unread notifications
    - Format with relative timestamps
    - Return as JSON array
    - _Requirements: 6.1, 6.2, 6.3, 8.1, 8.2, 8.3_

  - [x] 3.3 Create markAsRead endpoint

    - Update single notification read_at timestamp
    - Return success response
    - Handle invalid notification IDs
    - _Requirements: 6.4, 7.3_


  - [x] 3.4 Create markAllAsRead endpoint

    - Update all unread notifications for current admin
    - Return updated count
    - Use single database query
    - _Requirements: 7.1, 7.2, 7.3, 7.4_

- [x] 4. Integrate notifications into existing controllers






  - [x] 4.1 Add notification to MemberController::store

    - Dispatch NewMemberRegistered after member creation
    - Wrap in try-catch to prevent blocking
    - _Requirements: 1.1, 10.1, 10.2_

  - [x] 4.2 Add notification to RegisteredUserController::store


    - Dispatch NewAccountCreated after account creation
    - Only if linked to member
    - _Requirements: 1.4, 10.1_

  - [x] 4.3 Add notification to GivingController::store


    - Dispatch NewGivingSubmitted after giving creation
    - Include all giving details
    - _Requirements: 3.1, 10.1, 10.2_

  - [x] 4.4 Add notification to ServiceRegistrationController::store


    - Dispatch ServiceRegistrationCreated after registration
    - Include service and member details
    - _Requirements: 2.1, 10.1_

  - [x] 4.5 Add notification to ServiceRegistrationController::submitPaymentProof


    - Dispatch ServicePaymentSubmitted after payment proof
    - Include payment details
    - _Requirements: 2.4, 10.1_

  - [x] 4.6 Add notification to GroupJoinController::store


    - Dispatch MemberJoinedGroup after group join
    - Include group and member details
    - _Requirements: 4.1, 10.1_

- [x] 5. Create frontend notification component



  - [ ] 5.1 Update navbar with notification icon




































    - Add bell icon with Alpine.js component
    - Add badge for unread count
    - Style with Tailwind CSS
    - _Requirements: 5.1, 5.2, 5.3_

  - [x] 5.2 Create notification dropdown




    - Build dropdown HTML structure
    - Add notification list with icons
    - Add "Mark All as Read" button
    - Style with animations
    - _Requirements: 6.1, 6.2, 6.3, 7.1, 9.1, 9.2, 9.3, 9.4, 9.5_

  - [x] 5.3 Implement Alpine.js notification widget





    - Create notificationWidget() function
    - Implement fetchUnreadCount()
    - Implement loadNotifications()
    - Implement markAsRead()
    - Implement markAllAsRead()
    - Add 30-second polling
    - _Requirements: 5.4, 6.1, 6.4, 7.2, 7.4_

  - [x] 5.4 Add relative timestamp formatting




    - Create JavaScript helper for relative time
    - Format timestamps (2m ago, 1h ago, Jan 15)
    - Update on hover/load
    - _Requirements: 8.1, 8.2, 8.3_

  - [x] 5.5 Add notification type icons and colors




    - Map notification types to icons
    - Apply color coding by type
    - Use Material Symbols or emoji
    - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5_

- [x] 6. Testing and validation





  - [x]* 6.1 Write property test for notification creation completeness


    - **Property 1: Notification Creation Completeness**
    - **Validates: Requirements 1.1, 2.1, 3.1, 4.1, 10.3**

  - [x]* 6.2 Write property test for unread count accuracy


    - **Property 2: Unread Count Accuracy**
    - **Validates: Requirements 5.2, 5.3**

  - [x]* 6.3 Write property test for mark as read idempotence


    - **Property 3: Mark as Read Idempotence**
    - **Validates: Requirements 6.4, 7.3**

  - [x]* 6.4 Write property test for notification data integrity


    - **Property 4: Notification Data Integrity**
    - **Validates: Requirements 1.2, 2.2, 3.2, 4.2, 10.4**

  - [ ]* 6.5 Write unit tests for NotificationController
    - Test getUnreadCount returns correct count
    - Test markAsRead updates database
    - Test markAllAsRead updates all notifications
    - Test authorization requirements
    - _Requirements: 5.2, 6.4, 7.2, 7.3_

  - [ ]* 6.6 Write integration tests for notification flow
    - Test member registration creates notification
    - Test giving submission creates notification
    - Test service registration creates notification
    - Test group join creates notification
    - _Requirements: 1.1, 2.1, 3.1, 4.1_

- [x] 7. Checkpoint - Ensure all tests pass





  - Ensure all tests pass, ask the user if questions arise.

- [x] 8. Documentation and polish



  - [ ]* 8.1 Add inline code documentation
    - Document notification classes
    - Document controller methods
    - Document frontend component
    - _Requirements: All_



  - [x] 8.2 Test notification system end-to-end
    - Create test member and verify notification
    - Submit test giving and verify notification
    - Register for test service and verify notification
    - Join test group and verify notification
    - Test mark as read functionality
    - Test mark all as read functionality
    - _Requirements: All_



  - [x] 8.3 Optimize performance

    - Add database indexes on notifications table
    - Test polling performance with multiple admins
    - Verify no memory leaks in frontend
    - _Requirements: 5.4, 10.1_
