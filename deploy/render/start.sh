#!/usr/bin/env bash
#
# Container entrypoint. Puts the database and salts in place, applies
# the admin credentials from the environment, binds Apache to Render's
# port, then hands over to Apache.
#
# Environment:
#   PORT               Port to listen on. Render sets it; defaults to 80.
#   WP_ADMIN_PASSWORD  Password for the "admin" user. Unset: no login.
#   WP_ADMIN_EMAIL     Optional. Admin email, also where enquiries go.

set -euo pipefail

DATA=/var/www/data
SEED=/var/www/seed

wp() { command wp --allow-root --path=/var/www/site "$@"; }

mkdir -p "$DATA/uploads"

# First start (or every start, on a filesystem that does not persist):
# bring in the database that was provisioned at build time. On a
# persistent disk the existing database is left alone.
if [ ! -f "$DATA/.ht.sqlite" ]; then
	cp "$SEED/.ht.sqlite" "$DATA/.ht.sqlite"
	echo "start: database seeded from build"
fi

if [ ! -f "$DATA/salts.php" ]; then
	php -r 'echo "<?php\n"; foreach (["AUTH_KEY","SECURE_AUTH_KEY","LOGGED_IN_KEY","NONCE_KEY","AUTH_SALT","SECURE_AUTH_SALT","LOGGED_IN_SALT","NONCE_SALT"] as $k) { printf("define(%s, %s);\n", var_export($k, true), var_export(bin2hex(random_bytes(32)), true)); }' > "$DATA/salts.php"
fi

if [ -n "${WP_ADMIN_PASSWORD:-}" ]; then
	wp user update admin --user_pass="$WP_ADMIN_PASSWORD" --skip-email --quiet
	echo "start: admin password applied from WP_ADMIN_PASSWORD"
else
	echo "start: WP_ADMIN_PASSWORD not set; wp-admin login is disabled"
fi

if [ -n "${WP_ADMIN_EMAIL:-}" ]; then
	wp option update admin_email "$WP_ADMIN_EMAIL" --quiet
	wp user update admin --user_email="$WP_ADMIN_EMAIL" --skip-email --quiet
fi

chown -R www-data:www-data "$DATA"

PORT="${PORT:-80}"
sed -ri "s/^Listen [0-9]+$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
echo "start: Apache on port ${PORT}"

exec apache2-foreground
