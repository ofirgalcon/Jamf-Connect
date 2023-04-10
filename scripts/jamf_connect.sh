#!/bin/sh

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

# Business logic goes here
# Replace 'echo' in the following lines with the data collection commands for your module.
DISPLAY_NAME=$(defaults read $jamfConnectStateFile DisplayName 2>/dev/null) || exit 0
JAMF_CONNECT_ID=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:id" "$jamfConnectStateFile")
PASSWORD_LAST_CHANGED=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:passwordChanged" "$jamfConnectStateFile")
FIRST_NAME=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:firstName" "$jamfConnectStateFile")
LAST_NAME=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:lastName" "$jamfConnectStateFile")
LOCALE=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:locale" "$jamfConnectStateFile")
LOGIN=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:login" "$jamfConnectStateFile")
TIME_ZONE=$(/usr/libexec/PlistBuddy -c "Print :IdToken:user:profile:timeZone" "$jamfConnectStateFile")
LAST_ANALYTICS_CHECKIN=$(defaults read $jamfConnectStateFile LastPreferenceAnalyticsCheckIn)
LAST_SIGN_IN=$(defaults read $jamfConnectStateFile LastSignIn)
LAST_LICENSE_CHECK=$(defaults read $jamfConnectStateFile LicenseCheckLastRequestDate)
PASSWORD_CURRENT=$(defaults read $jamfConnectStateFile PasswordCurrent)
# Get version number from Info.plist
VERSION=$(defaults read "/Applications/Jamf Connect.app/Contents/Info.plist" CFBundleShortVersionString)

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
echo "version${SEPARATOR}${VERSION}" >> ${OUTPUT_FILE}
