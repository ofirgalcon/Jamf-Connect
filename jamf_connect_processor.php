<?php

use munkireport\processors\Processor;

class Jamf_connect_processor extends Processor
{
    public function run($data)
    {
        $modelData = ['serial_number' => $this->serial_number];

		// Parse data
        $sep = ' = ';
		foreach(explode(PHP_EOL, $data) as $line) {
            if($line){
                list($key, $val) = explode($sep, $line);
                
                // Handle empty values
                if (empty($val)) {
                    // For timestamp fields, set to null
                    if (in_array($key, [
                        'expiration_warning_last',
                        'last_certificate_expiration',
                        'last_totp_notification'
                    ])) {
                        $modelData[$key] = null;
                    }
                    // For boolean fields, set to 0
                    else if (in_array($key, [
                        'first_run_done',
                        'offline_mfa_setup_success'
                    ])) {
                        $modelData[$key] = 0;
                    }
                    // For integer fields, set to 0
                    else if (in_array($key, [
                        'password_expiration_remaining_days',
                        'unsent_offline_mfa_events'
                    ])) {
                        $modelData[$key] = 0;
                    }
                    // For string fields, set to empty string
                    else {
                        $modelData[$key] = '';
                    }
                } else {
                    // Convert boolean values to 0/1
                    if (in_array($key, [
                        'first_run_done',
                        'offline_mfa_setup_success'
                    ])) {
                        $modelData[$key] = strtolower($val) === 'true' || $val === '1' ? 1 : 0;
                    } else {
                        $modelData[$key] = $val;
                    }
                }
            }
		} //end foreach explode lines

        Jamf_connect_model::updateOrCreate(
            ['serial_number' => $this->serial_number], $modelData
        );
        
        return $this;
    }   
}
