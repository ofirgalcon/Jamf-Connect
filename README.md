Jamf Connect Module
===================

Gets data about the current user's Jamf Connect status.

Table Schema
----

* display_name - VARCHAR(255) - Display name
* jamf_connect_id - VARCHAR(255) - Jamf Connect ID
* password_last_changed - VARCHAR(255) - Password last changed
* first_name - VARCHAR(255) - First name
* last_name - VARCHAR(255) - Last name
* locale - VARCHAR(255) - Locale
* login - VARCHAR(255) - Login
* time_zone - VARCHAR(255) - Time zone
* last_analytics_checkin - VARCHAR(255) - Last analytics checkin
* last_sign_in - VARCHAR(255) - Last sign in
* last_license_check - VARCHAR(255) - Last license check
* password_current - VARCHAR(255) - Password current
* version - VARCHAR(255) - Application verion

Slack Alerts
----

The module can send Slack alerts when Jamf Connect password current status changes. Alerts are triggered for:

* Password current status changes (when a password transitions from current to not current, or vice versa)

The module collects data about password expiration warnings and remaining days, but does not currently send Slack alerts for these values.

To enable alerts, add the following to your .env file:
```bash
SLACK_ENABLE=true
SLACK_ORG=your_slack_org_id
SLACK_CHANNEL=your_slack_channel_id
SLACK_TOKEN=your_slack_token
```

See the [Slack Notifications documentation](../../../docs/slack_notifications.md) for more details.

> **Note:** The module expects the Slack helper file to be located at `app/helpers/slack_helper.php` relative to the MunkiReport root directory. If alerts aren't working, verify this file exists and is accessible.
