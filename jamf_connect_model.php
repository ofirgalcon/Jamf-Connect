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

    ];
}
