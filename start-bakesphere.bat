@echo off
title BakeSphere Server
cd /d "C:\xampp\htdocs\cakesystem"
echo Starting BakeSphere...
php artisan serve --port=8000
pause