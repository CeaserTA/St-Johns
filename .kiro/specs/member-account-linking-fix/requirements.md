# Requirements Document

## Introduction

This specification addresses critical authentication flow issues where member registration and user account creation are not properly linked. The system currently has two problems: (1) members who register first and create accounts later cannot login because the account is not linked to their member profile, and (2) guests attempting to create accounts are not guided through the required member registration step first.

## Glossary

- **Member**: A church member profile containing personal information (name, phone, address, etc.)
- **User Account**: An authentication account with email and password for system login
- **Guest**: A person who has not yet registered as a member
- **Existing Member**: A person who has completed member registration but has not created a user account
- **Full Member**: A person who has both member registration and a user account
- **Quick Account Modal**: The UI component for creating user accounts for existing members
- **Member Registration Modal**: The UI component for registering as a new church member

## Requirements

### Requirement 1

**User Story:** As an existing member who registered without creating an account, I want to create a user account later that links to my member profile, so that I can login and access services and groups.

#### Acceptance Criteria

1. WHEN an existing member creates an account using the quick account modal THEN the system SHALL link the new user account to the existing member record via user_id
2. WHEN the system creates a user account for an existing member THEN the system SHALL verify the email matches an existing member record
3. WHEN a member with an existing account attempts to create another account THEN the system SHALL prevent duplicate account creation and display an appropriate error message
4. WHEN an existing member successfully creates an account THEN the system SHALL automatically log them in
5. WHEN an existing member creates an account THEN the system SHALL redirect them to the services page with a success message

### Requirement 2

**User Story:** As a guest attempting to access services or groups, I want to be guided through member registration first before creating an account, so that I complete the required steps in the correct order.

#### Acceptance Criteria

1. WHEN a guest clicks "Create Account" from the services page THEN the system SHALL check if their email exists in the members table
2. WHEN a guest's email does not exist in the members table THEN the system SHALL redirect them to complete member registration first
3. WHEN a guest completes member registration THEN the system SHALL automatically show the account creation form
4. WHEN a guest's email exists in the members table THEN the system SHALL allow them to proceed with account creation
5. WHEN the system redirects a guest to member registration THEN the system SHALL display a clear message explaining they must register as a member first

### Requirement 3

**User Story:** As a system administrator, I want the member registration and account creation flow to be seamless and foolproof, so that all users end up with properly linked member profiles and user accounts.

#### Acceptance Criteria

1. WHEN a user completes member registration with account creation in one step THEN the system SHALL create both the member record and user account and link them via user_id
2. WHEN a user completes member registration without account creation THEN the system SHALL store the member record without a user_id
3. WHEN an existing member creates an account THEN the system SHALL update the member record's user_id field with the new user account ID
4. WHEN the system creates or links accounts THEN the system SHALL ensure data integrity by using database transactions
5. WHEN account linking fails THEN the system SHALL rollback changes and display a clear error message to the user

### Requirement 4

**User Story:** As a user, I want clear feedback and guidance throughout the registration and account creation process, so that I understand what steps I need to complete.

#### Acceptance Criteria

1. WHEN a guest attempts to create an account without member registration THEN the system SHALL display a modal explaining they need to register as a member first
2. WHEN an existing member creates an account successfully THEN the system SHALL display a success message confirming their account is ready
3. WHEN account creation fails THEN the system SHALL display specific error messages explaining what went wrong
4. WHEN a user is redirected to member registration THEN the system SHALL pre-fill their email if provided
5. WHEN a user completes member registration THEN the system SHALL clearly indicate the next step is to create an account
