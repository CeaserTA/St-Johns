# Requirements Document

## Introduction

This document outlines the requirements for implementing a comprehensive admin profile feature in the St. Johns Parish Church management system. The feature will provide administrators with a dedicated profile page showing their activity history, statistics, and profile management capabilities, similar to the existing member profile functionality.

## Glossary

- **Admin**: A user with administrative privileges in the system
- **Profile Modal**: A dropdown/modal interface that appears when hovering over the admin's profile avatar
- **Activity History**: A record of actions performed by the admin (givings approved, registrations confirmed, events posted, etc.)
- **Profile Settings**: Interface for editing admin personal information
- **Dashboard**: The main administrative interface

## Requirements

### Requirement 1

**User Story:** As an admin, I want to access my profile from any admin page, so that I can quickly view my information and logout.

#### Acceptance Criteria

1. WHEN an admin hovers over their profile avatar in the navbar THEN the system SHALL display a dropdown modal with profile options
2. WHEN the profile modal is displayed THEN the system SHALL show the admin's name, email, and role
3. WHEN the profile modal is displayed THEN the system SHALL include a "View Profile" link and a "Logout" button
4. WHEN an admin clicks outside the modal THEN the system SHALL close the dropdown
5. WHEN an admin clicks the logout button THEN the system SHALL log them out and redirect to the login page

### Requirement 2

**User Story:** As an admin, I want to view my profile page, so that I can see my activity statistics and history.

#### Acceptance Criteria

1. WHEN an admin navigates to their profile page THEN the system SHALL display their personal information (name, email, role, profile image)
2. WHEN the profile page loads THEN the system SHALL display summary statistics including total givings approved, service registrations approved, groups approved, and events posted
3. WHEN the profile page loads THEN the system SHALL show the admin's account creation date and last login time
4. WHEN displaying statistics THEN the system SHALL use visual cards with icons and color coding
5. WHEN the admin has no activity THEN the system SHALL display appropriate empty state messages

### Requirement 3

**User Story:** As an admin, I want to view my giving approval history, so that I can track which donations I have processed.

#### Acceptance Criteria

1. WHEN an admin views their profile THEN the system SHALL display a list of givings they have approved
2. WHEN displaying giving history THEN the system SHALL show the member name, amount, giving type, and approval date
3. WHEN the giving list is displayed THEN the system SHALL order entries by most recent first
4. WHEN there are more than 10 givings THEN the system SHALL paginate the results
5. WHEN an admin clicks on a giving entry THEN the system SHALL navigate to the detailed giving view

### Requirement 4

**User Story:** As an admin, I want to view my service registration approval history, so that I can track which registrations I have confirmed.

#### Acceptance Criteria

1. WHEN an admin views their profile THEN the system SHALL display a list of service registrations they have approved
2. WHEN displaying registration history THEN the system SHALL show the member name, service name, payment amount, and approval date
3. WHEN the registration list is displayed THEN the system SHALL order entries by most recent first
4. WHEN there are more than 10 registrations THEN the system SHALL paginate the results
5. WHEN an admin clicks on a registration entry THEN the system SHALL navigate to the detailed registration view

### Requirement 5

**User Story:** As an admin, I want to view my group approval history, so that I can track which group memberships I have approved.

#### Acceptance Criteria

1. WHEN an admin views their profile THEN the system SHALL display a list of group memberships they have approved
2. WHEN displaying group approval history THEN the system SHALL show the member name, group name, and approval date
3. WHEN the group approval list is displayed THEN the system SHALL order entries by most recent first
4. WHEN there are more than 10 approvals THEN the system SHALL paginate the results
5. WHEN an admin clicks on a group entry THEN the system SHALL navigate to the group management page

### Requirement 6

**User Story:** As an admin, I want to view my event posting history, so that I can track which events I have created.

#### Acceptance Criteria

1. WHEN an admin views their profile THEN the system SHALL display a list of events they have created
2. WHEN displaying event history THEN the system SHALL show the event title, date, status (active/inactive), and creation date
3. WHEN the event list is displayed THEN the system SHALL order entries by most recent first
4. WHEN there are more than 10 events THEN the system SHALL paginate the results
5. WHEN an admin clicks on an event entry THEN the system SHALL navigate to the event details page

### Requirement 7

**User Story:** As an admin, I want to edit my profile settings, so that I can update my personal information.

#### Acceptance Criteria

1. WHEN an admin clicks the "Edit Profile" button THEN the system SHALL display a profile editing form
2. WHEN the edit form is displayed THEN the system SHALL allow editing of name, email, and profile image
3. WHEN an admin submits the edit form with valid data THEN the system SHALL update their profile information
4. WHEN an admin uploads a new profile image THEN the system SHALL validate the file type and size
5. WHEN profile updates are successful THEN the system SHALL display a success message and refresh the profile view

### Requirement 8

**User Story:** As an admin, I want to change my password from my profile, so that I can maintain account security.

#### Acceptance Criteria

1. WHEN an admin views their profile settings THEN the system SHALL display a "Change Password" section
2. WHEN changing password THEN the system SHALL require the current password, new password, and password confirmation
3. WHEN the new password is submitted THEN the system SHALL validate it meets minimum security requirements (8 characters minimum)
4. WHEN passwords do not match THEN the system SHALL display an error message
5. WHEN password change is successful THEN the system SHALL display a success message

### Requirement 9

**User Story:** As a system, I want to track admin activities, so that profile statistics can be accurately displayed.

#### Acceptance Criteria

1. WHEN an admin approves a giving THEN the system SHALL record the admin_id in the givings table
2. WHEN an admin confirms a service registration payment THEN the system SHALL record the admin_id in the service_registrations table
3. WHEN an admin approves a group membership THEN the system SHALL record the approver_id in the group_member pivot table
4. WHEN an admin creates an event THEN the system SHALL record the created_by admin_id in the events table
5. WHEN calculating statistics THEN the system SHALL query these relationships to count admin activities
