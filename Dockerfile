FROM node:18-slim as build
WORKDIR /app

COPY *.json *.js /app/
COPY resources /app/resources
RUN npm install && npm run build

# Production build
FROM webdevops/php-nginx:8.2-alpine
ENV WEB_DOCUMENT_ROOT=/app/public
WORKDIR /app
COPY --chown=application:application composer.* ./
COPY --chown=application:application database/ database/
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist

COPY --chown=application:application . ./
COPY --from=build /app/public/build /app/public/build


