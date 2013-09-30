#!/bin/bash

echo -n "Please enter install path: "
read path

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
echo -e "\t=Attempting to create DB\n"
mysql -u$sql_user -p$sql_pass -e "create database quotation"
echo -e "\t=Attempting to populate DB\n"
mysql -u$sql_user -p$sql_pass quotation < ./sql/quotation_db.sql
