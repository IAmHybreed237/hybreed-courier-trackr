# Hybreed Courier - Courier Tracking System Template By Hybreed X

A production-ready courier tracking web application template by **Hybreed X**. Download, configure, and deploy your own shipment tracking system with a modern, responsive UI and a full-featured admin dashboard.

## Features

- **Shipment Tracking** — Users can track shipments by entering a tracking number on the public tracking page
- **Shipment Journey Timeline** — Visual timeline showing the complete shipment history with status, location, timestamps, and remarks
- **Live Google Maps Integration** — Dynamic map display showing the current/dispatch location of each shipment
- **Admin Dashboard** — Secure admin panel for managing shipments:
  - Add new shipments with auto-generated tracking numbers
  - Edit and update shipment status, location, and details
  - Delete shipments
  - Update admin credentials
- **14 Shipment Statuses** — Order Created, Picked Up, In Transit, Arrived at Facility, Out for Delivery, Delivered, On Hold, Delayed, Attempted Delivery, Returned to Sender, Cancelled, Ready for Pickup, Customs Clearance, Inactive
- **Automated Email Notifications** — Sends HTML-formatted emails to receivers when:
  - A new shipment is created
  - Shipment status is updated
- **PDF Receipt Generation** — Download or view printable shipment receipts with sender/receiver details and full shipment history
- **Google Translate Integration** — Multi-language support for the tracking interface
- **Responsive Design** — Works seamlessly across desktop, tablet, and mobile devices
- **Service Pages** — Dedicated pages for Air Freight, Ocean Freight, Road Freight, Export & Import, Logistics Forwarding, and Transportation services

## Tech Stack

- **Frontend:** HTML5, CSS3, Bootstrap 4, Font Awesome, Swiper.js, jQuery
- **Backend:** PHP 8+ (procedural MySQLi with prepared statements)
- **Database:** MySQL / MariaDB
- **PDF Generation:** mPDF (via Composer)
- **Email:** PHP native `mail()` function with configurable SMTP support

## Project Structure

```
hybreed-courier/
├── admin/                       # Admin panel
│   ├── add-tracking.php         # Create new shipments
│   ├── edit-tracking.php        # Edit/update shipments
│   ├── dashboard.php            # Shipment list & delete
│   ├── signin.php               # Admin login
│   ├── login.php                # Admin logout handler
│   ├── logout.php               # Session destroy
│   ├── settings.php             # Update admin credentials
│   ├── header.php               # Admin header partial
│   └── footer.php               # Admin footer partial
├── css/                         # Stylesheets (Bootstrap, Font Awesome, custom)
├── js/                          # JavaScript (jQuery, Bootstrap, Swiper, custom)
├── images/                      # Images and assets
├── fonts/                       # Font files
├── logo/                        # Logo placeholder (replace with your own)
├── uploads/                     # User uploads (branding, signatures, stamps)
├── vendor/                      # Composer dependencies (mPDF)
├── index.html                   # Homepage
├── about.html                   # About page
├── contact.html                 # Contact page
├── service.html                 # Services overview
├── services-overview.html       # Detailed services breakdown
├── service-air-freight.html     # Air freight service page
├── service-ocean-freight.html   # Ocean freight service page
├── service-road-freight.html    # Road freight service page
├── service-export-import.html   # Export & import service page
├── service-forwarding.html      # Logistics forwarding service page
├── service-transportation.html  # Transportation service page
├── track.html                   # Public tracking form
├── track-demo.html              # Static tracking demo page
├── track-handler.php            # Tracking form handler (receives POST)
├── tracking-result.php          # Tracking results display
├── tracking-details.php         # Alternative tracking details view
├── receipt.php                  # PDF receipt generation
├── db.php                       # Database connection (uses environment variables)
├── email_config.php             # Email notification functions
├── database.sql                 # Database schema & sample data
├── CHANGELOG.md                 # Version history & feature log
└── .gitignore
```

## Quick Start

### Prerequisites

- PHP 8.0 or higher
- MySQL / MariaDB
- Web server (Apache/Nginx) or PHP built-in server
- [Composer](https://getcomposer.org/) (for mPDF dependency)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/IAmHybreed237/hybreed-courier.git
   cd hybreed-courier
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Set up the database**
   - Create a MySQL database (e.g., `hybreed_courier`)
   - Import the schema:
     ```bash
     mysql -u your_username -p hybreed_courier < database.sql
     ```
   - Or import via phpMyAdmin by uploading `database.sql`

4. **Configure database credentials**

   Set environment variables (recommended):
   ```bash
   export DB_SERVER=localhost
   export DB_USERNAME=your_db_username
   export DB_PASSWORD=your_db_password
   export DB_NAME=hybreed_courier
   ```

   Or edit `db.php` directly with your database credentials.

5. **Configure email settings (optional)**

   Edit `email_config.php` or set environment variables:
   ```bash
   export SMTP_HOST=mail.yourdomain.com
   export SMTP_PORT=587
   export SMTP_USERNAME=your@email.com
   export SMTP_PASSWORD=your_password
   ```

6. **Replace the logo**

   Replace `logo/logo-placeholder.svg` with your own logo file (PNG recommended, 200x60px or similar).

7. **Change the default admin password**

   After first login, go to **Settings** in the admin panel and change the default credentials.

8. **Serve the application**
   ```bash
   php -S localhost:8000
   ```
   Or deploy to your web server's document root.

### Default Admin Credentials

- **Username:** `admin@hybreedinc.com`
- **Password:** `change_this_password`

> **Important:** Change these immediately after setup via the admin Settings page.

## Customization

This template uses sensible defaults that you can customize:

| Setting | Default Value | Where to Change |
|---|---|---|
| Company name | Hybreed Courier | All HTML `<title>` tags and footer text |
| Contact email | support@hybreedinc.com | All HTML files, `email_config.php` |
| Contact phone | +7 9896472811 | All HTML files |
| Address | Your Business Address Here | All HTML files |
| Logo | `logo/logo-placeholder.svg` | Replace file in `logo/` directory |
| Database name | hybreed_courier | `db.php` or `DB_NAME` env var |
| SMTP settings | Environment variables | `email_config.php` |

## Usage

### Tracking a Shipment

1. Navigate to `track.html`
2. Enter a tracking number (e.g., `VB6UPQ0WLI` from the sample data)
3. Click "Track" to view shipment details, timeline, and live map

### Managing Shipments (Admin)

1. Navigate to `admin/signin.php`
2. Log in with admin credentials
3. Use the dashboard to add, edit, or delete shipments
4. Status changes automatically log to the shipment history timeline and trigger email notifications

## Security

- All database queries use **prepared statements** to prevent SQL injection
- Admin panel is protected by session-based authentication
- Database credentials use **environment variables** with safe defaults
- SMTP credentials use **environment variables** (no hardcoded passwords)
- User input is sanitized with `trim()`, `stripslashes()`, and `htmlspecialchars()`
- Output is escaped with `htmlspecialchars()` to prevent XSS

## Developer

**Hybreed X (Ayuketang Agbornoh) ** — Web Development, App Development & Tech Solutions
- GitHub: [@IAmHybreed237](https://github.com/IAmHybreed237)
- Email: support@hybreedinc.com
- Phone: +7 9896472811

## License

This project is open-source and available for educational and portfolio purposes.
