# Laravel Real-Time Chat Application

A modern, real-time chat application built with Laravel, featuring WebSocket communication, user authentication, and a clean, responsive interface.

## Features

- **Real-Time Messaging**: Instant message delivery using Laravel Broadcasting and Pusher
- **User Authentication**: Secure login and registration system
- **Private Chat Rooms**: One-on-one messaging between users
- **Online Status**: See which users are currently online
- **Message History**: Persistent chat history stored in database
- **Responsive Design**: Mobile-friendly interface that works on all devices
- **User Presence**: Real-time user presence detection
- **Typing Indicators**: See when other users are typing (if implemented)

## Technology Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates, JavaScript, CSS
- **Real-Time**: Laravel Broadcasting with Pusher
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze/Sanctum

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP >= 8.1
- Composer
- Node.js >= 16.x and NPM
- MySQL >= 5.7 or PostgreSQL
- A Pusher account (free tier available)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/sounakm177/laravel-chat.git
cd laravel-chat
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install NPM Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and configure your settings:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 5. Database Setup

Configure your database credentials in the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_chat
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database and run migrations:

```bash
# Create database (MySQL example)
mysql -u root -p -e "CREATE DATABASE laravel_chat"

# Run migrations
php artisan migrate
```

### 6. Pusher Configuration

Sign up for a free Pusher account at [pusher.com](https://pusher.com) and create a new app.

Update your `.env` file with Pusher credentials:

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_app_cluster
PUSHER_SCHEME=https
```

### 7. Build Assets

Compile frontend assets:

```bash
npm run dev
# or for production
npm run build
```

### 8. Start the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Usage

1. **Register an Account**: Navigate to `/register` and create a new account
2. **Login**: Sign in with your credentials
3. **Start Chatting**: Select a user from the user list to start a conversation
4. **Send Messages**: Type your message and press Enter or click Send

## Project Structure

```
laravel-chat/
├── app/
│   ├── Events/          # Broadcasting events
│   ├── Http/
│   │   └── Controllers/ # Application controllers
│   └── Models/          # Eloquent models
├── database/
│   └── migrations/      # Database migrations
├── public/              # Public assets
├── resources/
│   ├── js/             # JavaScript files
│   ├── css/            # Stylesheets
│   └── views/          # Blade templates
├── routes/
│   ├── web.php         # Web routes
│   └── channels.php    # Broadcasting channels
└── tests/              # Test files
```

## Configuration

### Broadcasting

Ensure broadcasting is properly configured in `config/broadcasting.php`. The application uses Pusher for WebSocket communication.

### Queue Configuration

For optimal performance in production, configure a queue driver:

```env
QUEUE_CONNECTION=redis
```

Then run the queue worker:

```bash
php artisan queue:work
```

## Testing

Run the test suite:

```bash
php artisan test
```

## Troubleshooting

### Messages not appearing in real-time

- Verify Pusher credentials are correct
- Check browser console for JavaScript errors
- Ensure `BROADCAST_DRIVER=pusher` in `.env`
- Clear config cache: `php artisan config:clear`

### Database Connection Issues

- Verify database credentials in `.env`
- Ensure database server is running
- Check database user permissions

### Asset Compilation Errors

- Delete `node_modules` and run `npm install` again
- Clear npm cache: `npm cache clean --force`

## Deployment

### Production Checklist

1. Set `APP_ENV=production` and `APP_DEBUG=false`
2. Run `composer install --optimize-autoloader --no-dev`
3. Run `npm run build`
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`
7. Set up a queue worker
8. Configure proper file permissions
9. Use HTTPS in production
10. Set up regular database backups

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email the repository owner instead of using the issue tracker.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Credits

- **Developer**: [Sounak Mondal](https://github.com/sounakm177)
- **Framework**: [Laravel](https://laravel.com)
- **Real-Time**: [Pusher](https://pusher.com)

## Support

If you encounter any issues or have questions:

- Open an issue on [GitHub Issues](https://github.com/sounakm177/laravel-chat/issues)
- Check existing issues for solutions
- Review the Laravel documentation at [laravel.com/docs](https://laravel.com/docs)

## Acknowledgments

- Laravel community for the amazing framework
- Pusher for real-time infrastructure
- All contributors who help improve this project

---

Made with ❤️ using Laravel
