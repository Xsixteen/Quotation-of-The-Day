#!/bin/bash

echo -n "Please enter install path:"

read path

cp -R ./public_html "$path"
echo -n "Installed public_html to $path/public_html"
cp -R ./bin "$path"
echo -n "Installed bin to $path/bin"
cp -R ./log "$path"
echo -n "Installed log to $path/log"

