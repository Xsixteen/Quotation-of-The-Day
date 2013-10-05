#!/bin/bash

echo -n "Please enter install path: "
read path
ABS_PATH=$(cd $path; pwd)
echo -e "\nPath Identified as $ABS_PATH"

echo -n "Please enter mysql username: "
read sql_user

echo -n "Please enter mysql password: "
read -s sql_pass

echo -e "\n===File Installation===\n"
cp -R ./public_html "$path"
echo -e "\t=Installed public_html to $path/public_html\n"
cp -R ./bin "$path"
echo -e "\t=Installed bin to $path/bin\n"
cp -R ./log "$path"
echo -e "\t=Installed log to $path/log\n"

echo -e "\n===SQL Installation===\n"
echo -e "\t=Attempting to populate DB\n"
mysql -u$sql_user -p$sql_pass < ./sql/quotation_db.sql

echo -e "\n===Creating Cron Jobs\n"
mkdir tmp
echo -e "\t=Creating Bash Script\n"
echo "#!/bin/bash" >> ./tmp/quotation_of_the_day.sh
echo "php $ABS_PATH/bin/updateQuote.php >> $ABS_PATH/log/quotation_log"  >> ./tmp/quotation_of_the_day.sh
echo -e "\t=Installing Bash Script\n"
chmod +x ./tmp/quotation_of_the_day.sh
mv ./tmp/quotation_of_the_day /etc/cron.hourly
rm -fr ./tmp
echo -e "\t=Installation Complete"
