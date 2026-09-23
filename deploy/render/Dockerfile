# Rian Cullet on Render: WordPress + SQLite in a single container.
#
# Render has no managed MySQL, so the database is SQLite, through the
# same official drop-in WordPress Playground uses. The theme does not
# care which database it runs on.
#
# The site is installed and provisioned at BUILD time: theme active,
# pages created, front page set, menus built. Every container therefore
# starts as a finished site. That matters on Render's free plan, where
# the filesystem is thrown away on each restart: the site simply comes
# back as built. Anything changed in wp-admin there is not kept (see
# deploy/render/README.md for the paid, persistent variant).
#
# Build context is the repository root:
#   docker build -f deploy/render/Dockerfile -t rian-cullet .

FROM wordpress:7.1-php8.3-apache

ARG WP_CLI_VERSION=2.12.0
ARG SQLITE_PLUGIN_VERSION=3.0.2

# WP-CLI, verified against its published checksum.
RUN set -eux; \
    base="https://github.com/wp-cli/wp-cli/releases/download/v${WP_CLI_VERSION}/wp-cli-${WP_CLI_VERSION}.phar"; \
    curl -fsSL -o /usr/local/bin/wp "$base"; \
    echo "$(curl -fsSL "$base.sha512")  /usr/local/bin/wp" | sha512sum -c -; \
    chmod +x /usr/local/bin/wp

# WordPress core, served from /var/www/site rather than the image's
# /var/www/html. That path is a declared VOLUME in the base image, and
# build steps that write under a volume can be discarded.
RUN set -eux; \
    cp -a /usr/src/wordpress/. /var/www/site/; \
    rm -f /var/www/site/wp-config-docker.php /var/www/site/wp-config-sample.php; \
    rm -rf /var/www/site/wp-content/plugins/akismet /var/www/site/wp-content/plugins/hello.php; \
    rm -rf /var/www/site/wp-content/themes/twenty*; \
    sed -ri 's!/var/www/html!/var/www/site!g' \
        /etc/apache2/sites-available/*.conf \
        /etc/apache2/apache2.conf \
        /etc/apache2/conf-available/*.conf

# SQLite database integration plugin and its db.php drop-in.
RUN set -eux; \
    curl -fsSL -o /tmp/sqlite.zip \
        "https://downloads.wordpress.org/plugin/sqlite-database-integration.${SQLITE_PLUGIN_VERSION}.zip"; \
    php -r '$z = new ZipArchive; $z->open("/tmp/sqlite.zip") === true || exit(1); $z->extractTo("/var/www/site/wp-content/plugins/"); $z->close();'; \
    cp /var/www/site/wp-content/plugins/sqlite-database-integration/db.copy /var/www/site/wp-content/db.php; \
    rm /tmp/sqlite.zip

# A free instance has 512 MB. Apache's default of 150 PHP workers would
# exhaust it long before the CPU could serve them.
COPY deploy/render/mpm-prefork.conf /etc/apache2/mods-available/mpm_prefork.conf

COPY deploy/render/wp-config.php /var/www/site/wp-config.php
COPY deploy/render/htaccess /var/www/site/.htaccess
COPY wp-content/themes/rian-cullet /var/www/site/wp-content/themes/rian-cullet
COPY deploy/render/build-site.sh deploy/render/start.sh /usr/local/bin/

# Core files are owned by root and read-only to the web server. Only the
# data directory (database, salts, uploads) is writable.
RUN set -eux; \
    chmod +x /usr/local/bin/build-site.sh /usr/local/bin/start.sh; \
    mkdir -p /var/www/data/uploads; \
    ln -s /var/www/data/uploads /var/www/site/wp-content/uploads; \
    build-site.sh; \
    chown -R root:root /var/www/site

ENTRYPOINT ["/usr/local/bin/start.sh"]
