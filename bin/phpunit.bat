@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../core/vendor/phpunit/phpunit/phpunit
php "%BIN_TARGET%" %*
