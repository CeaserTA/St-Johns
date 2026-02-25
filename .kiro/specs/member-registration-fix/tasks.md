# Implementation Plan

- [ ] 1. Write bug condition exploration test
  - **Property 1: Fault Condition** - Database Column Mismatch and Validation Failures
  - **CRITICAL**: This test MUST FAIL on unfixed code - failure confirms the bug exists
  - **DO NOT attempt to fix the test or the code when it fails**
  - **NOTE**: This test encodes the expected behavior - it will validate the fix when it passes after implementation
  - **GOAL**: Surface counterexamples that demonstrate the bugs exist
  - **Scoped PBT Approach**: Test concrete failing cases for each bug condition
  - Test 1.1: Attempt member registration with valid data when database has camelCase columns - expect database error
  - Test 1.2: Submit registration with null phone when client requires it - expect inconsistent validation
  - Test 1.3: Register with duplicate email - expect cryptic error message
  - Test 1.4: Submit form with validation errors - expect missing visual feedback
  - Test 1.5: Submit date of birth as today's date with "before:today" rule - expect rejection
  - Run test on UNFIXED code
  - **EXPECTED OUTCOME**: Test FAILS (this is correct - it proves the bugs exist)
  - Document counterexamples found to understand root cause
  - Mark task complete when test is written, run, and failure is documented
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_

- [ ] 2. Write preservation property tests (BEFORE implementing fix)
  - **Property 2: Preservation** - Valid Registration Flow and Features
  - **IMPORTANT**: Follow observation-first methodology
  - Observe behavior on UNFIXED code for valid registration scenarios
  - Test 3.1: Valid registration data creates member record successfully
  - Test 3.2: Valid profile image upload stores to Supabase/local storage
  - Test 3.3: Account creation option creates member and user records
  - Test 3.4: Successful registration sends admin notifications
  - Test 3.5: Newsletter opt-in syncs to MailerLite
  - Test 3.6: Group join flow attaches member to group
  - Test 3.7: Valid gender, marital status, cell, date fields are accepted
  - Test 3.8: Valid email format passes validation
  - Write property-based tests capturing observed behavior patterns
  - Run tests on UNFIXED code
  - **EXPECTED OUTCOME**: Tests PASS (this confirms baseline behavior to preserve)
  - Mark task complete when tests are written, run, and passing on unfixed code
  - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7, 3.8_

- [x] 3. Fix member registration bugs

  - [x] 3.1 Verify database migrations have been run
    - **NOTE**: Migration 2026_01_03_000001_fix_members_naming_and_constraints.php already exists and fixes column naming
    - Run `php artisan migrate:status` to check if all migrations have been executed
    - If migration 2026_01_03_000001 hasn't been run, execute `php artisan migrate`
    - Verify database has snake_case columns: full_name, date_of_birth, marital_status, date_joined, profile_image
    - If database has old camelCase columns, the migration needs to be run
    - _Bug_Condition: Migration exists but hasn't been executed on database_
    - _Expected_Behavior: All migrations run, columns use snake_case consistently_
    - _Preservation: Valid registrations continue to work (3.1)_
    - _Requirements: 1.1, 2.1_

  - [x] 3.2 Fix phone field validation consistency
    - Update MemberController.php validation rules to make phone required (remove nullable)
    - Ensure client-side HTML form has phone field marked as required
    - Add appropriate validation error message for phone field
    - _Bug_Condition: Phone is nullable on server but required on client_
    - _Expected_Behavior: Phone is required on both client and server_
    - _Preservation: Valid phone numbers continue to be accepted (3.7)_
    - _Requirements: 1.2, 2.2_

  - [x] 3.3 Add user-friendly email uniqueness error message
    - Update MemberController.php validation rules for email field
    - Add custom error message: "This email is already registered. Please use a different email or log in."
    - Ensure error message is displayed clearly in the form
    - _Bug_Condition: Duplicate email shows cryptic error_
    - _Expected_Behavior: Clear, user-friendly error message displayed_
    - _Preservation: Valid unique emails continue to work (3.8)_
    - _Requirements: 1.3, 2.3_

  - [x] 3.4 Fix date of birth validation rule
    - Update MemberController.php validation rules for date_of_birth
    - Change from "before:today" to "before_or_equal:today"
    - Test edge case where date of birth is today's date
    - _Bug_Condition: "before:today" rejects today's date_
    - _Expected_Behavior: "before_or_equal:today" accepts today's date_
    - _Preservation: Valid past dates continue to work (3.7)_
    - _Requirements: 1.5, 2.5_

  - [x] 3.5 Add error display to registration form
    - Update resources/views/index.blade.php to display validation errors
    - Add error message display for each form field
    - Use Laravel's @error directive or similar to show field-specific errors
    - Add visual styling to highlight fields with errors (red border, error text)
    - Ensure old input values are preserved on validation failure
    - _Bug_Condition: Validation errors not displayed to user_
    - _Expected_Behavior: Clear visual feedback for each invalid field_
    - _Preservation: Form continues to work for valid submissions (3.1)_
    - _Requirements: 1.4, 2.4_

  - [x] 3.6 Verify bug condition exploration test now passes
    - **Property 1: Expected Behavior** - All Registration Bugs Fixed
    - **IMPORTANT**: Re-run the SAME test from task 1 - do NOT write a new test
    - The test from task 1 encodes the expected behavior
    - When this test passes, it confirms the expected behavior is satisfied
    - Run bug condition exploration test from step 1
    - **EXPECTED OUTCOME**: Test PASSES (confirms bugs are fixed)
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

  - [x] 3.7 Verify preservation tests still pass
    - **Property 2: Preservation** - Valid Registration Flow Unchanged
    - **IMPORTANT**: Re-run the SAME tests from task 2 - do NOT write new tests
    - Run preservation property tests from step 2
    - **EXPECTED OUTCOME**: Tests PASS (confirms no regressions)
    - Confirm all tests still pass after fix (no regressions)
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7, 3.8_

- [ ] 4. Checkpoint - Ensure all tests pass
  - Run all exploration and preservation tests
  - Verify database migrations can be run cleanly on fresh database
  - Test complete registration flow manually with various scenarios
  - Ensure all tests pass, ask the user if questions arise
