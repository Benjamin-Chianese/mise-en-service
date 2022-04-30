#!/bin/bash

CONF_FILE=/var/www/html/includes/conf.php

# secret file
if [ ! -z ${DB_MDP_FILE} ]; then
    export DB_MDP=$(cat $DB_MDP_FILE)
fi

# default value
if [ -z ${DB_HOST} ]; then
    export DB_HOST="default_value"
fi
if [ -z ${DB_NAME} ]; then
    export DB_NAME="default_value"
fi
if [ -z ${DB_USER} ]; then
    export DB_USER="default_value"
fi
if [ -z ${DB_MDP} ]; then
    export DB_MDP="default_value"
fi
if [ -z ${SMTP_HOST} ]; then
    export SMTP_HOST="default_value"
fi
if [ -z ${SMTP_PORT} ]; then
    export SMTP_PORT="default_value"
fi
if [ -z ${SMTP_SECURE} ]; then
    export SMTP_SECURE="default_value"
fi

# apply envvars in configuration file
envsubst '$DB_HOST,$DB_NAME,$DB_USER,$DB_MDP,$SMTP_HOST,$SMTP_PORT,$SMTP_SECURE' < $CONF_FILE.tpl > $CONF_FILE
rm $CONF_FILE.tpl

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- apache2-foreground "$@"
fi

exec "$@"
