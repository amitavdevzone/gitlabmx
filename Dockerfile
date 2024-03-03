# Stage 1: Build Frontend Assets
FROM node:18-alpine AS frontend-builder

WORKDIR /app

# Copy only the necessary files for installing dependencies
COPY package.json package-lock.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application files
COPY . .

# Build frontend assets
RUN npm run build

# Stage 2: Run Tests
FROM serversideup/php:8.2-fpm-nginx-v2.0.2

WORKDIR /app

# Copy only the necessary files for installing dependencies
COPY --from=frontend-builder /app/vendor /app/vendor
COPY --from=frontend-builder /app/composer.* /app/

# Install dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application files
COPY . .

# Copy compiled frontend assets
COPY --from=frontend-builder /app/public /app/public

# Run your tests
CMD ["vendor/bin/pest"]
