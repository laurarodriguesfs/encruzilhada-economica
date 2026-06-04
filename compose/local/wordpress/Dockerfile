FROM wordpress:php8.2

USER www-data

# Insert our data and dependencies
COPY ["compose/entrypoint-extra", "/docker-entrypoint-extra"]

# Fix file permissions
USER root
