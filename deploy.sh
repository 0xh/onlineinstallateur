#!/bin/bash

CONFIG_DIR="local/config"
MEDIA_DIR="local/media"
WEB_MEDIA="web/media"
WEB_ASSETS="web/assets"
WEB_CACHE="web/cache"
CACHE="cache"
LOG="log"
SESSION="local/session"
WEB_CONFIGURATOR="web/configurator"


#remove config and static content folder  

if [ -d "$MEDIA_DIR" ]; then
  if [ -L "$MEDIA_DIR" ]; then
  	rm  $MEDIA_DIR
  else
    rm -rf $MEDIA_DIR
  fi
fi


if [ -d "$CONFIG_DIR" ]; then
	if [ -L "$CONFIG_DIR" ]; then
  		rm  $CONFIG_DIR
    else
    	rm -rf $CONFIG_DIR
    fi
    
fi

if [ -d "$WEB_MEDIA" ]; then
	if [ -L "$WEB_MEDIA" ]; then
  		rm  $WEB_MEDIA
    else
    	rm -rf $WEB_MEDIA
    fi
    
fi

if [ -d "$WEB_CONFIGURATOR" ]; then
	if [ -L "$WEB_CONFIGURATOR" ]; then
  		rm  $WEB_CONFIGURATOR
    else
    	rm -rf $WEB_CONFIGURATOR
    fi
    
fi



if [ ! -d "$CACHE" ]; then	
	mkdir  $CACHE
    chmod -R 0777 $CACHE
else 
	rm -rf $CACHE/*
	chmod -R 0777 $CACHE
fi


if [ ! -d "$LOG" ]; then	
	mkdir  $LOG
    chmod -R 0777 $LOG
else
	chmod -R 0777 $LOG
fi

mkdir  $WEB_ASSETS
chmod -R 0777 $WEB_ASSETS
rm -rf 0777 $SESSION

mkdir  $WEB_CACHE
chmod -R 0777  $WEB_CACHE

chmod -R 0777 web
chmod -R 0775 web/index*
chmod -R 0775 web/.htaccess

#install elastic-search
composer require "elasticsearch/elasticsearch: ~6.0"


printf "STEP4: link the media and config from outside the app \n "
#link the media and config from outside the app 
ln -s /data/hausfabrik/media local/media
ln -s /data/hausfabrik/config/ local/config
ln -s /data/hausfabrik/session local/session
#link the web/configurator and config from outside the app 
ln -s /data/hausfabrik/configurator web/configurator
#link the web/media and config from outside the app 
ln -s /data/hausfabrik/web_media web/media

#link the symfony/vendor autside src
rm -rf core/vendor/symfony/cache
ln -s /data/hausfabrik/symnfoy_cache core/vendor/symfony/cache




#move all content to stable vestion
printf "STEP5: Prepare Stabel Version  \n "
sleep 5
printf "STEP6: Genereate Backup \n "

if [ ! -d "../stable_backup" ]; then	
    rm -rf ../stable_backup
fi

sudo rsync -arv --progress ./* ../stable_new

sudo chown -R www-data:www-data ../stable_new

cd ../stable_new

sudo chown -R www-data:www-data ./



chmod -R 0777 templates/frontOffice/default/assets/dist/
sudo chmod -R 0777 local/sepa/*
sudo chmod -R 0777 local/I18n/*
sudo chmod -R 0777 local/modules/Selection/I18n/*
sudo chmod -R 0777 local/modules/FilterConfigurator/templates/frontOffice/easybad
sudo chmod -R 0777  $WEB_CACHE

sudo chmod -R 0777 $WEB_ASSETS

sudo chmod -R 0777 web
sudo chmod -R 0775 web/index*
sudo chmod -R 0775 web/.htaccess
sudo chmod -R 0777 $LOG
sudo chmod -R 0777 $SESSION

php Thelia cache:clear --env=prod
php Thelia cache:clear --env=dev

#create backup 

mv ../stable ../stable_backup
#move new release to stable version
mv ../stable_new ../stable




