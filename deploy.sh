#
# Author: Max Trewhitt - Osolo
# Description: A safe deployment routine script
#

# Stop script on error signal
set -e

# Go to web root directory
cd ../

# Remove old deployment folder
if [ -d "html_deploy" ]; then
  rm -rf html_deploy
fi

# Create separate deployment folder
cp -rp html html_deploy

# Go to deployment folder
cd html_deploy

#
# Initiate build sequence
#

# Reset workspace and pull latest commit
git fetch --all
git reset --hard origin/master
git clean -fd

# Remove vendor folder
if [ -d "vendor" ]; then
  rm -rf vendor
fi

# Install project dependencies
composer install --no-suggest --no-interaction --prefer-dist --optimize-autoloader

# Build vendor assets in main theme
cd web/app/themes/alviksmaleri
composer install --no-suggest --no-interaction --prefer-dist --optimize-autoloader
npm install
npm run build:production

# Go to web root directory
cd /var/www/alviksmaleri.itrak.se

# Remove backup
if [ -d "html_backup" ]; then
  rm -rf html_backup
fi

# Switch (downtime in microseconds)
mv html html_backup
mv html_deploy html

# Restart PHP service to clear cache
#sudo service php7.2-fpm reload
