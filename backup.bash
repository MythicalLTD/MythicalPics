if [[ -f panel.sql ]]; then
  rm atoropics.sql
fi

DB_NAME="AtoroPics"
TEMP_DB_NAME="AtoroPics_temp"

# Drop and recreate the temporary database
mysql -u root -e "DROP DATABASE IF EXISTS $TEMP_DB_NAME;"
mysql -u root -e "CREATE DATABASE $TEMP_DB_NAME;"

# Dump the structure of the original database into a new SQL file
mysqldump -u root --no-data "$DB_NAME" | mysql -u root "$TEMP_DB_NAME"

# Recreate the required tables in the temporary database
mysqldump -u root --no-data "$DB_NAME" --tables atoropics_domains atoropics_imgs atoropics_logs atoropics_nodes atoropics_settings atoropics_users | mysql -u root "$TEMP_DB_NAME"

# Empty all tables in the temporary database
TABLES="$(mysql -u root -N -B -e "SHOW TABLES IN $TEMP_DB_NAME")"
for TABLE in $TABLES; do
  mysql -u root -e "TRUNCATE TABLE $TEMP_DB_NAME.$TABLE;"
done

# Dump the data from the temporary database into the SQL file
mysqldump -u root "$TEMP_DB_NAME" | sed '/^--/d; /^\/\*![0-9]\{5\}.*\*\//d; /^SET/d' > atoropics.sql

# Drop the temporary database
mysql -u root -e "DROP DATABASE $TEMP_DB_NAME;"
