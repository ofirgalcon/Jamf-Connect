<?php

use munkireport\processors\Processor;

class Jamf_connect_processor extends Processor
{
    public function run($data)
    {
        $modelData = ['serial_number' => $this->serial_number];

        // Get previous record to check for changes
        $previousRecord = Jamf_connect_model::where('serial_number', $this->serial_number)->first();
        $previousPasswordState = $previousRecord ? $previousRecord->password_current : null;

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
                        'offline_mfa_setup_success',
                        'password_current'
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
                        'offline_mfa_setup_success',
                        'password_current'
                    ])) {
                        $modelData[$key] = strtolower($val) === 'true' || $val === '1' ? 1 : 0;
                    } else {
                        $modelData[$key] = $val;
                    }
                }
            }
		} //end foreach explode lines

        // Update or create the model
        Jamf_connect_model::updateOrCreate(
            ['serial_number' => $this->serial_number], $modelData
        );
        
        // Check if we need to send a Slack notification for password state changes
        $this->checkPasswordStateChanges(
            $previousPasswordState, 
            $modelData['password_current'] ?? null,
            $modelData
        );
        
        return $this;
    }
    
    /**
     * Check if password state has changed and notify if needed
     * 
     * @param int|null $previousState Previous password_current value
     * @param int|null $currentState Current password_current value
     * @param array $modelData All model data for additional context
     * @return void
     */
    private function checkPasswordStateChanges($previousState, $currentState, $modelData)
    {
        // If this is the first check-in, don't alert
        if ($previousState === null) {
            return;
        }
        
        // Ensure consistent types for comparison
        $previousState = (int)$previousState;
        $currentState = (int)$currentState;
        
        // Check for password state changes only
        $passwordStateChanged = $previousState !== $currentState;
        
        // Only notify if password state changed
        if ($passwordStateChanged) {
            // Get user information
            $displayName = $modelData['display_name'] ?? 'Unknown User';
            $firstName = $modelData['first_name'] ?? '';
            $lastName = $modelData['last_name'] ?? '';
            $login = $modelData['login'] ?? '';
            
            // Format user name
            $userName = $displayName;
            if ($firstName && $lastName) {
                $userName = "{$firstName} {$lastName} ({$login})";
            }
            
            // Determine status change direction
            $statusMessage = $currentState ? 'Password is now current' : 'Password is no longer current';
            
            // Log the change to help with debugging
            error_log("Jamf Connect password state change detected for {$this->serial_number}: {$statusMessage}");
            
            // Create event data
            $eventData = json_encode([
                'user_name' => $userName,
                'status_message' => $statusMessage,
                'previous_state' => $previousState ? 'current' : 'not current',
                'current_state' => $currentState ? 'current' : 'not current',
                'login' => $login,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
            // Store the event with appropriate type based on password state
            $eventType = $currentState ? 'success' : 'danger';
            
            // Use store_event to record this event - will trigger notification based on config
            $this->store_event($eventType, 'jamf_connect_password_state_change', $eventData);
        }
    }
}
