# GO CMS - Multi-Site Content Management System

A modern, multi-site Content Management System built with Laravel 12, Tailwind CSS, and Alpine.js.

## 🚀 Features

- **Multi-Site Architecture**: Manage multiple websites from a single dashboard
- **Modern Admin Interface**: Beautiful, responsive admin panel with Tailwind CSS
- **Content Management**: Full CRUD for Articles, Pages, and Categories
- **SEO Optimized**: Built-in meta tags and SEO-friendly URLs
- **Media Management**: Support for featured images and galleries
- **User Management**: Role-based access control
- **Real-time Updates**: Alpine.js for dynamic interactions

## 📋 Requirements

- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & NPM

## 🛠 Installation

1. Clone the repository:
```bash
git clone <repository-url> go-cms
cd go-cms
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=go_cms
DB_USERNAME=root
DB_PASSWORD=
```

6. Generate application key:
```bash
php artisan key:generate
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Build assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

## 🎯 Usage

### Admin Dashboard
Access the admin dashboard at: `http://localhost:8000/admin`

Default login credentials:
- Email: `admin@gocms.com`
- Password: `password`

### Main Features

1. **Sites Management**: Create and manage multiple websites
2. **Categories**: Organize content with categories per site
3. **Articles**: Create and publish blog posts and articles
4. **Pages**: Manage static pages with custom templates
5. **Dashboard**: Overview with statistics and recent content

## 🏗 Project Structure

```
app/
├── Http/Controllers/Admin/     # Admin controllers
├── Models/                     # Eloquent models
resources/
├── views/
│   ├── admin/                 # Admin panel views
│   ├── layouts/               # Layout templates
│   └── partials/              # Reusable components
database/
├── migrations/                # Database migrations
└── seeders/                   # Sample data seeders
```

## 🎨 Customization

### Themes
Each site can have custom theme settings stored in JSON format:
```json
{
    "primary_color": "#3B82F6",
    "secondary_color": "#10B981",
    "font_family": "Inter"
}
```

### Adding New Features
1. Create new migrations for database changes
2. Add corresponding models with relationships
3. Create controllers with CRUD operations
4. Design views with Tailwind CSS
5. Update routes and navigation

## 🔧 Configuration

### Multi-Site Setup
Sites can be configured with:
- Primary domain
- Subdomain (optional)
- Custom settings (contact info, social media)
- Theme configuration
- Active/inactive status

### Content Types
- **Articles**: Blog posts with categories, featured images, SEO
- **Pages**: Static content with custom templates
- **Categories**: Content organization per site

## 📊 Database Schema

Key relationships:
- Sites → Categories (1:many)
- Sites → Articles (1:many)
- Sites → Pages (1:many)
- Categories → Articles (1:many)
- Users → Articles (1:many)
- Users → Pages (1:many)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review the code comments

---

Built with ❤️ using Laravel 12, Tailwind CSS, and Alpine.js

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
