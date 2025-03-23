<?php

use munkireport\models\MRModel as Eloquent;

class Jamf_connect_model extends Eloquent
{
    protected $table = 'jamf_connect';

    protected $hidden = ['id', 'serial_number'];

    protected $fillable = [
      'serial_number',
      'display_name',
      'jamf_connect_id',
      'password_last_changed',
      'first_name',
      'last_name',
      'locale',
      'login',
      'time_zone',
      'last_analytics_checkin',
      'last_sign_in',
      'last_license_check',
      'password_current',
      'version',
      'expiration_warning_last',
      'first_run_done',
      'last_certificate_expiration',
      'last_totp_notification',
      'offline_mfa_setup_success',
      'password_expiration_remaining_days',
      'unsent_offline_mfa_events',
      'user_login_name'
    ];
}
