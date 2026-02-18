# Requirements Document

## Introduction

This specification defines production improvements for the Group Module of St. John's Parish Church Entebbe management system. The improvements focus on making the group management system more dynamic, secure, and user-friendly by removing hardcoded data, enforcing authentication requirements, improving the user experience, and redesigning the admin dashboard with a modern card-based interface.

## Glossary

- **Group**: A church ministry or fellowship group that members can join
- **Member**: A registered church member with a profile in the system
- **User**: An authenticated account holder in the system
- **Admin Dashboard**: The administrative interface for managing groups and memberships
- **Homepage**: The public-facing landing page displaying available groups
- **Authentication**: The process of verifying a user's identity through login credentials
- **AJAX**: Asynchronous JavaScript and XML, a technique for updating web pages without full reload
- **Card-based UI**: A user interface design pattern using card components to display information

## Requirements

### Requirement 1

**User Story:** As a website visitor, I want to see church groups loaded dynamically from the database on the homepage, so that I always see current and accurate group information.

#### Acceptance Criteria

1. WHEN the homepage loads THEN the system SHALL retrieve all active groups from the database ordered by sort_order and name
2. WHEN displaying groups THEN the system SHALL show the member count for each group retrieved from the database
3. WHEN an admin marks a group as inactive THEN the system SHALL exclude that group from the homepage display
4. WHEN groups are displayed THEN the system SHALL show group name, description, meeting day, location, and member count
5. WHERE a group has an icon or image defined THEN the system SHALL display that visual element with the group

### Requirement 2

**User Story:** As a church administrator, I want only authenticated registered members to join groups, so that group membership is secure and properly tracked.

#### Acceptance Criteria

1. WHEN a user attempts to join a group THEN the system SHALL require authentication via the auth middleware
2. WHEN an authenticated user joins a group THEN the system SHALL use the user's linked Member record to create the membership
3. WHEN a user without a linked Member record attempts to join THEN the system SHALL display a message requiring member registration completion
4. WHEN a guest views groups THEN the system SHALL hide the join button or display a login prompt
5. WHEN the join form is rendered THEN the system SHALL not include an email input field

### Requirement 3

**User Story:** As a church member, I want a smooth and informative group joining experience, so that I understand my membership status and can join groups easily.

#### Acceptance Criteria

1. WHEN a member views a group they already belong to THEN the system SHALL display an "Already a member" indicator
2. WHEN a member joins a group they already belong to THEN the system SHALL prevent duplicate membership creation
3. WHEN a member joins a group THEN the system SHALL return JSON response for AJAX processing
4. WHEN a join request is processing THEN the system SHALL display a loading state to the user
5. WHEN a join request completes THEN the system SHALL update the UI without requiring a full page reload

### Requirement 4

**User Story:** As a church administrator, I want a modern card-based admin dashboard for managing groups, so that I can efficiently view and manage groups and their members.

#### Acceptance Criteria

1. WHEN the admin dashboard loads THEN the system SHALL display groups in a card-based grid layout instead of a table
2. WHEN displaying a group card THEN the system SHALL show name, truncated description, meeting day, location, member count, and action buttons
3. WHEN an admin wants to create or edit a group THEN the system SHALL provide a sidebar or modal interface
4. WHEN an admin views member management for a group THEN the system SHALL display members in an expandable list or modal
5. WHEN no groups exist THEN the system SHALL display an empty state message with clear call-to-action
6. WHEN an admin performs an action THEN the system SHALL display inline validation and clear success or error messages
7. WHEN the admin dashboard renders THEN the system SHALL use consistent styling with the rest of the admin area

### Requirement 5

**User Story:** As a church administrator, I want efficient member management tools within the group dashboard, so that I can easily add or remove members from groups.

#### Acceptance Criteria

1. WHEN an admin adds a member to a group THEN the system SHALL provide search and filter functionality for finding members
2. WHEN an admin views group members THEN the system SHALL display the member list in an expandable interface
3. WHEN an admin removes a member from a group THEN the system SHALL update the membership immediately
4. WHERE bulk operations are needed THEN the system SHALL provide bulk add and remove functionality
5. WHEN member management actions complete THEN the system SHALL display confirmation messages
