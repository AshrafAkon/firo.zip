FROM public.ecr.aws/docker/library/composer:latest as phpbuilder
WORKDIR /app/
COPY ./ ./
RUN cp .env.production .env
RUN composer install

# Install npm dependencies and build js
FROM public.ecr.aws/docker/library/node:16-alpine AS nodebuilder
WORKDIR /app/

# Install dependencies based on the preferred package manager
# COPY *.config.js package.json package-lock.json*  ./
COPY ./ ./
COPY --from=phpbuilder /app/vendor ./vendor
RUN \
    if [ -f package-lock.json ]; then npm ci && npm run build; \
    else echo "Lockfile not found." && exit 1; \
    fi


FROM public.ecr.aws/docker/library/php:fpm-alpine


# Install system dependencies
RUN  apk add --no-cache \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    fcgi

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql exif pcntl bcmath gd
WORKDIR /var/www/html

# copy project files
COPY --chown=www-data:www-data --from=phpbuilder /app /var/www/html
COPY --chown=www-data:www-data --from=nodebuilder /app/public/build /var/www/html/public/build

HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 CMD [ "cgi-fcgi -bind -connect localhost:9000" ]
CMD ["php-fpm"]
