FROM ghcr.io/ashrafakon/firo.zip/php:latest as phpbuilder
FROM public.ecr.aws/nginx/nginx:alpine

COPY docker/nginx/app.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /var/www/html
WORKDIR /var/www/html
COPY --from=phpbuilder /var/www/html/public /var/www/html/public

CMD ["nginx", "-g", "daemon off;"]
