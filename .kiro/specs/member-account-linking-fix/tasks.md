# Implementation Plan

- [x] 1. Fix MemberController::createAccount() method with proper linking and transactions




  - Add database transaction wrapper for atomic operations
  - Add validation to check if member already has an account
  - Add check for orphaned user accounts with same email
  - Improve error messages with specific scenarios
  - Add comprehensive logging for debugging
  - Ensure proper user_id linking to member record
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 3.3, 3.4, 3.5_

- [x] 1.1 Write property test for account-member linking integrity






  - **Property 1: Account-Member Linking Integrity**
  - **Validates: Requirements 1.1, 1.2**

- [x] 1.2 Write property test for duplicate account prevention





  - **Property 3: No Duplicate Accounts**
  - **Validates: Requirements 1.3, 3.3**

- [x] 2. Enhance RegisteredUserController::store() to enforce member registration




  - Add check if email exists in members table before account creation
  - Redirect guests to member registration if not found
  - Add check if member already has linked account
  - Wrap account creation in database transaction
  - Link new user account to existing member record
  - Add specific error messages for each scenario
  - _Requirements: 2.1, 2.2, 2.4, 3.1, 3.3, 3.4, 3.5_

- [x] 2.1 Write property test for guest registration enforcement






  - **Property 4: Guest Registration Enforcement**
  - **Validates: Requirements 2.1, 2.2, 2.5**

- [x] 2.2 Write property test for no orphaned accounts






  - **Property 2: No Orphaned Accounts**
  - **Validates: Requirements 2.4, 3.1**

- [x] 3. Update quick account modal for better error handling




  - Add error message display section at top of modal
  - Style error messages for visibility
  - Add success message display
  - Improve form validation feedback
  - Add loading state during submission
  - _Requirements: 4.2, 4.3_

- [x] 4. Update member registration flow to guide account creation





  - Add session flash message handling for 'show_member_registration'
  - Add session flash message handling for 'show_account_creation'
  - Pre-fill email in account creation form after member registration
  - Add clear messaging about next steps after member registration
  - Auto-show account creation modal after successful member registration
  - _Requirements: 2.3, 4.1, 4.4, 4.5_

- [x] 5. Enhance services page to handle registration flow





  - Detect and display 'show_member_registration' flash message
  - Detect and display 'show_account_creation' flash message
  - Show member registration modal when guest needs to register first
  - Add informational message explaining registration requirement
  - Handle email pre-filling from session data
  - _Requirements: 2.5, 4.1, 4.4_

- [x] 5.1 Write property test for transaction atomicity






  - **Property 5: Transaction Atomicity**
  - **Validates: Requirements 3.4, 3.5**

- [x] 6. Add comprehensive logging for account operations





  - Log account creation attempts with email
  - Log member lookup results
  - Log successful user-member linking
  - Log transaction failures with error details
  - Log duplicate account prevention
  - _Requirements: 3.4, 3.5_

- [x] 7. Write integration tests for full registration flows





  - Test existing member creating account later
  - Test guest being redirected to member registration
  - Test concurrent account creation attempts
  - Test transaction rollback scenarios
  - _Requirements: 1.1, 1.2, 1.3, 2.1, 2.2, 3.4, 3.5_

- [x] 8. Checkpoint - Ensure all tests pass



  - Ensure all tests pass, ask the user if questions arise.
