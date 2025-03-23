#!/bin/bash

# Script to collect data
# and put the data into outputfile

CWD=$(dirname $0)
CACHEDIR="$CWD/cache/"
OUTPUT_FILE="${CACHEDIR}jamf_connect.txt"
SEPARATOR=' = '

# Get the data
#Get current signed in user
 currentUser=$(ls -l /dev/console | awk '/ / { print $3 }')

# get uid logged in user
uid=$(id -u "${currentUser}")

if (( uid < 501 )); then
    exit 
fi

#com.jamf.connect.state.plist location
jamfConnectStateFile=/Users/$currentUser/Library/Preferences/com.jamf.connect.state.plist

if [ -f $jamfConnectStateFile ]; then
    echo "Jamf Connect exists"
else
    echo "Jamf Connect not found. Skipping"
    if [ -f $OUTPUT_FILE ]; then
        rm $OUTPUT_FILE
    fi
    exit 0
fi

# Business logic goes here
# Replace 'echo' in the following lines with the data collection commands for your module.
DISPLAY_NAME=$(defaults read $jamfConnectStateFile DisplayName 2>/dev/null) || exit 0
JAMF_CONNECT_ID=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:id" "$jamfConnectStateFile" 2>/dev/null)
PASSWORD_LAST_CHANGED=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:passwordChanged" "$jamfConnectStateFile" 2>/dev/null)
FIRST_NAME=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:firstName" "$jamfConnectStateFile" 2>/dev/null)
LAST_NAME=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:lastName" "$jamfConnectStateFile" 2>/dev/null)
LOCALE=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:locale" "$jamfConnectStateFile" 2>/dev/null)
LOGIN=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:login" "$jamfConnectStateFile" 2>/dev/null)
TIME_ZONE=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:timeZone" "$jamfConnectStateFile" 2>/dev/null)
LAST_ANALYTICS_CHECKIN=$(defaults read $jamfConnectStateFile LastPreferenceAnalyticsCheckIn 2>/dev/null)
LAST_SIGN_IN=$(defaults read $jamfConnectStateFile LastSignIn 2>/dev/null)
LAST_LICENSE_CHECK=$(defaults read $jamfConnectStateFile LicenseCheckLastRequestDate 2>/dev/null)
PASSWORD_CURRENT=$(defaults read $jamfConnectStateFile PasswordCurrent 2>/dev/null)
EXPIRATION_WARNING_LAST=$(defaults read $jamfConnectStateFile ExpirationWarningLast 2>/dev/null)
FIRST_RUN_DONE=$(defaults read $jamfConnectStateFile FirstRunDone 2>/dev/null)
LAST_CERTIFICATE_EXPIRATION=$(defaults read $jamfConnectStateFile LastCertificateExpiration 2>/dev/null)
LAST_TOTP_NOTIFICATION=$(defaults read $jamfConnectStateFile LastTOTPNotification 2>/dev/null)
OFFLINE_MFA_SETUP_SUCCESS=$(defaults read $jamfConnectStateFile OfflineMFASetupSuccess 2>/dev/null)
PASSWORD_EXPIRATION_REMAINING_DAYS=$(defaults read $jamfConnectStateFile PasswordExpirationRemainingDays 2>/dev/null)
UNSENT_OFFLINE_MFA_EVENTS=$(defaults read $jamfConnectStateFile UnsentOfflineMFAEvents 2>/dev/null)
USER_LOGIN_NAME=$(defaults read $jamfConnectStateFile UserLoginName 2>/dev/null)
# Get version number from Info.plist
VERSION=$(defaults read "/Applications/Jamf Connect.app/Contents/Info.plist" CFBundleShortVersionString 2>/dev/null)

# Output data here
echo "display_name${SEPARATOR}${DISPLAY_NAME}" > ${OUTPUT_FILE}
echo "jamf_connect_id${SEPARATOR}${JAMF_CONNECT_ID}" >> ${OUTPUT_FILE}
echo "password_last_changed${SEPARATOR}${PASSWORD_LAST_CHANGED}" >> ${OUTPUT_FILE}
echo "first_name${SEPARATOR}${FIRST_NAME}" >> ${OUTPUT_FILE}
echo "last_name${SEPARATOR}${LAST_NAME}" >> ${OUTPUT_FILE}
echo "locale${SEPARATOR}${LOCALE}" >> ${OUTPUT_FILE}
echo "login${SEPARATOR}${LOGIN}" >> ${OUTPUT_FILE}
echo "time_zone${SEPARATOR}${TIME_ZONE}" >> ${OUTPUT_FILE}
echo "last_analytics_checkin${SEPARATOR}${LAST_ANALYTICS_CHECKIN}" >> ${OUTPUT_FILE}
echo "last_sign_in${SEPARATOR}${LAST_SIGN_IN}" >> ${OUTPUT_FILE}
echo "last_license_check${SEPARATOR}${LAST_LICENSE_CHECK}" >> ${OUTPUT_FILE}
echo "password_current${SEPARATOR}${PASSWORD_CURRENT}" >> ${OUTPUT_FILE}
echo "expiration_warning_last${SEPARATOR}${EXPIRATION_WARNING_LAST}" >> ${OUTPUT_FILE}
echo "first_run_done${SEPARATOR}${FIRST_RUN_DONE}" >> ${OUTPUT_FILE}
echo "last_certificate_expiration${SEPARATOR}${LAST_CERTIFICATE_EXPIRATION}" >> ${OUTPUT_FILE}
echo "last_totp_notification${SEPARATOR}${LAST_TOTP_NOTIFICATION}" >> ${OUTPUT_FILE}
echo "offline_mfa_setup_success${SEPARATOR}${OFFLINE_MFA_SETUP_SUCCESS}" >> ${OUTPUT_FILE}
echo "password_expiration_remaining_days${SEPARATOR}${PASSWORD_EXPIRATION_REMAINING_DAYS}" >> ${OUTPUT_FILE}
echo "unsent_offline_mfa_events${SEPARATOR}${UNSENT_OFFLINE_MFA_EVENTS}" >> ${OUTPUT_FILE}
echo "user_login_name${SEPARATOR}${USER_LOGIN_NAME}" >> ${OUTPUT_FILE}
echo "version${SEPARATOR}${VERSION}" >> ${OUTPUT_FILE}
