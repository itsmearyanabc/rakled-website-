#!/usr/bin/env bash
#
# Runs once, at image build time. Installs WordPress into SQLite and
# provisions it exactly as the "Create pages and menus" admin action
# would, then parks the finished database in /var/www/seed. start.sh
# copies it into place when a container starts.

set -euo pipefail

SITE=/var/www/site
DATA=/var/www/data
SEED=/var/www/seed

wp() { command wp --allow-root --path="$SITE" "$@"; }

# wp-config.php requires a salts file; a throwaway one is enough to install.
php -r 'echo "<?php\n"; foreach (["AUTH_KEY","SECURE_AUTH_KEY","LOGGED_IN_KEY","NONCE_KEY","AUTH_SALT","SECURE_AUTH_SALT","LOGGED_IN_SALT","NONCE_SALT"] as $k) { printf("define(%s, %s);\n", var_export($k, true), var_export(bin2hex(random_bytes(32)), true)); }' > "$DATA/salts.php"

# The admin password is random and never recorded. start.sh replaces it
# with WP_ADMIN_PASSWORD if that is set; otherwise nobody can log in,
# which is the right default for a public staging copy.
wp core install \
	--url=http://localhost \
	--title="Rian Cullet" \
	--admin_user=admin \
	--admin_password="$(php -r 'echo bin2hex(random_bytes(24));')" \
	--admin_email=admin@example.com \
	--skip-email

wp plugin activate sqlite-database-integration
wp theme activate rian-cullet

wp option update blogdescription ''
wp option update timezone_string 'Asia/Kolkata'

# A staging copy must never compete with the live site in search results.
wp option update blog_public 0

wp rewrite structure '/%postname%/'

wp eval 'require_once get_template_directory() . "/inc/starter-content.php"; rc_create_starter_content();'

# Core's sample content has no place on this site.
wp post delete $(wp post list --post_type=post --format=ids) --force || true
wp post delete $(wp post list --post_type=page --name=sample-page --format=ids) --force || true

wp rewrite flush

echo "Site provisioned:"
wp post list --post_type=page --fields=ID,post_name,post_status

# Nothing may touch WordPress after this point: with the database moved
# away, the SQLite driver would quietly create an empty one in its place.
mkdir -p "$SEED"
mv "$DATA/.ht.sqlite" "$SEED/.ht.sqlite"
rm -f "$DATA/salts.php"
