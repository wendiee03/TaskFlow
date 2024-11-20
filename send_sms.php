<?php
require 'vendor/autoload.php';

use Twilio\Rest\Client;

// Your Twilio account SID and auth token from the Twilio Console
$sid = 'ACe566ffdfcd7326c1bf2d36d3c97593d2';
$token = 'ac03c2223bf85cd07e199218a2199e90';
$twilio = new Client($sid, $token);

// Your Twilio phone number
$twilioPhoneNumber = '+17818082268';

// The recipient's phone number
$recipientPhoneNumber = '+254790418463';

// The SMS message
$messageBody = 'Hello, this is a test message from your PHP website!';

try {
    $message = $twilio->messages->create(
        $recipientPhoneNumber, // The recipient's phone number
        [
            'from' => $twilioPhoneNumber, // Your Twilio phone number
            'body' => $messageBody,
        ]
    );

    echo "Message sent successfully. Message SID: " . $message->sid;
} catch (Exception $e) {
    echo "Failed to send message: " . $e->getMessage();
}
?>