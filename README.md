# Laravel Task Manager

A clean, efficient task management application built with Laravel, featuring drag-and-drop reordering and project organization.

## Features

- ✨ **Task Management** - Create, edit, and delete tasks with ease
- 🎯 **Priority System** - Drag-and-drop to reorder tasks by priority
- 📁 **Project Organization** - Group tasks by projects for better organization
- 📱 **Responsive Design** - Works seamlessly on desktop and mobile devices
- ⚡ **Real-time Updates** - Ajax-powered updates without page refreshes
- 🚀 **Performance Optimized** - Built to handle 10x load with efficient queries

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM

## Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd task-manager
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install NPM dependencies**
```bash
npm install && npm run build
```

4. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Update database credentials in `.env`**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **(Optional) Seed sample data**
```bash
php artisan db:seed
```

8. **Start the application**
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## Usage

1. **Creating Projects** - Click "New Project" to organize your tasks
2. **Adding Tasks** - Use the quick-add form to create tasks instantly
3. **Reordering** - Drag tasks to change their priority - #1 is highest
4. **Filtering** - Select a project from the dropdown to view specific tasks
5. **Editing** - Click edit button on any task to modify its details

## Testing

1. **Create a test database**
```sql
CREATE DATABASE task_manager_test;
```

2. **Run the test suite**
```bash
php artisan test
```

The tests use a separate database to avoid affecting your development data.

## Technical Stack

- **Backend**: Laravel 10.x with Eloquent ORM
- **Frontend**: Bootstrap 5, jQuery, jQuery UI Sortable
- **Database**: MySQL with optimized indexes
- **Ajax**: Seamless updates without page reloads

## Architecture Decisions

- **Monolithic Structure** - Keeps the application simple and easy to deploy
- **Eloquent ORM** - Leverages Laravel's powerful ORM for clean, readable code
- **Ajax Updates** - Provides instant feedback without full page reloads
- **Composite Indexes** - Optimizes queries filtering by project and sorting by priority
- **Automatic Priority Management** - Smart reordering when tasks are added or deleted

## Performance Optimizations

- Eager loading to prevent N+1 queries
- Database indexing on frequently queried columns
- Minimal DOM manipulation for smooth drag-and-drop
- Efficient priority recalculation algorithms

## Deployment (Production)

1. **Set environment to production**
```bash
APP_ENV=production
APP_DEBUG=false
```

2. **Optimize for production**
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Configure web server (Nginx example)**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## Future Enhancements

- User authentication and multi-tenancy
- Task due dates and reminders
- Task labels and categories
- Search and filtering capabilities
- Export tasks to CSV/PDF
- Dark mode support

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).