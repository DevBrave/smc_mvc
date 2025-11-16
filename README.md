# SMC MVC - Social Media Platform

A comprehensive social media platform built with PHP implementing a custom MVC architecture. This platform provides a complete social networking experience with modern web development practices.

## 🌟 Core Features

### 📝 Content Management
- **Posts Creation & Management**: Create, edit, update, and delete posts with rich content
- **Multiple Image Upload**: Support for uploading multiple images per post with dedicated image manager
- **Image Management**:
    - Upload multiple images to posts
    - Update attached images
    - Delete images when posts are removed
    - Preview images before upload
- **Tagging System**: Organize posts with custom tags for better categorization and discovery
- **Content Validation**: Built-in validation for post titles and content to ensure quality
- **Post Filtering**: Browse posts by tags and categories

### 👤 User Management
- **User Registration & Authentication**:
    - Secure user registration with profile picture upload
    - Login system with email and password
    - Session-based authentication
- **User Profiles**:
    - Customizable user profiles with avatars
    - Editable bio section
    - First name and last name fields
    - Profile picture management
- **User Roles**:
    - Regular user role with standard permissions
    - Admin role with full platform access
- **Profile Settings**:
    - Edit personal information (username, name, bio)
    - Upload/change profile pictures
    - Account status management (public/private profiles)
- **Profile Privacy**:
    - **Public Profiles**: Anyone can follow without approval
    - **Private Profiles**: Follow requests require acceptance

### 🤝 Social Features
- **Follow System**:
    - Follow and unfollow other users
    - Follower and following lists
    - Follower/following count display
    - View user followers and following
    - **Private Account Support**:
        - Send follow requests to private accounts
        - Pending follow request status
        - Accept/reject follow requests
- **Likes System**:
    - Like posts with one-click
    - Like comments and replies
    - Unlike functionality (toggle)
    - Like count display
- **Comment System**:
    - Comment on posts
    - Reply to comments (nested comments)
    - Edit own comments
    - Delete own comments
    - Full CRUD operations on comments
- **Social Feed**:
    - View posts from followed users
    - Discover new content from all users
    - Browse posts by user profile
    - Tag-based content discovery

### 🔔 Notification System
- **Real-time Notifications**: Advanced notification system for social interactions
- **Notification Types**:
    - Post likes notifications
    - Comment likes notifications
    - New follow notifications
    - Follow request notifications (for private accounts)
    - Comment and reply notifications
- **Notification Features**:
    - Actor-based system (who performed the action)
    - Object-type tracking (post, comment, user)
    - Context awareness (parent post/comment reference)
    - Group key system to prevent duplicate notifications
    - Notification recipients management
- **Notification Management**:
    - View all notifications in user dashboard
    - Notification count display
    - Mark notifications as read
    - Navigate directly to related content

### 🛡️ Security Features
- **CSRF Protection**:
    - Built-in CSRF token validation on all state-changing operations
    - Token regeneration per session
    - Middleware-based validation
- **Password Security**:
    - Secure password storage using PHP's `password_hash()`
    - Password verification with `password_verify()`
    - No plain-text password storage
- **JWT Authentication**:
    - API authentication using JSON Web Tokens
    - Secure token generation and validation
    - Token-based API access control
- **Input Validation**:
    - Comprehensive input validation system
    - Sanitization of user inputs
    - Validation rules engine
- **Role-based Access Control**:
    - Middleware-based permission system
    - Route-level access control
    - Admin-only protected routes
    - Authentication-required routes
    - Guest-only routes
- **SQL Injection Prevention**: Using PDO prepared statements
- **File Upload Security**:
    - File type validation
    - File size restrictions
    - Secure file naming and storage

### 🔧 Administrative Features
- **Admin Dashboard**:
    - Comprehensive admin control panel
    - Platform statistics overview
    - Quick access to management sections
- **User Management**:
    - View all users
    - Edit user information
    - Manage user roles (promote to admin/demote to user)
    - Update user bio and profile details
    - Admin-only user editing capabilities
- **Content Moderation**:
    - View all posts
    - Manage posts (edit/delete)
    - Moderate comments
    - Update comment content
    - Tag management (create, view, edit tags)
- **System Statistics**:
    - Total user count
    - Total posts count
    - Total comments count
    - Platform engagement metrics

### 🚀 API Support
- **RESTful API**: Complete API endpoints for mobile/frontend applications
- **API Version Management**: v1 API with versioned endpoints
- **API Authentication**:
    - JWT-based authentication
    - Bearer token support
    - Secure API access
- **JSON Responses**: Standardized JSON API responses
- **API Endpoints**:
    - User registration via API
    - User login via API
    - User logout via API
    - Get all posts
    - Create new posts (authenticated)
    - JWT middleware protection for authenticated endpoints

## 🏗️ Architecture

### Custom MVC Framework
This project implements a custom PHP MVC framework from scratch with the following components:

#### Core Components
- **App.php**: Application container for dependency injection
- **Router.php**: Advanced routing system with:
    - RESTful route support (GET, POST, PATCH, DELETE)
    - Dynamic route parameters (e.g., `/user/{id}`)
    - Middleware support per route
    - Route grouping capabilities
- **Database.php**: PDO-based database abstraction layer with:
    - Prepared statements
    - Query builder
    - Fetch methods (fetch, fetchAll, fetchCol)
    - Last insert ID support
- **Container.php**: Dependency injection container for service management
- **Validator.php**: Comprehensive validation system with custom rules
- **Jwt.php**: JSON Web Token implementation for API authentication
- **FileUploader.php**:
    - Secure file upload handling
    - Multiple file upload support
    - Image validation and processing
    - File organization by type
- **Request.php**: HTTP request handler for input data
- **Config.php**: Configuration management system

#### Middleware System
- **AuthMiddleware**:
    - Protects authenticated-only routes
    - Session verification
    - Redirects to login if not authenticated
- **AdminMiddleware**:
    - Admin role verification
    - Protects admin panel routes
    - Role-based access control
- **GuestMiddleware**:
    - Guest-only access (login/register pages)
    - Redirects authenticated users away from guest pages
- **CsrfMiddleware**:
    - CSRF token validation
    - Protects against cross-site request forgery
    - Token verification on POST/PATCH/DELETE requests
- **JwtMiddleware**:
    - JWT token validation for API requests
    - Bearer token extraction and verification
    - API authentication enforcement

#### Controllers

**Main Controllers:**
- **HomeController**: Landing page, about, and contact pages
- **AuthController**: User registration, login, and logout
- **UserController**:
    - User profiles display
    - Profile editing
    - View user posts
    - View followers/following
    - Notifications management
- **PostController**:
    - Create, read, update, delete posts
    - Post listing and browsing
    - Image handling
- **CommentController**: Comment CRUD operations
- **LikeController**:
    - Post likes
    - Comment likes
    - Notification triggers
- **FollowController**:
    - Follow/unfollow users
    - Handle private account follow requests
    - Follow status management
- **TagController**: Tag browsing and filtering

**Admin Controllers:**
- **Admin\AdminController**: Admin dashboard and statistics
- **Admin\UserController**: User management (edit, update roles)
- **Admin\PostController**: Post moderation and management
- **Admin\CommentController**: Comment moderation and updates
- **Admin\TagController**: Tag management (create, index, store)

**API Controllers:**
- **Api\AuthController**: API authentication (register, login, logout)
- **Api\PostController**: API post endpoints (list, create)
- **Api\ApiController**: Base API controller
- **Api\SystemController**: System-level API operations

#### Models
- **User**:
    - User CRUD operations
    - Authentication methods
    - Role checking (admin verification)
    - Profile updates
    - Avatar management
    - Public/private status handling
- **Post**:
    - Post creation and management
    - Post relationships (user, comments, likes)
    - Image associations
- **Comment**:
    - Comment CRUD
    - Nested comment support (parent-child relationships)
    - Comment ownership verification
- **Tag**:
    - Tag management
    - Post-tag relationships
    - Tag slugs for URLs
- **Follow**:
    - Follow/unfollow operations
    - Follower and following lists
    - Follow status tracking (accepted/pending)
    - Follow state determination (self, can_follow, following, pending)
    - Follower/following count methods
- **LikePost**: Post like management with toggle functionality
- **LikeComment**: Comment like management with toggle functionality
- **Notification**:
    - Create notifications for various actions
    - Actor and object tracking
    - Context management
    - Group key system for notification grouping
- **NotificationRecipient**:
    - Manage notification recipients
    - Send notifications to specific users
    - Track notification delivery
- **PostImageManager**:
    - Multiple image upload handling
    - Image attachment to posts
    - Image update operations
    - Image deletion with file cleanup
    - Get images by post ID

#### Validation System
- **validationRules.php**: Centralized validation rules for:
    - User registration
    - User login
    - Post creation/updates
    - Comment validation
    - Custom validation logic

## 📋 Requirements

- **PHP**: 7.4 or higher
- **MySQL**: 5.7 or higher
- **Web Server**: Apache or Nginx
- **Composer**: For PSR-4 autoloading
- **PHP Extensions**:
    - PDO extension
    - PDO_MySQL driver
    - GD extension (for image processing)
    - JSON extension (for API responses)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd reservation
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Database Setup
1. Create a new MySQL database named `small_social`
2. Import the database schema (SQL file should be provided)
3. Configure database connection

**Database Tables:**
- `users` - User accounts and profiles
- `posts` - User posts
- `post_images` - Post image attachments
- `comments` - Comments and replies
- `tags` - Content tags
- `post_tags` - Post-tag relationships (many-to-many)
- `follows` - User follow relationships with status
- `like_posts` - Post likes
- `like_comments` - Comment likes
- `notifications` - Notification records
- `notification_recipients` - Notification delivery tracking

### 4. Configuration
Update the database configuration in `config.php`:
```php
'database' => [
    'host' => 'localhost',
    'dbname' => 'small_social',
    'charset' => 'utf8mb4',
    'username' => 'your_username', // Add your DB username
    'password' => 'your_password'  // Add your DB password
]
```

### 5. File Permissions
Ensure the following directories are writable:
```bash
chmod 755 public/assets/uploads/
chmod 755 public/assets/uploads/posts/
chmod 755 public/assets/uploads/users/
chmod 755 app/view/
```

### 6. Web Server Configuration

#### Apache (.htaccess)
Create `.htaccess` in project root:
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
2. Fill in the registration form:
    - Username
    - First name and last name
    - Email address
    - Password
3. Upload a profile picture (optional)
4. Submit to create account
5. Automatically logged in after registration

### User Login
1. Navigate to `/login`
2. Enter email and password
3. Submit to access your account

### Creating Posts
1. Log in to your account
2. Navigate to `/post/create`
3. Write your post content
4. Upload images (optional, multiple images supported)
5. Select relevant tags
6. Publish your post

### Social Interactions
**Following Users:**
- Visit a user's profile
- Click "Follow" button
- If profile is private, wait for acceptance
- If profile is public, follow immediately

**Liking Content:**
- Click heart icon on posts or comments
- Click again to unlike

**Commenting:**
- Write comments on posts
- Reply to existing comments
- Edit or delete your own comments

**Notifications:**
- Click notification icon to view all notifications
- View who liked, commented, or followed you
- See follow requests for private accounts

### Profile Management
1. Navigate to `/user/{your-username}`
2. View your profile, posts, followers, and following
3. Click "Edit Profile" to update:
    - Profile information
    - Avatar
    - Bio
    - Account status (public/private)

### Admin Access
1. Ensure your user account has `role = 'admin'` in database
2. Navigate to `/admin`
3. Access admin dashboard with:
    - User management
    - Post moderation
    - Comment management
    - Tag administration
    - Platform statistics

## 🛠️ API Documentation

### Base URL
```
/api/v1
```

### Authentication Endpoints

#### Register User
```http
POST /api/v1/auth/register
Content-Type: application/json

{
  "username": "string",
  "first_name": "string",
  "last_name": "string",
  "email": "string",
  "password": "string",
  "avatar": "file" (optional)
}

Response: JWT token
```

#### Login
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "string",
  "password": "string"
}

Response: JWT token
```

#### Logout
```http
DELETE /api/v1/auth/logout
Authorization: Bearer <jwt-token>

Response: Success message
```

### Post Endpoints

#### Get All Posts
```http
GET /api/v1/posts

Response: Array of posts with user data, images, likes, and comments
```

#### Create Post
```http
POST /api/v1/posts
Authorization: Bearer <jwt-token>
Content-Type: application/json

{
  "title": "string",
  "content": "string",
  "images": "files[]" (optional),
  "tags": "array" (optional)
}

Response: Created post object
```

### Authentication
For API requests requiring authentication, include JWT token in header:
```http
Authorization: Bearer <your-jwt-token>
```

## 🎨 Frontend Features

- **Responsive Design**: Mobile-first design that works on all devices
- **Clean UI**: Intuitive user interface with modern design
- **Real-time Form Validation**: Client-side validation before submission
- **Image Preview**: Preview images before uploading
- **CSRF Protection**: All forms include CSRF tokens
- **Flash Messages**: Success and error message notifications
- **AdminLTE**: Professional admin panel design using AdminLTE template
- **Interactive Elements**: Like buttons, follow buttons with instant feedback
- **Profile Cards**: User profile display cards
- **Notification Badge**: Unread notification count indicator

## 🔒 Security Measures

1. **Password Security**:
    - All passwords hashed using `password_hash()` with bcrypt
    - Passwords never stored in plain text
    - Secure password verification

2. **CSRF Protection**:
    - All state-changing operations protected with CSRF tokens
    - Token validation via middleware
    - Tokens regenerated per session

3. **Input Validation**:
    - All user inputs validated server-side
    - Sanitization to prevent XSS attacks
    - Type checking and length restrictions

4. **SQL Injection Prevention**:
    - Using PDO prepared statements exclusively
    - Parameter binding for all queries
    - No raw SQL with user input

5. **File Upload Security**:
    - Strict file type validation (images only)
    - File size limitations
    - Secure file naming (preventing overwrites)
    - Files stored outside public access where appropriate

6. **Session Management**:
    - Secure session handling
    - Session fixation prevention
    - Proper session destruction on logout

7. **Authentication Security**:
    - JWT tokens for API
    - Session-based auth for web
    - Token expiration
    - Secure token storage

8. **Authorization**:
    - Role-based access control
    - Ownership verification (users can only edit their own content)
    - Admin privilege verification
    - Route-level middleware protection

## 📁 Project Structure

```
reservation/
├── Core/                      # Custom MVC framework core
│   ├── App.php               # Application container (DI)
│   ├── Router.php            # Routing system with middleware
│   ├── Database.php          # PDO database abstraction
│   ├── Validator.php         # Validation system
│   ├── Jwt.php               # JWT authentication handler
│   ├── FileUploader.php      # File upload manager
│   ├── Request.php           # HTTP request handler
│   ├── Config.php            # Configuration loader
│   └── Container.php         # Dependency injection container
│
├── app/                      # Application logic
│   ├── Controllers/          # Controller classes
│   │   ├── Admin/           # Admin panel controllers
│   │   │   ├── AdminController.php
│   │   │   ├── UserController.php
│   │   │   ├── PostController.php
│   │   │   ├── CommentController.php
│   │   │   └── TagController.php
│   │   ├── Api/             # API controllers
│   │   │   ├── ApiController.php
│   │   │   ├── AuthController.php
│   │   │   ├── PostController.php
│   │   │   └── SystemController.php
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── UserController.php
│   │   ├── PostController.php
│   │   ├── CommentController.php
│   │   ├── LikeController.php
│   │   ├── FollowController.php
│   │   └── TagController.php
│   │
│   ├── Model/               # Model classes
│   │   ├── User.php         # User model
│   │   ├── Post.php         # Post model
│   │   ├── Comment.php      # Comment model
│   │   ├── Tag.php          # Tag model
│   │   ├── Follow.php       # Follow relationship model
│   │   ├── LikePost.php     # Post like model
│   │   ├── LikeComment.php  # Comment like model
│   │   ├── Notification.php # Notification model
│   │   ├── NotificationRecipient.php # Notification delivery
│   │   └── PostImageManager.php      # Image management
│   │
│   ├── Middleware/          # Middleware classes
│   │   ├── AuthMiddleware.php      # Authentication guard
│   │   ├── AdminMiddleware.php     # Admin role guard
│   │   ├── GuestMiddleware.php     # Guest-only guard
│   │   ├── CsrfMiddleware.php      # CSRF protection
│   │   └── JwtMiddleware.php       # JWT validation
│   │
│   ├── Contract/            # Interface contracts
│   │   └── MiddlewareInterface.php
│   │
│   ├── Validations/         # Validation rules
│   │   └── validationRules.php
│   │
│   └── view/                # View templates
│       ├── admin/           # Admin panel views
│       ├── auth/            # Login/register views
│       ├── posts/           # Post views
│       ├── users/           # User profile views
│       ├── comments/        # Comment views
│       ├── partials/        # Reusable components
│       └── errors/          # Error pages (404, etc.)
│
├── routes/                  # Route definitions
│   ├── routes.php          # Web routes
│   └── api.php             # API routes
│
├── public/                 # Public assets and entry point
│   ├── index.php           # Application entry point
│   ├── assets/
│   │   ├── admin/          # AdminLTE assets
│   │   ├── img/            # Public images
│   │   └── uploads/        # User uploaded files
│   │       ├── posts/      # Post images
│   │       └── users/      # User avatars
│   ├── fake_user_data.php  # Test data generator (dev)
│   └── login_data.php      # Login testing (dev)
│
├── helpers/                # Helper functions
│   └── helpers.php         # Global helper functions
│
├── vendor/                 # Composer dependencies
├── .git/                   # Git repository
├── .gitignore             # Git ignore rules
├── bootstrap.php          # Application bootstrap
├── composer.json          # Composer configuration
├── composer.lock          # Dependency lock file
├── config.php             # Application configuration
├── PROJECT_DOCUMENTATION.html  # Project documentation
└── README.md              # This file
```

## 🚦 Routing System

The application uses a custom router with the following features:

**Route Methods:**
- `GET` - Retrieve resources
- `POST` - Create resources
- `PATCH` - Update resources
- `DELETE` - Delete resources

**Route Protection:**
Routes can be protected with middleware using `->only()`:
```php
$router->get('/admin', 'AdminController@dashboard')->only('admin');
$router->post('/post/create', 'PostController@store')->only(['auth', 'csrf']);
```

**Available Middleware:**
- `auth` - Requires authentication
- `guest` - Guests only (not authenticated)
- `admin` - Admin role required
- `csrf` - CSRF token validation
- `jwt` - JWT authentication (API)

## 🔄 Key Workflows

### Post Creation Flow
1. User accesses `/post/create` (AuthMiddleware checks authentication)
2. Form displays with CSRF token
3. User fills form and uploads images
4. PostController validates input
5. Post saved to database
6. Images uploaded via PostImageManager
7. Images attached to post in `post_images` table
8. User redirected to post view

### Follow Request Flow (Private Account)
1. User A clicks follow on User B's profile
2. System checks if User B has private profile
3. Follow record created with `status = 'pending'`
4. Notification created with type `follow_requested`
5. User B sees notification
6. User B can accept or reject request
7. Status updated to `accepted` or record deleted

### Notification Flow
1. User performs action (like, comment, follow)
2. System identifies affected users (post owner, comment owner, etc.)
3. Notification created with actor, type, object, and context
4. NotificationRecipient records created for recipients
5. Recipients see notification count badge
6. Clicking notification navigates to related content

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 Development Notes

- This project uses **PSR-4 autoloading** via Composer
- All database queries use **prepared statements** for security
- The framework follows **MVC pattern** strictly
- **Dependency Injection** is handled through the Container class
- All middleware implements **MiddlewareInterface**
- File uploads are organized by type (posts, users)
- The project includes test data generators in `public/` for development

## 🐛 Known Issues / TODO
- Database credentials need to be added to `config.php`
- SQL schema file needs to be provided for installation
- Notification "mark as read" functionality may need implementation
- Follow request accept/reject UI needs to be confirmed
- API documentation could be expanded with response examples

## 📄 License

This project is a self-project for learning purposes.

## 👨‍💻 Author

DevBrave - `devbrave/smc_mvc`

---

**Built with ❤️ using Custom PHP MVC Architecture**
