#!/bin/bash

# Exit on any errors
set -o errexit

function show_help {
	echo "Updates the website"
}


while getopts "h" opt; do
		case "$opt" in
		h)
		show_help
		exit 0
		;;
		'?')
		show_help
		exit 1
		;;
	esac
done

rep=..
host=agarhosting.nl

# Update git_info.php
AUTHOR=`git --git-dir=$rep/.git/ log --pretty=format:'%an' -n 1`
REV=`git --git-dir=$rep/.git/ log --pretty=format:'%h' -n 1`
echo "<?php define('GIT_REVISION','$REV'); define('GIT_AUTHOR','$AUTHOR'); ?>" > $rep/deployment/git_info.php

# Generate assets
$rep/yii asset $rep/deployment/assets.php $rep/config/assets-prod.php

# Update files using FTP
echo "FTP Password:"
lftp -u agarhosting agarhosting.nl <<EOF
set cmd:fail-exit true;
set ftp:ssl-allow no;
set ftp:list-options -a;
mirror -veR --exclude config/db.php --exclude web/assets --exclude .git --exclude runtime --exclude .idea --exclude config/db.php $rep/. alberto/.;
bye;
EOF

echo -e "\e[00;32mUpdate complete\e[00m"
