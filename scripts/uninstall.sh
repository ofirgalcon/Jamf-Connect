#!/bin/bash

# Remove jamf_connect script
rm -f "${MUNKIPATH}preflight.d/jamf_connect.sh"

# Remove jamf_connect.txt file
rm -f "${MUNKIPATH}preflight.d/cache/jamf_connect.txt"
