# SMC MVC - Social Media Platform

A comprehensive social media platform built with PHP implementing a custom MVC architecture. This platform provides a complete social networking experience with modern web development practices.

## 🌟 Features

### 📝 Content Management
- **Posts Creation & Management**: Create, edit, and delete posts with rich content
- **Image Upload**: Support for multiple image uploads per post
- **Tagging System**: Organize posts with custom tags for better categorization
- **Content Validation**: Built-in validation for post titles and content

### 👤 User Management
- **User Registration & Authentication**: Secure user registration and login system
- **User Profiles**: Customizable user profiles with avatars and bio
- **User Roles**: Support for regular users and admin roles
- **Profile Management**: Edit personal information and upload profile pictures

### 🤝 Social Features
- **Follow System**: Follow and unfollow other users
- **Likes System**: Like posts and comments
- **Comment System**: Comment on posts with full CRUD operations
- **Social Feed**: View posts from followed users and discover new content

### 🛡️ Security Features
- **CSRF Protection**: Built-in CSRF token validation
- **Password Hashing**: Secure password storage using PHP's password_hash()
- **JWT Authentication**: API authentication using JSON Web Tokens
- **Input Validation**: Comprehensive input validation and sanitization
- **Role-based Access Control**: Middleware-based permission system

### 🔧 Administrative Features
- **Admin Dashboard**: Comprehensive admin control panel
- **User Management**: Admin can manage user accounts and roles
- **Content Moderation**: Manage posts, comments, and tags
- **System Statistics**: View platform statistics and analytics

### 🚀 API Support
- **RESTful API**: Complete API endpoints for mobile/frontend applications
- **API Authentication**: JWT-based API authentication
- **JSON Responses**: Standardized JSON API responses

## 🏗️ Architecture

### Custom MVC Framework
This project implements a custom PHP MVC framework with the following components:

#### Core Components
- **Router**: Advanced routing with parameter support and middleware
- **Database**: PDO-based database abstraction layer
- **Container**: Dependency injection container
- **Validator**: Comprehensive validation system
- **JWT Handler**: JSON Web Token implementation
- **File Uploader**: Secure file upload handling

#### Middleware System
- **AuthMiddleware**: Authentication protection
- **AdminMiddleware**: Admin role protection  
- **GuestMiddleware**: Guest-only access
- **CsrfMiddleware**: CSRF token validation
- **JwtMiddleware**: JWT token validation for API

#### Models
- **User Model**: User management and authentication
- **Post Model**: Post creation and management
- **Comment Model**: Comment system
- **Tag Model**: Tagging system
- **Follow Model**: Social following system
- **Like Models**: Like functionality for posts and comments

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (for autoloading)
- GD extension (for image processing)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd smc_mvc
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Database Setup
1. Create a new MySQL database named `small_social`
2. Import the database schema (SQL file should be provided)
3. Update database credentials in `config.php`

### 4. Configuration
Update the database configuration in `config.php`:
```php
'database' => [
    'host' => 'localhost',
    'dbname' => 'small_social',
    'charset' => 'utf8mb4',
    'username' => 'your_username',
    'password' => 'your_password'
]
```

### 5. File Permissions
Ensure the following directories are writable:
```bash
chmod 755 public/assets/uploads/
chmod 755 app/view/
```

### 6. Web Server Configuration

#### Apache (.htaccess)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ public/index.php [QSA,L]
```

#### Nginx
```nginx
location / {
    try_files $uri $uri/ /public/index.php?$query_string;
}
```

## 📖 Usage

### User Registration
1. Navigate to `/register`
2. Fill in the registration form
3. Upload a profile picture (optional)
4. Submit to create account

### Creating Posts
1. Log in to your account
2. Navigate to `/post/create`
3. Write your post content
4. Add images (optional)
5. Select relevant tags
6. Publish your post

### Admin Access
1. Ensure your user account has admin role in database
2. Navigate to `/admin`
3. Access admin dashboard with full management capabilities

## 🛠️ API Documentation

### Authentication Endpoints
```
POST /api/v1/auth/register - Register new user
POST /api/v1/auth/login - User login
DELETE /api/v1/auth/logout - User logout
```

### Post Endpoints
```
GET /api/v1/posts - Get all posts
POST /api/v1/posts - Create new post (requires JWT)
```

### Authentication
For API requests requiring authentication, include JWT token in header:
```
Authorization: Bearer <your-jwt-token>
```

## 🎨 Frontend Features

- Responsive design for mobile and desktop
- Clean and intuitive user interface
- Real-time form validation
- Image preview before upload
- CSRF protection on all forms

## 🔒 Security Measures

1. **Password Security**: All passwords are hashed using PHP's `password_hash()`
2. **CSRF Protection**: All state-changing operations are protected with CSRF tokens
3. **Input Validation**: All user inputs are validated and sanitized
4. **SQL Injection Prevention**: Using prepared statements with PDO
5. **File Upload Security**: Strict file type and size validation
6. **Session Management**: Secure session handling

## 📁 Project Structure

```
smc_mvc/
├── Core/                 # Custom MVC framework core
│   ├── App.php          # Application container
│   ├── Router.php       # Routing system
│   ├── Database.php     # Database abstraction
│   ├── Validator.php    # Validation system
│   └── ...
├── app/                 # Application logic
│   ├── Controllers/     # Controller classes
│   ├── Model/          # Model classes
│   ├── Middleware/     # Middleware classes
│   ├── view/           # View templates
│   └── Validations/    # Validation rules
├── routes/             # Route definitions
├── public/             # Public assets and entry point
├── helpers/            # Helper functions
└── config.php          # Configuration file
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request


