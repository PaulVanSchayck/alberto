#!/bin/bash

while ! mysqladmin ping -h db --silent; do
  echo "Waiting for database connection..."
  sleep 5
done

cd /opt/app || exit

# Install composer dependencies
composer install

# Install DB if does not exist yet
mysql -h db -u root -e 'use alberto' > /dev/null 2>&1
if [[ $? -gt 0  ]]; then
    # Create
    mysql -h db -u root -e "CREATE SCHEMA IF NOT EXISTS alberto DEFAULT CHARACTER SET utf8 ;"

    # Load base database
    mysql -h db -u root -D alberto < /opt/annotation_create_import.sql
    mysql -h db -u root -D alberto < /opt/intact_create.sql
    mysql -h db -u root -D alberto < /opt/eightcell_create.sql
    mysql -h db -u root -D alberto < /opt/intact_map2_create.sql
    mysql -h db -u root -D alberto < /opt/m0171_create.sql
    mysql -h db -u root -D alberto < /opt/mpproper_create.sql
    mysql -h db -u root -D alberto < /opt/q0990.sql
    mysql -h db -u root -D alberto < /opt/wendrich_roots.sql
fi

# Start Apache2 in background
apache2ctl start

# Watch the yii2 log
exec tail -f --retry /opt/app/runtime/logs/app.log