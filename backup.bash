if [[ -f mythicalpics.sql ]]; then
  rm mythicalpics.sql
fi
DB_NAME="MythicalPics"
TEMP_DB_NAME="MythicalPics_temp"
mysql -u root -e "DROP DATABASE IF EXISTS $TEMP_DB_NAME;"
mysql -u root -e "CREATE DATABASE $TEMP_DB_NAME;"
mysqldump -u root --no-data "$DB_NAME" | mysql -u root "$TEMP_DB_NAME"
mysqldump -u root --no-data "$DB_NAME" --tables mythicalpics_apikeys mythicalpics_domains mythicalpics_imgs mythicalpics_settings mythicalpics_users | mysql -u root "$TEMP_DB_NAME"
TABLES="$(mysql -u root -N -B -e "SHOW TABLES IN $TEMP_DB_NAME")"
for TABLE in $TABLES; do
  mysql -u root -e "TRUNCATE TABLE $TEMP_DB_NAME.$TABLE;"
done
mysqldump -u root "$TEMP_DB_NAME" | sed '/^--/d; /^\/\*![0-9]\{5\}.*\*\//d; /^SET/d' > mythicalpics.sql
mysql -u root -e "DROP DATABASE $TEMP_DB_NAME;"