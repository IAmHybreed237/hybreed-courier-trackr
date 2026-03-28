# Custom Date/Time Feature for Tracking Updates

## Overview
This feature allows admins to set custom date and time values when creating or updating tracking information, instead of using the default system time.

## Changes Made

### 1. Database Changes
**File:** `add_custom_date_column.sql`
- Added `custom_date` column to `shipment_history` table
- This column stores the admin-specified date/time for each tracking update

**To Apply:**
Run the SQL migration file in your database:
```sql
ALTER TABLE `shipment_history` 
ADD COLUMN `custom_date` DATETIME NULL AFTER `remarks`;

UPDATE `shipment_history` 
SET `custom_date` = `created_at` 
WHERE `custom_date` IS NULL;
```

### 2. Add Tracking Page
**File:** `admin/add-tracking.php`
- Added "Initial Tracking Date & Time" field
- Allows admins to set custom date/time when creating new tracking
- If left empty, uses current system date/time
- Field is located in the "Other Info" section

### 3. Edit Tracking Page
**File:** `admin/edit-tracking.php`
- Added "Status Update Date & Time" field
- Allows admins to set custom date/time when updating tracking status
- Only creates history entry when status changes
- If left empty, uses current system date/time

### 4. Tracking Display Page
**File:** `tracking.php`
- Updated to display custom date/time if available
- Falls back to `created_at` if no custom date is set
- Orders timeline by custom date for accurate chronological display

## How to Use

### Creating New Tracking with Custom Date/Time
1. Go to Admin Dashboard → Add Tracking
2. Fill in all required tracking information
3. In the "Other Info" section, find "Initial Tracking Date & Time"
4. Click the field and select your desired date and time
5. Leave empty to use current date/time
6. Click "Add" to save

### Updating Tracking with Custom Date/Time
1. Go to Admin Dashboard → Edit Tracking
2. Make your changes (especially status changes)
3. Find "Status Update Date & Time" field
4. Set your desired date and time for this update
5. Leave empty to use current date/time
6. Click "Update" to save

### Viewing Custom Date/Time
- Clients will see the custom date/time on the tracking page
- The timeline displays updates in chronological order based on custom dates
- Format: "Month Day, Year Hour:Minute AM/PM" (e.g., "October 21, 2026 05:30 PM")

## Testing Checklist

### Before Testing
- [ ] Run the SQL migration to add `custom_date` column
- [ ] Verify database connection is working

### Test 1: Create New Tracking with Custom Date
- [ ] Navigate to Add Tracking page
- [ ] Fill in all required fields
- [ ] Set "Initial Tracking Date & Time" to a past date (e.g., 3 days ago)
- [ ] Submit the form
- [ ] Check tracking page - verify the custom date is displayed

### Test 2: Create New Tracking without Custom Date
- [ ] Navigate to Add Tracking page
- [ ] Fill in all required fields
- [ ] Leave "Initial Tracking Date & Time" empty
- [ ] Submit the form
- [ ] Check tracking page - verify current date/time is displayed

### Test 3: Update Tracking Status with Custom Date
- [ ] Navigate to Edit Tracking page
- [ ] Change the status
- [ ] Set "Status Update Date & Time" to a specific date/time
- [ ] Submit the form
- [ ] Check tracking page - verify the custom date is displayed for the update

### Test 4: Update Tracking Status without Custom Date
- [ ] Navigate to Edit Tracking page
- [ ] Change the status
- [ ] Leave "Status Update Date & Time" empty
- [ ] Submit the form
- [ ] Check tracking page - verify current date/time is displayed

### Test 5: Timeline Order
- [ ] Create multiple status updates with different custom dates
- [ ] Verify timeline displays in correct chronological order
- [ ] Most recent update should be at the top

### Test 6: Database Verification
- [ ] Check `shipment_history` table in database
- [ ] Verify `custom_date` column contains correct values
- [ ] Verify NULL values for entries without custom dates

## Troubleshooting

### Issue: SQL Error when creating/updating tracking
**Solution:** Make sure you've run the database migration to add the `custom_date` column.

### Issue: Custom date not displaying
**Solution:** 
1. Check if the `custom_date` column exists in the database
2. Verify the value was saved in the database
3. Clear browser cache and reload the tracking page

### Issue: Timeline showing wrong order
**Solution:** The query orders by `COALESCE(custom_date, created_at)`, which should handle both custom and automatic dates. Check database values.

### Issue: Datetime field not showing in browser
**Solution:** The `datetime-local` input type requires modern browsers. Ensure you're using Chrome, Firefox, Edge, or Safari (recent versions).

## Technical Details

### Database Schema
```sql
CREATE TABLE `shipment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `custom_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tracking_number` (`tracking_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Key Functions
- **Add Tracking:** Uses `$_POST['initial_datetime']` or `date('Y-m-d H:i:s')`
- **Edit Tracking:** Uses `$_POST['update_datetime']` or `date('Y-m-d H:i:s')`
- **Display:** Uses `COALESCE(custom_date, created_at)` for ordering and display

## Browser Compatibility
- Chrome 20+
- Firefox 57+
- Safari 14.1+
- Edge 79+
- Opera 15+

**Note:** Older browsers may show a text input instead of a date/time picker. Users can still enter dates in the format: `YYYY-MM-DDTHH:MM` (e.g., `2026-10-21T17:30`)

## Security Notes
- All inputs are sanitized using `text_input()` function
- SQL injection protection via `mysqli_real_escape_string()` (implicit in text_input)
- HTML special characters are escaped for display

## Future Enhancements
- Add timezone selection
- Bulk update dates for multiple tracking entries
- Date validation to prevent future dates (if needed)
- Admin audit log for date/time changes
