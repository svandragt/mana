#!/usr/bin/env bash

sudo rm -rf /srv/mana/logs
sudo -u www-data mkdir /srv/mana/logs -p

sudo cp /vagrant/bootstrap/etc/ / -r
sudo service php7.3-fpm restart
sudo service nginx restart

echo "Ready. http://mana.test"