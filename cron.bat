@echo off
REM -----
REM Created By Surfing-Chef https://github.com/Surfing-Chef
REM https://gist.github.com/Surfing-Chef/6eb9e3d4137362f7c543cb630e6f1d4e
REM Cron job in WAMP
REM -----
REM IMPORTANT!!  CHANGE THE PATH TO REFLECT THE MACHINE
REM -----
cd C:\wamp64\www\Bourbon-WP\wp-content\plugins\sc-dark-weather\
php -f sc_dark_weather_get.php
