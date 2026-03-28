<?php
// Email Configuration Hybreed Webworx #IAmHybreed237 
// You can use PHPMailer or native PHP mail() function
// For production, configure SMTP settings below

define('MAIL_FROM', 'track@yourdomainname.com');
define('MAIL_FROM_NAME', 'Hybreed Courier Trackr');
define('MAIL_REPLY_TO', 'track@yourdomainname.com');

// SMTP Configuration (Optional - for better deliverability)
// Uncomment and configure these if you want to use SMTP

define('SMTP_HOST', 'mail.yourdomainname.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'track@yourdomainname.com');
define('SMTP_PASSWORD', '#1234567890');
define('SMTP_SECURE', 'ssl'); // 'tls' or 'ssl'


/**
 * Send email notification
 * @param string $to Recipient email
 * @param string $subject Email subject
 * @param string $message Email body (HTML)
 * @return bool Success status
 */
function sendEmail($to, $subject, $message) {
    // Set headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . MAIL_FROM_NAME . " <" . MAIL_FROM . ">" . "\r\n";
    $headers .= "Reply-To: " . MAIL_REPLY_TO . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email using PHP mail() function
    return mail($to, $subject, $message, $headers);
}

/**
 * Send shipment creation notification
 */
function sendShipmentCreatedEmail($tracking_number, $receiver_email, $receiver_name, $sender_name, $dispatch_date, $delivery_date) {
    $subject = "New Shipment Created - Tracking #" . $tracking_number;
    
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #FFCC00; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; }
            .tracking-number { font-size: 24px; font-weight: bold; color: #333; margin: 20px 0; }
            .info-table { width: 100%; margin: 20px 0; }
            .info-table td { padding: 10px; border-bottom: 1px solid #ddd; }
            .info-table td:first-child { font-weight: bold; width: 40%; }
            .button { display: inline-block; padding: 12px 30px; background-color: #FFCC00; color: #000; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 style="margin: 0; color: #000;">Hybreed Courier Trackr</h1>
            </div>
            <div class="content">
                <h2>Shipment Created Successfully</h2>
                <p>Dear ' . htmlspecialchars($receiver_name) . ',</p>
                <p>Your shipment has been created and is being processed. Here are the details:</p>
                
                <div class="tracking-number">
                    Tracking Number: ' . htmlspecialchars($tracking_number) . '
                </div>
                
                <table class="info-table">
                    <tr>
                        <td>Sender:</td>
                        <td>' . htmlspecialchars($sender_name) . '</td>
                    </tr>
                    <tr>
                        <td>Receiver:</td>
                        <td>' . htmlspecialchars($receiver_name) . '</td>
                    </tr>
                    <tr>
                        <td>Dispatch Date:</td>
                        <td>' . htmlspecialchars($dispatch_date) . '</td>
                    </tr>
                    <tr>
                        <td>Estimated Delivery:</td>
                        <td>' . htmlspecialchars($delivery_date) . '</td>
                    </tr>
                </table>
                
                <p>You can track your shipment anytime using the tracking number above.</p>
                
                <a href="https://royaldeliveryinc.online/track-your-shipment.html" class="button">Track Your Shipment</a>
                
                <p>If you have any questions, please don\'t hesitate to contact us.</p>
            </div>
            <div class="footer">
                <p>Hybreed Courier Trackr<br>
                9747 Biederman Way Escalon California 95320, USA<br>
                Phone: + (Phone Number) | Email: track@HybreedCourierTrackr.come</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    return sendEmail($receiver_email, $subject, $message);
}

/**
 * Send status update notification
 */
function sendStatusUpdateEmail($tracking_number, $receiver_email, $receiver_name, $old_status, $new_status, $current_location) {
    $subject = "Shipment Status Update - Tracking #" . $tracking_number;
    
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #FFCC00; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; margin-top: 20px; }
            .tracking-number { font-size: 24px; font-weight: bold; color: #333; margin: 20px 0; }
            .status-box { background-color: #fff; border-left: 4px solid #FFCC00; padding: 15px; margin: 20px 0; }
            .status-label { font-size: 18px; font-weight: bold; color: #28a745; }
            .info-table { width: 100%; margin: 20px 0; }
            .info-table td { padding: 10px; border-bottom: 1px solid #ddd; }
            .info-table td:first-child { font-weight: bold; width: 40%; }
            .button { display: inline-block; padding: 12px 30px; background-color: #FFCC00; color: #000; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 style="margin: 0; color: #000;">Hybreed Courier Trackr</h1>
            </div>
            <div class="content">
                <h2>Shipment Status Updated</h2>
                <p>Dear ' . htmlspecialchars($receiver_name) . ',</p>
                <p>Your shipment status has been updated.</p>
                
                <div class="tracking-number">
                    Tracking Number: ' . htmlspecialchars($tracking_number) . '
                </div>
                
                <div class="status-box">
                    <div class="status-label">New Status: ' . htmlspecialchars($new_status) . '</div>
                </div>
                
                <table class="info-table">
                    <tr>
                        <td>Previous Status:</td>
                        <td>' . htmlspecialchars($old_status) . '</td>
                    </tr>
                    <tr>
                        <td>Current Status:</td>
                        <td><strong>' . htmlspecialchars($new_status) . '</strong></td>
                    </tr>
                    ' . ($current_location ? '<tr><td>Current Location:</td><td>' . htmlspecialchars($current_location) . '</td></tr>' : '') . '
                    <tr>
                        <td>Updated:</td>
                        <td>' . date('F d, Y h:i A') . '</td>
                    </tr>
                </table>
                
                <p>You can view the complete shipment journey and details by tracking your shipment.</p>
                
                <a href="https://Hybreed Courier Trackrexpresscargo.com/track-your-shipment.html" class="button">Track Your Shipment</a>
                
                <p>Thank you for choosing Hybreed Courier Trackr!</p>
            </div>
            <div class="footer">
                <p>Hybreed Courier Trackr<br>
                9747 Biederman Way Escalon California 95320, USA<br>
                Phone: + (Phone Number) | Email: track@HybreedCourierTrackr.come</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    return sendEmail($receiver_email, $subject, $message);
}
?>
