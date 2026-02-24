<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MailerLite API Key
    |--------------------------------------------------------------------------
    |
    | This is your MailerLite API key used to authenticate requests to the
    | MailerLite API. You can find this in your MailerLite account settings
    | under Integrations > Developer API.
    |
    */

    'api_key' => env('MAILERLITE_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | MailerLite Group ID
    |--------------------------------------------------------------------------
    |
    | This is the ID of the MailerLite group (subscriber list) where new
    | subscribers will be added. You can find this in your MailerLite
    | account under Subscribers > Groups.
    |
    */

    'group_id' => env('MAILERLITE_GROUP_ID'),

    /*
    |--------------------------------------------------------------------------
    | MailerLite API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the MailerLite API. This should not need to be changed
    | unless MailerLite updates their API endpoint.
    |
    */

    'api_base_url' => 'https://api.mailerlite.com/api/v2/',

];
