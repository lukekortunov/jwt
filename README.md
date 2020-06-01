### Clone current repository
$ git clone git@github.com:funnywheel/jwt.git .

### Run application with docker-compose 
$ docker-compose -f docker-compose-dev.yaml up -d

### Install PHP dependencies (or execute commands manually from this script)
$ bash ./commands/composer-install.sh

### Create database structure and fill with dummy data (or execute commands manually from this script)
$ bash ./commands/scripts/refresh-database.sh
