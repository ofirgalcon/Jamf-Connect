#!/bin/bash

# jamf_connect controller
CTL="${BASEURL}index.php?/module/jamf_connect/"

# Get the scripts in the proper directories
"${CURL[@]}" "${CTL}get_script/jamf_connect.sh" -o "${MUNKIPATH}preflight.d/jamf_connect.sh"

# Check exit status of curl
if [ $? = 0 ]; then
	# Make executable
	chmod a+x "${MUNKIPATH}preflight.d/jamf_connect.sh"

	# Set preference to include this file in the preflight check
	setreportpref "jamf_connect" "${CACHEPATH}jamf_connect.txt"

else
	echo "Failed to download all required components!"
	rm -f "${MUNKIPATH}preflight.d/jamf_connect.sh"

	# Signal that we had an error
	ERR=1
fi
