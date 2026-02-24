# Newsletter Subscription System - Requirements

## Introduction

This document outlines the requirements for implementing a newsletter subscription system that allows visitors and members to receive weekly sermons and church updates via email. The system integrates with MailerLite API for subscriber management and email delivery.

## Glossary

- **Newsletter System**: The system that manages email subscriptions for weekly sermons and updates
- **Subscriber**: A person who has opted in to receive newsletters (can be a visitor or member)
- **Member**: A registered church member with an account in the system
- **Visitor**: A non-registered person who subscribes via the footer form
- **Subscription**: The act of opting in to receive newsletters
- **Unsubscribe**: The act of opting out from receiving newsletters
- **MailerLite**: The email marketing service provider used to manage subscribers and send newsletters
- **MailerLite API**: The REST API used to sync subscribers between the church system and MailerLite
- **Group**: A MailerLite collection of subscribers (e.g., "Church Newsletter")

## Requirements

### Requirement 1

**User Story:** As a website visitor, I want to subscribe to weekly sermons and updates, so that I can stay connected with the church.

#### Acceptance Criteria

1. WHEN a visitor enters their email in the footer subscription form THEN the Newsletter System SHALL validate the email format
2. WHEN a visitor submits a valid email THEN the Newsletter System SHALL add the subscriber to MailerLite via the API
3. WHEN a visitor submits an email that is already subscribed THEN the Newsletter System SHALL inform them they are already subscribed
4. WHEN a subscription is successful THEN the Newsletter System SHALL display a success message
5. WHEN the MailerLite API request fails THEN the Newsletter System SHALL display an appropriate error message and log the failure

### Requirement 2

**User Story:** As a new church member, I want to be automatically subscribed to newsletters during registration, so that I stay informed without extra steps.

#### Acceptance Criteria

1. WHEN a new member registers THEN the Newsletter System SHALL display a checked checkbox to subscribe to newsletters
2. WHEN a member unchecks the newsletter checkbox during registration THEN the Newsletter System SHALL not subscribe them
3. WHEN a member completes registration with the checkbox checked THEN the Newsletter System SHALL add them to MailerLite via the API
4. WHEN a member is subscribed during registration THEN the Newsletter System SHALL include their name and member status as custom fields in MailerLite

### Requirement 3

**User Story:** As a registered member, I want to manage my newsletter subscription from my profile, so that I can control what emails I receive.

#### Acceptance Criteria

1. WHEN a member views their profile settings THEN the Newsletter System SHALL display their current subscription status
2. WHEN a member toggles their subscription preference THEN the Newsletter System SHALL update their status in MailerLite via the API
3. WHEN a member subscribes via profile settings THEN the Newsletter System SHALL add them to the MailerLite group
4. WHEN a member unsubscribes via profile settings THEN the Newsletter System SHALL remove them from the MailerLite group or mark them as unsubscribed

### Requirement 4

**User Story:** As a subscriber, I want to receive a confirmation email, so that I know my subscription was successful.

#### Acceptance Criteria

1. WHEN a new subscription is created THEN MailerLite SHALL send an automated welcome email to the subscriber
2. WHEN the welcome email is sent THEN it SHALL include an unsubscribe link managed by MailerLite
3. WHEN the MailerLite API request succeeds THEN the Newsletter System SHALL display a success message
4. WHEN a subscriber unsubscribes THEN MailerLite SHALL send an automated farewell email confirming the unsubscription

### Requirement 5

**User Story:** As a subscriber, I want to unsubscribe from newsletters, so that I can stop receiving emails when I choose.

#### Acceptance Criteria

1. WHEN a subscriber clicks the unsubscribe link in a MailerLite email THEN MailerLite SHALL mark their subscription as unsubscribed
2. WHEN a subscriber unsubscribes via the website THEN the Newsletter System SHALL update their status in MailerLite via the API
3. WHEN a subscriber unsubscribes THEN the Newsletter System SHALL display a confirmation message
4. WHEN a previously subscribed member unsubscribes THEN the Newsletter System SHALL update their member record to reflect the unsubscribed status

### Requirement 6

**User Story:** As an admin, I want to view all newsletter subscribers, so that I can manage the mailing list.

#### Acceptance Criteria

1. WHEN an admin accesses the subscribers page THEN the Newsletter System SHALL fetch and display all subscribers from MailerLite via the API
2. WHEN displaying subscribers THEN the Newsletter System SHALL show email, subscription date, status, and subscriber type (member or visitor)
3. WHEN an admin searches for a subscriber THEN the Newsletter System SHALL filter the list by email
4. WHEN an admin exports subscribers THEN the Newsletter System SHALL generate a CSV file with all subscriber data from MailerLite
5. WHEN displaying the subscriber count THEN the Newsletter System SHALL show the total count from the MailerLite group

### Requirement 7

**User Story:** As an admin, I want to manually add or remove subscribers, so that I can manage the list effectively.

#### Acceptance Criteria

1. WHEN an admin adds a subscriber manually THEN the Newsletter System SHALL validate the email and add it to MailerLite via the API
2. WHEN an admin removes a subscriber THEN the Newsletter System SHALL remove them from MailerLite via the API
3. WHEN an admin reactivates a subscriber THEN the Newsletter System SHALL add them back to the MailerLite group via the API

### Requirement 8

**User Story:** As an admin, I want to send newsletters to all active subscribers via MailerLite, so that I can share sermons and updates.

#### Acceptance Criteria

1. WHEN an admin wants to send a newsletter THEN they SHALL use the MailerLite dashboard to compose and send campaigns
2. WHEN subscribers are managed in the church system THEN the Newsletter System SHALL sync them to MailerLite in real-time via the API
3. WHEN a newsletter campaign is sent from MailerLite THEN it SHALL automatically include all active subscribers in the designated group
4. WHEN each newsletter email is sent THEN MailerLite SHALL automatically include an unsubscribe link in the footer
5. WHEN an admin views campaign statistics THEN they SHALL access them through the MailerLite dashboard

### Requirement 9

**User Story:** As a system administrator, I want to configure MailerLite API credentials, so that the integration works securely.

#### Acceptance Criteria

1. WHEN the system is configured THEN the Newsletter System SHALL store the MailerLite API key in environment variables
2. WHEN the system is configured THEN the Newsletter System SHALL store the MailerLite group ID in environment variables
3. WHEN making API requests THEN the Newsletter System SHALL authenticate using the stored API key
4. WHEN API credentials are invalid THEN the Newsletter System SHALL log the error and display a user-friendly message
5. WHEN API rate limits are reached THEN the Newsletter System SHALL handle the error gracefully and retry after the specified time
