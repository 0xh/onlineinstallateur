@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../core/vendor/oyejorge/less.php/bin/lessc
php "%BIN_TARGET%" %*
