# 🚌 STC Bus Reservation System

A modern, full-featured bus reservation system built with Laravel, designed for STC (State Transport Corporation) to manage routes, trips, bookings, and passenger services.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg)
![Bootstrap Icons](https://img.shields.io/badge/Bootstrap_Icons-1.x-7952B3.svg)

## 📋 Table of Contents

- [Features](#-features)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [API Documentation](#-api-documentation)
- [Database Schema](#-database-schema)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🎯 Core Functionality
- **Route Management**: Create and manage bus routes with fixed pricing
- **Trip Scheduling**: Schedule trips for routes with specific dates and times
- **Seat Reservation**: Interactive seat selection with real-time availability
- **Booking System**: Complete booking workflow with confirmation
- **QR Code Tickets**: Generate QR codes for easy ticket verification
- **User Management**: User registration, authentication, and profile management

### 👥 User Features
- **Browse Routes**: View all available routes with pricing
- **Search Trips**: Filter trips by date, origin, destination
- **Real-time Availability**: See seat availability and occupancy percentages
- **Booking History**: View past and upcoming bookings
- **Ticket Management**: Download and view booking confirmations
- **Responsive Design**: Mobile-friendly interface

### 🔧 Admin Features
- **Dashboard**: Overview of bookings, routes, and revenue
- **Route Management**: Create, edit, and manage routes with pricing
- **Trip Management**: Schedule and manage trips
- **Bus Management**: Manage bus fleet and seat configurations
- **Booking Management**: View and manage all bookings
- **User Management**: Manage user accounts and roles
- **QR Scanner**: Scan tickets for verification

### 🎨 UI/UX Features
- **Modern Design**: Clean, professional interface using Tailwind CSS
- **Responsive Layout**: Works seamlessly on desktop, tablet, and mobile
- **Interactive Elements**: Hover effects, animations, and smooth transitions
- **Real-time Updates**: Live seat availability and booking status
- **Accessibility**: Keyboard navigation and screen reader support

## 📸 Screenshots

### User Interface
- **Homepage**: Welcome screen with booking options
- **Available Trips**: Grid view of all available trips with filtering
- **Route Selection**: Browse routes with pricing information
- **Seat Selection**: Interactive seat map for booking
- **Booking Confirmation**: QR code ticket generation

### Admin Interface
- **Admin Dashboard**: Overview statistics and quick actions
- **Route Management**: CRUD operations for routes
- **Trip Management**: Schedule and monitor trips
- **Booking Overview**: Manage all passenger bookings

## 🚀 Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Node.js and NPM (for asset compilation)
- Git

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-username/stc-reservation.git
cd stc-reservation
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stc_reservation
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 4: Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### Step 5: Asset Compilation
```bash
npm run dev
# or for production
npm run build
```

### Step 6: Start the Application
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## ⚙️ Configuration

### Default Login Credentials
After seeding the database, you can use these default accounts:

**Admin Account:**
- Email: `admin@stc.com`
- Password: `admin123`

**Regular User:**
- Email: `kwame.mensah@gmail.com`
- Password: `password`

### Environment Variables
Key environment variables to configure:

```env
APP_NAME="STC Bus Reservation"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stc_reservation
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@stc.com
MAIL_FROM_NAME="${APP_NAME}"
```

## 📖 Usage

### For Passengers

#### 1. Browse Available Trips
- Visit the homepage and click "Book Tickets"
- View all available trips with real-time seat availability
- Filter trips by date (Today, Tomorrow, This Week)
- Search by origin, destination, or bus name

#### 2. Select a Trip
- Choose your preferred trip from the available options
- View trip details including:
  - Route information (origin → destination)
  - Departure date and time
  - Fixed price per seat
  - Available seats and occupancy percentage

#### 3. Book Seats
- Click "Select Seats" to proceed to seat selection
- Choose your preferred seats from the interactive seat map
- Available seats are shown in green, booked seats in red
- Select multiple seats if needed

#### 4. Complete Booking
- Review your booking details
- Confirm passenger information
- Complete the booking process
- Receive QR code ticket for verification

#### 5. Manage Bookings
- View booking history in your dashboard
- Download booking confirmations
- Cancel bookings (if allowed)

### For Administrators

#### 1. Dashboard Overview
- View total bookings, routes, and revenue
- Monitor recent activities
- Quick access to management functions

#### 2. Route Management
- Create new routes with origin, destination, and pricing
- Edit existing routes
- View route statistics and trip counts
- Set fixed pricing for each route

#### 3. Trip Management
- Schedule trips for specific routes
- Assign buses to trips
- Set departure dates and times
- Monitor booking status and occupancy

#### 4. Bus Management
- Add new buses to the fleet
- Configure seat layouts
- Track bus assignments to trips

#### 5. Booking Management
- View all passenger bookings
- Monitor booking status
- Handle cancellations and modifications
- Generate reports

#### 6. QR Code Verification
- Use the QR scanner to verify tickets
- Scan passenger QR codes for boarding
- Track passenger check-ins

## 🔌 API Documentation

### Authentication Endpoints
```
POST /api/login
POST /api/register
POST /api/logout
```

### Route Endpoints
```
GET /api/routes
GET /api/routes/{id}
POST /api/routes (admin only)
PUT /api/routes/{id} (admin only)
DELETE /api/routes/{id} (admin only)
```

### Trip Endpoints
```
GET /api/trips
GET /api/trips/{id}
GET /api/trips/{id}/seats
POST /api/trips (admin only)
PUT /api/trips/{id} (admin only)
DELETE /api/trips/{id} (admin only)
```

### Booking Endpoints
```
GET /api/bookings
GET /api/bookings/{id}
POST /api/bookings
PUT /api/bookings/{id}
DELETE /api/bookings/{id}
```

## 🗄️ Database Schema

### Core Tables

#### `users`
- User accounts with role-based access
- Fields: id, name, email, password, role, created_at, updated_at

#### `routes`
- Bus routes with fixed pricing
- Fields: id, origin, destination, price, created_at, updated_at

#### `buses`
- Bus fleet management
- Fields: id, name, seat_count, created_at, updated_at

#### `trips`
- Scheduled trips for routes
- Fields: id, route_id, bus_id, departure_date, departure_time, created_at, updated_at

#### `seats`
- Individual seats for buses
- Fields: id, bus_id, seat_number, created_at, updated_at

#### `bookings`
- Passenger bookings
- Fields: id, user_id, trip_id, seat_id, status, booking_date, created_at, updated_at

### Relationships
- **Route** has many **Trips**
- **Trip** belongs to **Route** and **Bus**
- **Bus** has many **Seats**
- **Trip** has many **Bookings**
- **User** has many **Bookings**
- **Seat** has many **Bookings**

## 🛠️ Technical Stack

### Backend
- **Laravel 10.x**: PHP framework for web applications
- **MySQL 8.0+**: Relational database management system
- **Eloquent ORM**: Database abstraction layer
- **Laravel Sanctum**: API authentication

### Frontend
- **Blade Templates**: Laravel's templating engine
- **Tailwind CSS**: Utility-first CSS framework
- **Bootstrap Icons**: Icon library
- **Alpine.js**: Lightweight JavaScript framework
- **QR Code Library**: QR code generation

### Development Tools
- **Composer**: PHP dependency management
- **NPM**: Node.js package management
- **Laravel Mix**: Asset compilation
- **PHP Artisan**: Command-line interface

## 🔒 Security Features

- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Role-based access control (Admin/User)
- **CSRF Protection**: Cross-site request forgery protection
- **Input Validation**: Server-side validation for all inputs
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Blade template escaping

## 📱 Mobile Responsiveness

The application is fully responsive and optimized for:
- **Desktop**: Full-featured interface with all capabilities
- **Tablet**: Optimized layout for medium screens
- **Mobile**: Touch-friendly interface for smartphones

## 🚀 Performance Optimization

- **Database Indexing**: Optimized queries with proper indexing
- **Eager Loading**: Reduced N+1 query problems
- **Asset Minification**: Compressed CSS and JavaScript
- **Caching**: Laravel's caching system for improved performance
- **Lazy Loading**: Images and content loaded on demand

## 🧪 Testing

### Running Tests
```bash
php artisan test
```

### Test Coverage
- Unit tests for models and services
- Feature tests for user workflows
- Integration tests for API endpoints

## 📊 Monitoring and Analytics

- **Booking Analytics**: Track booking patterns and revenue
- **Route Performance**: Monitor popular routes and occupancy
- **User Activity**: Track user engagement and behavior
- **System Health**: Monitor application performance

## 🔄 Deployment

### Production Deployment
1. Set up production server with PHP 8.1+
2. Configure web server (Apache/Nginx)
3. Set up SSL certificate
4. Configure environment variables
5. Run database migrations
6. Compile assets for production
7. Set up cron jobs for scheduled tasks

### Recommended Hosting
- **Shared Hosting**: For small to medium operations
- **VPS**: For better control and performance
- **Cloud Platforms**: AWS, DigitalOcean, or similar

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Use meaningful commit messages

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

### Getting Help
- **Documentation**: Check this README and inline code comments
- **Issues**: Report bugs and feature requests via GitHub Issues
- **Discussions**: Use GitHub Discussions for questions and ideas

### Common Issues
- **Database Connection**: Ensure MySQL is running and credentials are correct
- **Permission Errors**: Check file permissions for storage and cache directories
- **Asset Compilation**: Ensure Node.js and NPM are properly installed

## 🙏 Acknowledgments

- **Laravel Team**: For the amazing PHP framework
- **Tailwind CSS**: For the utility-first CSS framework
- **Bootstrap Icons**: For the comprehensive icon library
- **Contributors**: All developers who contributed to this project

## 📞 Contact

- **Project Maintainer**: [Your Name]
- **Email**: [your-email@example.com]
- **Website**: [https://your-website.com]

---

**Made with ❤️ for STC Bus Reservation System**

*This README is maintained and updated regularly. For the latest information, always check the repository.*
