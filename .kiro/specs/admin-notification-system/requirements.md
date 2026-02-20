# Requirements Document

## Introduction

This document outlines the requirements for implementing a comprehensive admin notification system for the St. John's Parish Church management system. The system will notify administrators of important activities and events occurring within the application.

## Glossary

- **Admin**: A user with administrative privileges who manages the church system
- **Notification**: A message alerting an admin about a specific event or activity
- **Notification Center**: The UI component displaying notifications to admins
- **Unread Count**: The number of notifications that have not been marked as read
- **System**: The St. John's Parish Church management application

## Requirements

### Requirement 1

**User Story:** As an admin, I want to receive notifications for new member registrations, so that I can promptly review and welcome new members.

#### Acceptance Criteria

1. WHEN a new member registers THEN the System SHALL create a notification for all admin users
2. WHEN a member registration notification is created THEN the System SHALL include the member's name and registration timestamp
3. WHEN an admin views the notification THEN the System SHALL provide a link to view the member's profile
4. WHEN a member creates an account linked to their profile THEN the System SHALL create a separate notification for account creation

### Requirement 2

**User Story:** As an admin, I want to receive notifications for service registrations, so that I can track and manage service bookings.

#### Acceptance Criteria

1. WHEN a member registers for a service THEN the System SHALL create a notification for all admin users
2. WHEN a service registration notification is created THEN the System SHALL include the service name, member name, and registration date
3. WHEN an admin views the notification THEN the System SHALL provide a link to view the registration details
4. WHEN a service registration payment is submitted THEN the System SHALL create a notification for payment verification

### Requirement 3

**User Story:** As an admin, I want to receive notifications for giving submissions, so that I can verify and confirm contributions promptly.

#### Acceptance Criteria

1. WHEN a giving is submitted THEN the System SHALL create a notification for all admin users
2. WHEN a giving notification is created THEN the System SHALL include the giving type, amount, payment method, and giver name
3. WHEN an admin views the notification THEN the System SHALL provide a link to view and confirm the giving
4. WHEN a giving includes a transaction reference THEN the System SHALL include it in the notification

### Requirement 4

**User Story:** As an admin, I want to receive notifications for group join requests, so that I can approve or manage group memberships.

#### Acceptance Criteria

1. WHEN a member joins a group THEN the System SHALL create a notification for all admin users
2. WHEN a group join notification is created THEN the System SHALL include the group name and member name
3. WHEN an admin views the notification THEN the System SHALL provide a link to view the group membership details

### Requirement 5

**User Story:** As an admin, I want to see a notification icon with an unread count, so that I know when new notifications are available.

#### Acceptance Criteria

1. WHEN the admin dashboard loads THEN the System SHALL display a notification icon in the navigation bar
2. WHEN unread notifications exist THEN the System SHALL display the count as a badge on the notification icon
3. WHEN no unread notifications exist THEN the System SHALL display the icon without a badge
4. WHEN new notifications arrive THEN the System SHALL update the unread count dynamically

### Requirement 6

**User Story:** As an admin, I want to view a dropdown of recent notifications when hovering on the notification icon, so that I can quickly see recent activity.

#### Acceptance Criteria

1. WHEN an admin hovers over the notification icon THEN the System SHALL display a dropdown panel with recent notifications
2. WHEN the notification dropdown is displayed THEN the System SHALL show the 10 most recent notifications
3. WHEN a notification is displayed in the dropdown THEN the System SHALL show the notification type, message, and timestamp
4. WHEN an admin clicks a notification THEN the System SHALL navigate to the relevant page and mark the notification as read

### Requirement 7

**User Story:** As an admin, I want to mark all notifications as read, so that I can clear my notification list efficiently.

#### Acceptance Criteria

1. WHEN the notification dropdown is displayed THEN the System SHALL show a "Mark All as Read" button
2. WHEN an admin clicks "Mark All as Read" THEN the System SHALL mark all unread notifications as read
3. WHEN all notifications are marked as read THEN the System SHALL update the unread count to zero
4. WHEN notifications are marked as read THEN the System SHALL update the UI immediately without page reload

### Requirement 8

**User Story:** As an admin, I want notifications to be timestamped with relative time, so that I can understand when events occurred.

#### Acceptance Criteria

1. WHEN a notification is displayed THEN the System SHALL show a relative timestamp (e.g., "2 minutes ago", "1 hour ago")
2. WHEN a notification is older than 24 hours THEN the System SHALL show the date (e.g., "Jan 15")
3. WHEN a notification is older than 1 year THEN the System SHALL show the full date (e.g., "Jan 15, 2024")

### Requirement 9

**User Story:** As an admin, I want notifications to have distinct icons and colors based on type, so that I can quickly identify notification categories.

#### Acceptance Criteria

1. WHEN a notification is displayed THEN the System SHALL show an icon representing the notification type
2. WHEN displaying member-related notifications THEN the System SHALL use a person icon
3. WHEN displaying giving-related notifications THEN the System SHALL use a money/gift icon
4. WHEN displaying service-related notifications THEN the System SHALL use a calendar/service icon
5. WHEN displaying group-related notifications THEN the System SHALL use a group/people icon

### Requirement 10

**User Story:** As a system, I want to automatically create notifications for critical events, so that admins stay informed without manual intervention.

#### Acceptance Criteria

1. WHEN a critical event occurs THEN the System SHALL create notifications asynchronously without blocking the main operation
2. WHEN notification creation fails THEN the System SHALL log the error without affecting the main operation
3. WHEN multiple admins exist THEN the System SHALL create individual notification records for each admin
4. WHEN a notification is created THEN the System SHALL store the event type, message, related entity ID, and timestamp
