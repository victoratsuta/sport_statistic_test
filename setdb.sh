#!/bin/bash

php bin/console doctrine:mongodb:schema:drop
php bin/console app:generate-sports
php bin/console app:generate-lig
php bin/console app:generate-lang
php bin/console app:generate-team
php bin/console app:generate-games