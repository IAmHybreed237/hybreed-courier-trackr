# Shipment Tracking System Updates

## Overview
This document outlines the major enhancements made to the Royal Cost Delivery shipment tracking system.

## New Features Implemented

### 1. Extended Shipment Status Options (14 Statuses)
The system now supports 14 comprehensive shipment statuses:

1. **Order Created** - Initial shipment creation
2. **Picked Up** - Package collected from sender
3. **In Transit** - Package is moving between locations
4. **Arrived at Facility** - Package reached a distribution center
5. **Out for Delivery** - Package is with delivery personnel
6. **Delivered** - Package successfully delivered
7. **On Hold** - Shipment temporarily paused
8. **Delayed** - Shipment experiencing delays
9. **Attempted Delivery** - Delivery was attempted but failed
10. **Returned to Sender** - Package being sent back
11. **Cancelled** - Shipment cancelled
12. **Ready for Pickup** - Package ready for customer pickup
13. **Customs Clearance** - Package in customs processing
14. **Inactive** - Shipment inactive/archived

### 2. Shipment Journey/Timeline Feature
- **Visual Timeline**: A beautiful, vertical timeline showing the complete shipment history
- **Real-time Updates**: Displays all status changes with timestamps
- **Location Tracking**: Shows location for each status update
- **Remarks/Notes**: Displays additional information for each status change
- **Color-coded**: Current status highlighted in green, historical entries in yellow
- **Responsive Design**: Works perfectly on all devices

### 3. Automated Email Notification System
The system now automatically sends professional HTML emails to customers:

#### Email Triggers:
- **Shipment Creation**: Sent when a new shipment is created
  - Includes tracking number, sender/receiver details, dispatch and delivery dates
  - Provides direct link to track shipment
  
- **Status Updates**: Sent whenever shipment status changes
  - Shows old and new status
  - Displays current location
  - Includes timestamp of update
  - Provides tracking link

#### Email Configuration:
- Uses PHP's native `mail()` function
- HTML-formatted professional emails
- Company branding with Royal Cost Delivery colors
- Mobile-responsive email Hybreed Webworx Templates

### 4. Database Enhancements

#### New Table: `shipment_history`
```sql
CREATE TABLE `shipment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tracking_number` (`tracking_number`)
);
```

This table stores the complete history of all status changes for every shipment.

## Files Modified

### Admin Panel Files:
1. **`admin/add-tracking.php`**
   - Added all 14 status options
   - Integrated email notification on shipment creation
   - Automatic history logging

2. **`admin/edit-tracking.php`**
   - Updated with all 14 status options
   - Email notification on status change
   - Automatic history logging when status changes

### Frontend Files:
3. **`track.php`**
   - Added shipment journey/timeline section after map
   - Displays complete shipment history
   - Styled timeline with visual indicators

4. **`tracking.php`**
   - Added shipment journey/timeline section after map
   - Displays complete shipment history
   - Styled timeline with visual indicators

### New Files Created:
5. **`email_config.php`**
   - Email configuration and functions
   - HTML email Hybreed Webworx Templates
   - `sendShipmentCreatedEmail()` function
   - `sendStatusUpdateEmail()` function

### Database Files:
6. **`rapidexp_rapid.sql`**
   - Added `shipment_history` table structure
   - Updated with proper indexes and constraints

## Setup Instructions

### Step 1: Update Database
Run the updated SQL file to create the new `shipment_history` table:

```bash
# Option 1: Via phpMyAdmin
1. Open phpMyAdmin
2. Select your database (royalcargodbtt)
3. Go to Import tab
4. Upload rapidexp_rapid.sql
5. Execute

# Option 2: Via MySQL command line
mysql -u royalcargodbtt -p royalcargodbtt < rapidexp_rapid.sql
```

Or manually create the table:
```sql
CREATE TABLE `shipment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tracking_number` (`tracking_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Step 2: Configure Email Settings (Optional)
The system uses PHP's native `mail()` function by default. For better email deliverability, you can configure SMTP settings in `email_config.php`:

1. Open `email_config.php`
2. Uncomment the SMTP configuration section
3. Add your SMTP credentials:
```php
define('SMTP_HOST', 'smtp.your-provider.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@domain.com');
define('SMTP_PASSWORD', 'your-password');
define('SMTP_SECURE', 'tls');
```

### Step 3: Test the System

#### Test Shipment Creation:
1. Login to admin panel
2. Go to "Add Tracking"
3. Fill in all shipment details
4. Select a status from the dropdown
5. Submit the form
6. Check if email was sent to receiver

#### Test Status Update:
1. Login to admin panel
2. Go to Dashboard
3. Click "Update" on any shipment
4. Change the status
5. Update current location (optional)
6. Submit the form
7. Check if email was sent to receiver

#### Test Timeline Display:
1. Go to the tracking page
2. Enter a tracking number
3. Verify the timeline displays below the map
4. Check that all status changes are shown chronologically

## Email Notification Details

### Email Content - Shipment Created:
- Subject: "New Shipment Created - Tracking #[NUMBER]"
- Contains: Tracking number, sender/receiver info, dates
- Call-to-action: "Track Your Shipment" button

### Email Content - Status Update:
- Subject: "Shipment Status Update - Tracking #[NUMBER]"
- Contains: Old status, new status, location, timestamp
- Call-to-action: "Track Your Shipment" button

### Email Styling:
- Professional HTML design
- Company colors (Yellow #FFCC00)
- Mobile-responsive
- Includes company contact information in footer

## Timeline Feature Details

### Visual Design:
- Vertical timeline with connecting line
- Circular markers for each status
- Current status highlighted in green
- Historical statuses in yellow
- Card-based content display

### Information Displayed:
- Status name (bold, prominent)
- Location (with map marker icon)
- Date and time (with clock icon)
- Additional remarks/notes (italic)

### Responsive Behavior:
- Adapts to mobile screens
- Touch-friendly
- Maintains readability on all devices

## Security Considerations

### Current Implementation:
- Uses `htmlspecialchars()` for output escaping
- Input sanitization with `trim()`, `stripslashes()`
- Session-based authentication for admin

### Recommendations for Production:
1. **Use Prepared Statements**: Replace direct SQL queries with prepared statements to prevent SQL injection
2. **Validate Email Addresses**: Add email validation before sending
3. **Rate Limiting**: Implement rate limiting for email sending
4. **HTTPS**: Ensure site runs on HTTPS
5. **Input Validation**: Add more robust input validation
6. **CSRF Protection**: Add CSRF tokens to forms

## Troubleshooting

### Emails Not Sending:
1. Check if PHP `mail()` function is enabled on server
2. Verify email configuration in `email_config.php`
3. Check server mail logs
4. Consider using SMTP instead of native mail()
5. Verify sender email is not blacklisted

### Timeline Not Displaying:
1. Verify `shipment_history` table exists
2. Check if history records are being created
3. Verify database connection in `db.php`
4. Check browser console for JavaScript errors

### Status Not Updating:
1. Check database permissions
2. Verify form submission is working
3. Check admin session is active
4. Review error logs

## Future Enhancement Suggestions

1. **SMS Notifications**: Add SMS alerts for status changes
2. **Push Notifications**: Implement browser push notifications
3. **Multiple Recipients**: Allow multiple email recipients per shipment
4. **Email Hybreed Webworx Templates**: Admin panel to customize email Hybreed Webworx Templates
5. **Notification Preferences**: Let customers choose which updates to receive
6. **Delivery Proof**: Upload and display delivery photos
7. **Signature Capture**: Digital signature on delivery
8. **Real-time Tracking**: Live GPS tracking integration
9. **Estimated Time**: Show estimated delivery time
10. **Delivery Instructions**: Allow customers to add delivery notes

## Support

For issues or questions:
- Email: info@royaldeliveryinc.online
- Phone: +1 (Phone Number)

## Version History

**Version 2.0** (Current)
- Added 14 shipment statuses
- Implemented shipment journey/timeline
- Added automated email notifications
- Created shipment history tracking

**Version 1.0** (Previous)
- Basic tracking functionality
- 6 status options
- Manual updates only
