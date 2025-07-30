<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# GO CMS - Multi-Site Content Management System

This is a Laravel 12 multi-site CMS with Tailwind CSS and modern admin dashboard.

## Project Structure
- **Multi-site architecture**: Each site can have its own domain/subdomain
- **Content Management**: Articles, Pages, Categories
- **Modern UI**: Tailwind CSS with Alpine.js
- **Admin Dashboard**: Complete CRUD operations

## Development Guidelines
- Use Laravel 12 features and best practices
- Follow PSR-12 coding standards
- Use Tailwind CSS for styling
- Implement proper validation and error handling
- Use Eloquent relationships for data access
- Follow RESTful API conventions

## Key Models
- **Site**: Multi-site configuration
- **Category**: Article categorization per site
- **Article**: Blog posts and content
- **Page**: Static pages
- **User**: Admin users

## Database Structure
- All content is scoped to sites
- Foreign key constraints maintain data integrity
- JSON fields for flexible settings and metadata

## Admin Features
- Dashboard with statistics
- CRUD operations for all entities
- Modern responsive design
- Real-time updates with Alpine.js
