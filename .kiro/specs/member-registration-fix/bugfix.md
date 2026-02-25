# Bugfix Requirements Document

## Introduction

The member registration module is currently failing to process new member registrations through the homepage registration form. Users attempting to register encounter database errors or silent failures, preventing them from completing the registration process. This bug affects the core functionality of member onboarding and must be resolved to allow new members to join the church community.

The primary issue stems from a database column naming mismatch between two migrations, where the original migration created columns with camelCase naming (e.g., `fullname`, `dateOfBirth`) but a later migration renamed them to snake_case (e.g., `full_name`, `date_of_birth`). The controller maps form fields to snake_case columns, but if migrations weren't run properly or in the correct order, the old column names may still exist in the database, causing "column not found" errors.

Additional issues include validation inconsistencies between client-side and server-side validation for the phone field, unclear error messages for duplicate email addresses, and missing visual feedback for validation errors.

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN the database has camelCase column names from the original migration AND the controller attempts to insert data using snake_case column names THEN the system fails with "column not found" database errors

1.2 WHEN a user submits the registration form with the phone field marked as required in HTML AND the server-side validation has phone as nullable THEN the system allows null phone values despite client-side validation requiring it

1.3 WHEN a user attempts to register with an email that already exists in the members table THEN the system shows a cryptic validation error without clear user-friendly messaging

1.4 WHEN a user submits the registration form with validation errors THEN the system does not display clear visual feedback indicating which fields failed validation

1.5 WHEN a user selects today's date as their date of birth AND the validation rule is "before:today" THEN the system rejects a potentially valid edge case date

### Expected Behavior (Correct)

2.1 WHEN the database migrations are run in the correct order THEN the system SHALL ensure all column names are consistently in snake_case format (full_name, date_of_birth, marital_status, date_joined, profile_image) and the controller SHALL successfully insert member data

2.2 WHEN a user submits the registration form with the phone field THEN the system SHALL enforce consistent validation where phone is required on both client-side and server-side

2.3 WHEN a user attempts to register with a duplicate email address THEN the system SHALL display a clear, user-friendly error message such as "This email is already registered. Please use a different email or log in."

2.4 WHEN a user submits the registration form with validation errors THEN the system SHALL display clear visual feedback with error messages next to each invalid field

2.5 WHEN a user selects a date of birth THEN the system SHALL accept dates that are before or equal to today using "before_or_equal:today" validation rule

### Unchanged Behavior (Regression Prevention)

3.1 WHEN a user submits valid registration data with all required fields THEN the system SHALL CONTINUE TO create a new member record successfully

3.2 WHEN a user uploads a valid profile image during registration THEN the system SHALL CONTINUE TO store the image to Supabase or local storage as fallback

3.3 WHEN a user opts to create an account during registration THEN the system SHALL CONTINUE TO create both a member record and a linked user account

3.4 WHEN a user successfully registers THEN the system SHALL CONTINUE TO send admin notifications about the new member registration

3.5 WHEN a user opts in to newsletter subscription during registration THEN the system SHALL CONTINUE TO sync the subscription to MailerLite

3.6 WHEN a user registers from a group join flow THEN the system SHALL CONTINUE TO attach the member to the specified group

3.7 WHEN validation passes for gender, marital status, cell, and date fields THEN the system SHALL CONTINUE TO accept and store these values correctly

3.8 WHEN a user provides a valid email address THEN the system SHALL CONTINUE TO validate the email format correctly
