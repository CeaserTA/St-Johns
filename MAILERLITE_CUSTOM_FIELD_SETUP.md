# MailerLite Custom Field Setup

## Issue
Members are showing as "Visitor" instead of "Member" in the admin subscribers dashboard because the `member_status` custom field doesn't exist in MailerLite.

## Solution

### Option 1: Create Field Manually in MailerLite Dashboard (Recommended)

1. Log in to your MailerLite account at https://dashboard.mailerlite.com
2. Go to **Subscribers** → **Fields**
3. Click **Create Field**
4. Enter the following details:
   - **Field name**: `member_status`
   - **Field type**: Text
5. Click **Save**

### Option 2: Create Field via API

Run this command in your terminal:

```bash
php artisan tinker
```

Then execute:

```php
$service = app(\App\Services\MailerLiteService::class);

// Create the member_status custom field
$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . config('mailerlite.api_key'),
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
])->post('https://connect.mailerlite.com/api/fields', [
    'name' => 'member_status',
    'type' => 'text'
]);

echo "Response: " . $response->status() . "\n";
echo $response->body();
```

## After Creating the Field

Once the `member_status` field is created in MailerLite:

1. **New registrations** will automatically have `member_status` set to "member"
2. **Existing subscribers** will need to be updated. You can either:
   - Have them toggle their newsletter subscription off and on again in profile settings
   - Or run a bulk update script (see below)

### Bulk Update Existing Subscribers

To update all existing members who are subscribed:

```bash
php artisan tinker
```

```php
$service = app(\App\Services\MailerLiteService::class);
$members = \App\Models\Member::where('newsletter_subscribed', true)->get();

foreach ($members as $member) {
    try {
        $service->updateSubscriber($member->email, [
            'member_status' => 'member'
        ]);
        echo "Updated: {$member->email}\n";
    } catch (\Exception $e) {
        echo "Failed: {$member->email} - {$e->getMessage()}\n";
    }
}

echo "Done!\n";
```

## Verification

After setup, verify the field exists:

1. Go to MailerLite Dashboard → Subscribers → Fields
2. You should see `member_status` in the list
3. Register a new member with newsletter subscription checked
4. Check the admin subscribers dashboard - the type should now show "Member"

## Troubleshooting

If members still show as "Visitor":

1. Check that the `member_status` field exists in MailerLite
2. Check the Laravel logs: `storage/logs/mailerlite.log`
3. Verify the field name is exactly `member_status` (case-sensitive)
4. Try unsubscribing and re-subscribing a test member
