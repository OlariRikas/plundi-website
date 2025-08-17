<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$website = isset($_POST['website']) ? trim($_POST['website']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Basic validation
if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// Generate ticket ID
$ticketId = 'CONTACT-' . strtoupper(substr(md5(uniqid()), 0, 8));

// Prepare email content
$to = 'info@plundi.com';
$subject = "New Contact Form: $name - $ticketId";

$emailBody = "New contact form submission:\n\n";
$emailBody .= "Ticket ID: $ticketId\n";
$emailBody .= "Name: $name\n";
$emailBody .= "Email: $email\n";
$emailBody .= "Phone: " . ($phone ?: 'Not provided') . "\n";
$emailBody .= "Website: " . ($website ?: 'Not provided') . "\n";
$emailBody .= "Message:\n$message\n\n";
$emailBody .= "Submitted: " . date('Y-m-d H:i:s') . "\n";
$emailBody .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";

// Email headers
$headers = [
    'From: noreply@plundi.com',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8'
];

// Send email
$emailSent = mail($to, $subject, $emailBody, implode("\r\n", $headers));

if ($emailSent) {
    // Log the submission (optional)
    $logEntry = date('Y-m-d H:i:s') . " - Contact form submitted by $name ($email) - Ticket: $ticketId\n";
    file_put_contents('contact_log.txt', $logEntry, FILE_APPEND | LOCK_EX);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Thank you for your message! We will get back to you within 24 hours.',
        'ticketId' => $ticketId
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Sorry, there was an error sending your message. Please try again or email us directly at info@plundi.com.'
    ]);
}
?>
