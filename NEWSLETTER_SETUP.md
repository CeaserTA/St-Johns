# Newsletter Subscription System - Setup & User Guide

This guide covers the complete setup and usage of the newsletter subscription system integrated with MailerLite API.

## Table of Contents

1. [Overview](#overview)
2. [MailerLite Account Setup](#mailerlite-account-setup)
3. [Environment Configuration](#environment-configuration)
4. [Features](#features)
5. [Admin Subscriber Management](#admin-subscriber-management)
6. [Testing the Integration](#testing-the-integration)
7. [Troubleshooting](#troubleshooting)
8. [API Error Reference](#api-error-reference)

---

## Overview

The newsletter subscription system allows visitors and church members to subscribe to weekly sermons and updates via email. The system integrates with MailerLite's API for robust email delivery and campaign management.

**Key Features:**
- Footer subscription form for visitors
- Automatic subscription during member registration
- Member profile subscription management
- Admin dashboard for subscriber management
- CSV export functionality
- Real-time sync with MailerLite

---

## MailerLite Account Setup

### Step 1: Create a MailerLite Account

1. Visit [MailerLite.com](https://www.mailerlite.com) and sign up for an account
2. Choose a plan that fits your needs (Free plan available for up to 1,000 subscribers)
3. Complete the account verification process

### Step 2: Generate API Key

1. Log in to your MailerLite account
2. Click on your profile icon in the top-right corner
3. Navigate to **Integrations** → **Developer API**
4. Click **Generate new token** or use an existing API key
5. Copy the API key (it looks like: `eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...`)
6. **Important:** Store this key securely - you won't be able to see it again

### Step 3: Create a Subscriber Group

1. In your MailerLite dashboard, go to **Subscribers** → **Groups**
2. Click **Create Group**
3. Name your group (e.g., "Church Newsletter" or "Weekly Sermons")
4. Click **Save**
5. Click on the group you just created
6. Look at the URL in your browser - it will look like: `https://dashboard.mailerlite.com/subscribers/groups/123456789`
7. Copy the numeric ID at the end (e.g., `123456789`) - this is your Group ID

---

## Environment Configuration

### Step 1: Update Environment Variables

1. Open your `.env` file in the project root
2. Add or update the following variables with your MailerLite credentials:

```env
# MailerLite Configuration
MAILERLITE_API_KEY=your_api_key_here
MAILERLITE_GROUP_ID=your_group_id_here
```

**Example:**
```env
MAILERLITE_API_KEY=eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiMTIzNDU2Nzg5MCIsImlhdCI6MTYxMjM0NTY3OCwibmJmIjoxNjEyMzQ1Njc4LCJleHAiOjE2NDM4ODE2NzgsInN1YiI6IjEyMzQ1Njc4OTAiLCJzY29wZXMiOltdfQ.abc123def456
MAILERLITE_GROUP_ID=123456789
```

### Step 2: Update .env.example (Optional)

If you're setting up the project for other developers, update `.env.example`:

```env
# MailerLite Configuration
MAILERLITE_API_KEY=
MAILERLITE_GROUP_ID=
```

### Step 3: Clear Configuration Cache

After updating environment variables, clear Laravel's configuration cache:

```bash
php artisan config:clear
php artisan cache:clear
```

### Step 4: Verify Configuration

You can verify your configuration is loaded correctly by running:

```bash
php artisan tinker
```

Then in the Tinker console:

```php
config('mailerlite.api_key')
config('mailerlite.group_id')
```

Both should return your configured values (not null or empty).

---

## Features

### 1. Footer Subscription Form

**Location:** Available on all public pages in the website footer

**How it works:**
- Visitors enter their email address
- Form validates email format
- Submits via AJAX for seamless experience
- Displays success/error messages without page reload
- Automatically adds subscriber to MailerLite group

**User Experience:**
- If email is already subscribed: "You are already subscribed to our newsletter"
- On success: "Thank you for subscribing! Check your email for confirmation"
- On error: User-friendly error message displayed

### 2. Member Registration Integration

**Location:** Member registration form

**How it works:**
- Newsletter subscription checkbox is checked by default
- Members can opt-out by unchecking the box
- On registration, member is added to MailerLite with:
  - Email address
  - Full name (custom field)
  - Member status: "member" (custom field)
- Local database tracks subscription status

**Benefits:**
- Seamless onboarding for new members
- Automatic segmentation (members vs visitors)
- No extra steps required

### 3. Member Profile Management

**Location:** Member dashboard → Profile settings

**How it works:**
- Members can view their current subscription status
- Toggle subscription on/off with a single click
- Changes sync immediately to MailerLite
- Database updated to reflect current status

**Features:**
- Real-time status display
- One-click subscribe/unsubscribe
- Success/error feedback

### 4. Unsubscribe Flow

**How it works:**
- Every MailerLite email includes an unsubscribe link
- Clicking the link unsubscribes via MailerLite
- Members can also unsubscribe from their profile
- Confirmation page displayed after unsubscription

---

## Admin Subscriber Management

### Accessing the Admin Interface

1. Log in as an admin user
2. Navigate to **Admin Dashboard**
3. Click **Newsletter Subscribers** in the sidebar

### Dashboard Overview

The admin interface displays three key metrics:

1. **Total Subscribers:** Total active subscribers in MailerLite
2. **Members:** Number of registered church members subscribed
3. **Visitors:** Number of non-member subscribers

### Viewing Subscribers

The subscriber list displays:
- **Email:** Subscriber's email address
- **Type:** Member or Visitor badge
- **Status:** Active, Unsubscribed, etc.
- **Subscribed Date:** When they subscribed
- **Actions:** Remove button

**Features:**
- Paginated list (25 subscribers per page)
- Real-time data from MailerLite
- Visual indicators for member vs visitor

### Searching Subscribers

1. Enter email address (or partial email) in the search box
2. Click **Search**
3. Results are filtered to match your query
4. Click **Clear Search** to view all subscribers again

### Adding Subscribers Manually

1. Click the **Add Subscriber** button
2. Enter the email address (required)
3. Optionally enter a name
4. Click **Add Subscriber**
5. Subscriber is immediately added to MailerLite

**Use Cases:**
- Adding subscribers who signed up offline
- Importing existing mailing list members
- Testing the integration

### Removing Subscribers

1. Find the subscriber in the list
2. Click the **Remove** button next to their email
3. Confirm the removal in the popup dialog
4. Subscriber is immediately removed from MailerLite

**Important:** This action cannot be undone. The subscriber will need to re-subscribe if removed by mistake.

### Exporting Subscribers

1. Click the **Export CSV** button
2. A CSV file downloads automatically
3. File includes: email, name, type, status, subscription date

**Use Cases:**
- Backup subscriber list
- Import into other systems
- Reporting and analysis
- Offline processing

**CSV Format:**
```csv
Email,Name,Type,Status,Subscribed Date
john@example.com,John Doe,member,active,2024-01-15
jane@example.com,,visitor,active,2024-01-20
```

---

## Testing the Integration

### 1. Test Footer Subscription

1. Open your website in a browser
2. Scroll to the footer
3. Enter a test email address (use a real email you can access)
4. Click **Subscribe**
5. Verify success message appears
6. Check your email for MailerLite confirmation
7. Check MailerLite dashboard to confirm subscriber was added

### 2. Test Member Registration

1. Register a new member account
2. Ensure newsletter checkbox is checked
3. Complete registration
4. Check MailerLite dashboard for the new subscriber
5. Verify custom fields (name, member_status) are populated

### 3. Test Profile Toggle

1. Log in as a member
2. Go to profile settings
3. Toggle newsletter subscription off
4. Verify success message
5. Check MailerLite dashboard - subscriber should be removed
6. Toggle back on and verify subscriber is re-added

### 4. Test Admin Management

1. Log in as admin
2. Navigate to Newsletter Subscribers
3. Verify subscriber count matches MailerLite
4. Test search functionality
5. Add a test subscriber manually
6. Export CSV and verify data
7. Remove the test subscriber

### 5. Test Error Handling

**Invalid API Key:**
1. Temporarily change `MAILERLITE_API_KEY` to an invalid value
2. Try to subscribe via footer
3. Should see: "Email service configuration error. Please contact support."
4. Check logs: `storage/logs/mailerlite.log`

**Network Error:**
1. Disconnect from internet (or block MailerLite domain)
2. Try to subscribe
3. Should see: "Unable to connect to email service. Please try again later."

---

## Troubleshooting

### Issue: "Email service configuration error"

**Cause:** Invalid or missing API credentials

**Solution:**
1. Verify `MAILERLITE_API_KEY` in `.env` is correct
2. Verify `MAILERLITE_GROUP_ID` in `.env` is correct
3. Run `php artisan config:clear`
4. Check MailerLite dashboard to ensure API key is still valid
5. Check logs: `storage/logs/mailerlite.log` for details

### Issue: "Service is busy. Please try again later."

**Cause:** MailerLite API rate limit reached (120 requests per minute)

**Solution:**
1. Wait 60 seconds and try again
2. If persistent, check for loops or bulk operations
3. Consider implementing queue for bulk operations
4. Check logs for excessive API calls

### Issue: Subscribers not appearing in admin dashboard

**Cause:** API connection issue or wrong group ID

**Solution:**
1. Verify `MAILERLITE_GROUP_ID` matches your MailerLite group
2. Check MailerLite dashboard - subscribers should be there
3. Check logs: `storage/logs/mailerlite.log`
4. Test API connection: `php artisan tinker` then:
   ```php
   $service = app(\App\Services\MailerLiteService::class);
   $service->getSubscriberCount();
   ```

### Issue: "Already subscribed" message for new subscribers

**Cause:** Email already exists in MailerLite group

**Solution:**
1. Check MailerLite dashboard for the email
2. If subscriber should be removed, use admin interface to remove them
3. If subscriber is in a different status (unsubscribed), they need to resubscribe via MailerLite's reactivation flow

### Issue: Duplicate subscriptions

**Cause:** Multiple form submissions or race conditions

**Solution:**
1. System handles duplicates gracefully - no action needed
2. MailerLite prevents actual duplicates
3. User sees "already subscribed" message on subsequent attempts

### Issue: Member subscription status out of sync

**Cause:** Direct changes in MailerLite dashboard not reflected in database

**Solution:**
1. Member database tracks local preference
2. MailerLite is the source of truth for actual subscription
3. If out of sync, member can toggle subscription in profile to re-sync
4. Consider implementing webhook to receive MailerLite updates (future enhancement)

### Issue: CSV export is empty

**Cause:** No subscribers in the group or API connection issue

**Solution:**
1. Verify subscribers exist in MailerLite dashboard
2. Check `MAILERLITE_GROUP_ID` is correct
3. Check logs: `storage/logs/mailerlite.log`
4. Test API connection as described above

### Checking Logs

All MailerLite operations are logged to `storage/logs/mailerlite.log`:

```bash
# View recent logs
tail -f storage/logs/mailerlite.log

# Search for errors
grep "error" storage/logs/mailerlite.log

# Search for specific email
grep "john@example.com" storage/logs/mailerlite.log
```

**Log Levels:**
- `info`: Successful operations
- `warning`: Rate limits, retries
- `error`: API failures, validation errors
- `critical`: Authentication failures, configuration errors

---

## API Error Reference

### Common HTTP Status Codes

| Status Code | Error Type | User Message | Admin Action |
|-------------|------------|--------------|--------------|
| 400 | Bad Request / Validation Error | "Invalid email address" or specific field error | Check request data format |
| 401 | Unauthorized | "Email service configuration error. Please contact support." | Verify API key is correct and active |
| 404 | Not Found | "Subscriber not found" | Normal for checking if subscriber exists |
| 429 | Rate Limit Exceeded | "Service is busy. Please try again in X seconds." | Wait for rate limit reset, check for excessive requests |
| 500 | Internal Server Error | "Email service is temporarily unavailable. Please try again later." | Check MailerLite status page, retry later |
| 502/503/504 | Server Errors | "Email service is temporarily unavailable. Please try again later." | MailerLite infrastructure issue, retry later |

### Error Response Examples

**Validation Error (400):**
```json
{
  "error": {
    "message": "The email field is required.",
    "code": 400
  }
}
```

**Authentication Error (401):**
```json
{
  "error": {
    "message": "Invalid API key",
    "code": 401
  }
}
```

**Rate Limit Error (429):**
```
HTTP/1.1 429 Too Many Requests
Retry-After: 60
```

### Network Errors

**Connection Timeout:**
- **User Message:** "Unable to connect to email service. Please try again later."
- **Cause:** Network connectivity issue or MailerLite API is down
- **Solution:** Check internet connection, verify MailerLite status

**DNS Resolution Failure:**
- **User Message:** "Unable to connect to email service. Please try again later."
- **Cause:** Cannot resolve api.mailerlite.com
- **Solution:** Check DNS settings, verify network configuration

---

## Best Practices

### Security

1. **Never commit API keys:** Always use environment variables
2. **Rotate API keys:** Periodically generate new keys in MailerLite
3. **Monitor logs:** Regularly check for authentication failures
4. **Rate limiting:** Public endpoints have rate limiting to prevent abuse

### Performance

1. **Caching:** Subscriber count is cached for 5 minutes
2. **Pagination:** Admin interface paginates large subscriber lists
3. **Async operations:** Consider using queues for bulk operations
4. **Timeouts:** API requests timeout after 30 seconds

### Data Management

1. **MailerLite is source of truth:** Always defer to MailerLite data
2. **Regular exports:** Periodically export subscriber list as backup
3. **Clean data:** Remove test subscribers before going live
4. **Segmentation:** Use custom fields to segment members vs visitors

### Monitoring

1. **Check logs daily:** Review `storage/logs/mailerlite.log`
2. **Monitor subscriber count:** Track growth trends
3. **Test regularly:** Periodically test all subscription flows
4. **Alert on errors:** Set up alerts for critical errors

---

## Additional Resources

- [MailerLite API Documentation](https://developers.mailerlite.com/docs)
- [MailerLite Support](https://www.mailerlite.com/help)
- [MailerLite Status Page](https://status.mailerlite.com)

---

## Support

For technical issues with the integration:
1. Check this troubleshooting guide
2. Review logs in `storage/logs/mailerlite.log`
3. Contact your system administrator

For MailerLite account issues:
1. Visit [MailerLite Help Center](https://www.mailerlite.com/help)
2. Contact MailerLite support directly

---

**Last Updated:** January 2024
**Version:** 1.0
