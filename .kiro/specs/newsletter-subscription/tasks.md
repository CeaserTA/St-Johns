# Newsletter Subscription System - Implementation Plan

- [x] 1. Set up MailerLite configuration and service foundation





  - Add MailerLite API key and group ID to .env.example
  - Create config/mailerlite.php configuration file
  - Install Guzzle HTTP client if not already present
  - _Requirements: 9.1, 9.2_

- [x] 2. Implement MailerLiteService core functionality





  - Create app/Services/MailerLiteService.php with constructor and HTTP client setup
  - Implement subscribe() method to add subscribers via API
  - Implement unsubscribe() method to remove subscribers via API
  - Implement getSubscriber() method to fetch subscriber details
  - Implement getAllSubscribers() method with pagination support
  - Implement getSubscriberCount() method
  - Implement updateSubscriber() method for updating custom fields
  - Implement private makeRequest() method for API calls with error handling
  - Add comprehensive error handling for network, authentication, rate limiting, and validation errors
  - _Requirements: 1.2, 1.5, 3.2, 5.2, 6.1, 7.1, 7.2, 7.3, 9.3, 9.4, 9.5_

- [x] 2.1 Write property test for API authentication






  - **Property 8: API authentication**
  - **Validates: Requirements 9.3**

- [x] 2.2 Write unit tests for MailerLiteService






  - Test API request construction with correct headers
  - Test response parsing for success and error cases
  - Test error handling for various HTTP status codes
  - Mock HTTP client to avoid actual API calls
  - _Requirements: 1.2, 3.2, 5.2, 9.3_

- [x] 3. Add newsletter fields to Member model and database





  - Create migration to add newsletter_subscribed and newsletter_subscribed_at columns to members table
  - Update Member model fillable and casts arrays
  - Implement subscribeToNewsletter() method in Member model
  - Implement unsubscribeFromNewsletter() method in Member model
  - Implement isSubscribedToNewsletter() method in Member model
  - _Requirements: 3.1, 5.4_

- [x] 3.1 Write unit tests for Member newsletter methods






  - Test subscribeToNewsletter() updates correct fields
  - Test unsubscribeFromNewsletter() updates correct fields
  - Test timestamp updates on subscription changes
  - _Requirements: 3.1, 5.4_

- [x] 4. Create public SubscriptionController for footer form





  - Create app/Http/Controllers/SubscriptionController.php
  - Implement subscribe() method with email validation
  - Implement unsubscribe() method for handling unsubscribe requests
  - Implement confirmUnsubscribe() method to show unsubscribe confirmation page
  - Add validation rules for email format
  - Handle duplicate subscription attempts gracefully
  - Return appropriate JSON responses for AJAX requests
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 5.2, 5.3_

- [x] 4.1 Write property test for email validation






  - **Property 1: Email validation correctness**
  - **Validates: Requirements 1.1**

- [x] 4.2 Write property test for duplicate subscription handling





  - **Property 2: Duplicate subscription idempotency**
  - **Validates: Requirements 1.3**

- [x] 4.3 Write unit tests for SubscriptionController






  - Test request validation rules
  - Test response formatting for success and error cases
  - Test error message display
  - Mock MailerLiteService to isolate controller logic
  - _Requirements: 1.1, 1.3, 1.4, 1.5_

- [x] 5. Add subscription routes





  - Add POST route for /subscribe endpoint
  - Add GET route for /unsubscribe/{email} endpoint
  - Add POST route for /unsubscribe endpoint
  - Apply rate limiting middleware to prevent abuse
  - _Requirements: 1.1, 5.2_

- [x] 6. Create footer subscription form





  - Add newsletter subscription form to footer partial
  - Include email input field with validation
  - Add CSRF token for security
  - Implement JavaScript for AJAX form submission
  - Display success/error messages dynamically
  - Add loading state during submission
  - _Requirements: 1.1, 1.4, 1.5_

- [x] 7. Create unsubscribe confirmation page




  - Create resources/views/newsletter/unsubscribe.blade.php
  - Display confirmation message after unsubscription
  - Include option to resubscribe
  - Match church website styling
  - _Requirements: 5.3_

- [x] 8. Update member registration to include newsletter subscription





  - Add newsletter subscription checkbox to registration form (checked by default)
  - Update MemberController store() method to handle newsletter preference
  - Implement syncNewsletterSubscription() private method in MemberController
  - Sync to MailerLite with member name and status as custom fields
  - Update member record with subscription status
  - _Requirements: 2.1, 2.2, 2.3, 2.4_

- [x] 8.1 Write property test for member metadata sync






  - **Property 3: Member metadata sync**
  - **Validates: Requirements 2.4**

- [x] 8.2 Write unit tests for registration newsletter flow






  - Test checkbox default state
  - Test subscription when checkbox is checked
  - Test no subscription when checkbox is unchecked
  - Mock MailerLiteService
  - _Requirements: 2.1, 2.2, 2.3_

- [x] 9. Add newsletter subscription toggle to member profile





  - Add newsletter subscription toggle to member profile settings page
  - Update MemberController update() method to handle newsletter preference changes
  - Sync subscription changes to MailerLite in real-time
  - Update member database record
  - Display current subscription status
  - Show success/error messages for toggle actions
  - _Requirements: 3.1, 3.2, 3.3, 3.4_

- [x] 9.1 Write property test for subscription state consistency






  - **Property 4: Subscription state consistency**
  - **Validates: Requirements 3.2, 5.2, 5.4, 8.2**

- [x] 9.2 Write unit tests for profile subscription toggle






  - Test subscription toggle updates member record
  - Test API sync on subscription changes
  - Test error handling for failed API calls
  - Mock MailerLiteService
  - _Requirements: 3.2, 3.3, 3.4_

- [x] 10. Checkpoint - Ensure all tests pass





  - Ensure all tests pass, ask the user if questions arise.

- [x] 11. Create admin subscribers management interface





  - Create app/Http/Controllers/Admin/SubscriptionController.php
  - Implement index() method to display all subscribers from MailerLite
  - Implement store() method for manually adding subscribers
  - Implement destroy() method for removing subscribers
  - Implement export() method for CSV export
  - Add search functionality to filter by email
  - Display subscriber count from MailerLite
  - Add pagination for subscriber list
  - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 7.1, 7.2, 7.3_

- [ ]* 11.1 Write property test for search result filtering
  - **Property 5: Search result filtering**
  - **Validates: Requirements 6.3**

- [ ]* 11.2 Write property test for subscriber display completeness
  - **Property 6: Subscriber display completeness**
  - **Validates: Requirements 6.2**

- [ ]* 11.3 Write property test for admin operations sync
  - **Property 7: Admin operations sync**
  - **Validates: Requirements 7.1, 7.2, 7.3**

- [ ]* 11.4 Write unit tests for Admin/SubscriptionController
  - Test subscriber list display
  - Test search functionality
  - Test manual add/remove operations
  - Test CSV export generation
  - Mock MailerLiteService
  - _Requirements: 6.1, 6.3, 6.4, 7.1, 7.2_

- [x] 12. Create admin subscribers view




  - Create resources/views/admin/subscribers/index.blade.php
  - Display subscriber list with email, date, status, and type
  - Add search form for filtering by email
  - Add "Add Subscriber" button and modal
  - Add "Remove" button for each subscriber
  - Add "Export CSV" button
  - Display total subscriber count
  - Implement pagination controls
  - Match admin dashboard styling
  - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5, 7.1, 7.2_

- [x] 13. Add admin routes for subscriber management









  - Add GET route for /admin/subscribers
  - Add POST route for /admin/subscribers (manual add)
  - Add DELETE route for /admin/subscribers/{email}
  - Add GET route for /admin/subscribers/export
  - Apply admin authentication middleware
  - _Requirements: 6.1, 7.1, 7.2_

- [x] 14. Add navigation link to admin dashboard







  - Add "Newsletter Subscribers" link to admin navigation menu
  - Add icon for newsletter section
  - Update active state highlighting
  - _Requirements: 6.1_

- [x] 15. Implement error logging and monitoring







  - Configure Laravel logging for MailerLite operations
  - Log all API requests and responses (with sensitive data redacted)
  - Log subscription/unsubscription events
  - Log API errors and failures
  - Set appropriate log levels (info, warning, error, critical)
  - _Requirements: 1.5, 9.4, 9.5_

- [x] 16. Add rate limiting to public endpoints
  - Configure rate limiting for /subscribe endpoint (e.g., 5 attempts per minute per IP)
  - Add rate limiting middleware to routes
  - Display appropriate error message when rate limit exceeded
  - _Requirements: 1.5_

- [x] 17. Final Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [x] 18. Create documentation
  - Document MailerLite setup process in README
  - Document environment variable configuration
  - Document admin subscriber management features
  - Include troubleshooting guide for common API errors
  - _Requirements: 9.1, 9.2_
