-- Migration to add custom_date column to shipment_history table
-- Run this SQL in your database to add the custom date/time feature

ALTER TABLE `shipment_history` 
ADD COLUMN `custom_date` DATETIME NULL AFTER `remarks`;

-- Update existing records to use created_at as custom_date
UPDATE `shipment_history` 
SET `custom_date` = `created_at` 
WHERE `custom_date` IS NULL;
