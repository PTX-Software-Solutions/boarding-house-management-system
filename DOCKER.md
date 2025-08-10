## 🚀 Quick Start

1. **Copy environment file:**

    ```bash
    cp .env.example .env
    ```

2. **Update .env for Docker:**

    ```env
    DB_HOST=db
    DB_DATABASE=boarding_house
    DB_USERNAME=root
    DB_PASSWORD=password

    REDIS_HOST=redis

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=your_mailtrap_username
    MAIL_PASSWORD=your_mailtrap_password
    MAIL_ENCRYPTION=tls

    APP_URL=http://localhost:8000
    ```

3. **Build and start containers:**

    ```bash
    docker-compose up -d --build
    ```

4. **Install dependencies:**

    ```bash
    docker-compose exec app composer update
    docker-compose exec app npm install
    ```

5. **Setup application:**
    ```bash
    docker-compose exec app php artisan key:generate
    docker-compose exec app php artisan migrate
    docker-compose exec app php artisan db:seed --force
    docker-compose exec app npm run build
    docker-compose exec app php artisan storage:link
    ```

### Container Management

```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# Restart all services
docker-compose restart

# View logs
docker-compose logs -f

# View logs for specific service
docker-compose logs -f app
```

### Development Commands

```bash
# Access app container shell
docker-compose exec app bash

# Run Artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker

# Install new Composer packages
docker-compose exec app composer require package-name

# Install new NPM packages
docker-compose exec app npm install package-name

# Build assets (development)
docker-compose exec app npm run dev

# Build assets (production)
docker-compose exec app npm run build

# Watch for file changes
docker-compose exec app npm run watch
```

### Database Operations

```bash
# Run migrations
docker-compose exec app php artisan migrate

# Run seeders
docker-compose exec app php artisan db:seed

# Reset database
docker-compose exec app php artisan migrate:fresh --seed

# Create new migration
docker-compose exec app php artisan make:migration create_example_table
```

### Cache Management

```bash
# Clear all caches
docker-compose exec app php artisan optimize:clear

# Clear specific caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Testing

```bash
# Run PHPUnit tests
docker-compose exec app php artisan test

# Run specific test
docker-compose exec app php artisan test --filter TestName

# Test email configuration
docker-compose exec app php artisan email:test your@email.com
```

### Permission Issues

```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/storage
```

### Database Connection Issues

```bash
# Restart database container
docker-compose restart db

# Check database logs
docker-compose logs db
```

### Clear Everything and Start Fresh

```bash
# Stop and remove all containers and volumes
docker-compose down -v

# Remove images
docker-compose down --rmi all

# Rebuild everything
docker-compose up -d --build

# Re-run setup
./docker-setup.sh
```

### Container Health Check

```bash
# Check running containers
docker-compose ps

# Check container resource usage
docker stats

# Inspect specific service
docker-compose logs app
```
