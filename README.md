# Note Sharing Application

A modern web application for creating, managing, and sharing notes built with Laravel and Tailwind CSS. This application features a clean, responsive interface with dark mode support and real-time updates.

## Features

- 📝 Create and manage personal notes
- 🔄 Share notes with other users
- 🌓 Dark mode support
- 🎨 Modern, responsive UI
- 👥 User authentication and authorization
- ⚡ Quick actions for common tasks

## Screenshots

![image](https://github.com/user-attachments/assets/8fffa4e1-d244-4fd5-91d3-ab6546a23a3d)


## Requirements

- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL or compatible database

## Installation

1. Clone the repository
```bash
git clone https://github.com/YOUR_USERNAME/NoteSharingApp.git
cd NoteSharingApp
```

2. Install PHP dependencies
```bash
composer install
```

3. Install and compile frontend dependencies
```bash
npm install
npm run build
```

4. Set up environment file
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in the .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

6. Run database migrations
```bash
php artisan migrate
```

7. Start the development server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Security

If you discover any security-related issues, please email your-email@example.com instead of using the issue tracker.
