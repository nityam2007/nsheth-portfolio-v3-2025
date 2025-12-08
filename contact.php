<?php
/**
 * NSheth Portfolio - Contact Form Handler
 * ========================================
 * Processes contact form submissions and sends emails
 */

// Configuration
$config = [
    'recipient_email' => 'hello@nsheth.in',
    'recipient_name' => 'Nityam Sheth',
    'site_name' => 'NSheth Portfolio',
    'success_redirect' => 'index.php?status=success#contact',
    'error_redirect' => 'index.php?status=error#contact'
];

// Security headers
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Rate limiting (simple implementation using sessions)
session_start();
$rate_limit_key = 'contact_form_submissions';
$rate_limit_max = 5; // Max 5 submissions per hour
$rate_limit_window = 3600; // 1 hour in seconds

if (!isset($_SESSION[$rate_limit_key])) {
    $_SESSION[$rate_limit_key] = [];
}

// Clean old entries
$_SESSION[$rate_limit_key] = array_filter($_SESSION[$rate_limit_key], function($timestamp) use ($rate_limit_window) {
    return $timestamp > (time() - $rate_limit_window);
});

if (count($_SESSION[$rate_limit_key]) >= $rate_limit_max) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please try again later.']);
    exit;
}

// Validate and sanitize input
$name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8')) : '';
$email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
$subject = isset($_POST['subject']) ? trim(htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8')) : '';
$message = isset($_POST['message']) ? trim(htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8')) : '';
$honeypot = isset($_POST['website']) ? $_POST['website'] : ''; // Honeypot field

// Check for honeypot (spam protection)
if (!empty($honeypot)) {
    // Bot detected, silently fail
    echo json_encode(['success' => true, 'message' => 'Thank you for your message!']);
    exit;
}

// Validation
$errors = [];

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please enter your name (at least 2 characters)';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address';
}

if (empty($subject) || strlen($subject) < 3) {
    $errors[] = 'Please enter a subject (at least 3 characters)';
}

if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Please enter your message (at least 10 characters)';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode('. ', $errors), 'errors' => $errors]);
    exit;
}

// Prepare email
$to = $config['recipient_email'];
$email_subject = "[{$config['site_name']}] " . $subject;

$email_body = "You have received a new message from your portfolio contact form.\n\n";
$email_body .= "--------------------\n";
$email_body .= "Name: {$name}\n";
$email_body .= "Email: {$email}\n";
$email_body .= "Subject: {$subject}\n";
$email_body .= "--------------------\n\n";
$email_body .= "Message:\n{$message}\n\n";
$email_body .= "--------------------\n";
$email_body .= "Sent from: {$_SERVER['HTTP_HOST']}\n";
$email_body .= "IP Address: {$_SERVER['REMOTE_ADDR']}\n";
$email_body .= "Date/Time: " . date('Y-m-d H:i:s') . "\n";

$headers = [
    'From' => "{$name} <{$email}>",
    'Reply-To' => $email,
    'X-Mailer' => 'PHP/' . phpversion(),
    'Content-Type' => 'text/plain; charset=UTF-8'
];

$headers_string = '';
foreach ($headers as $key => $value) {
    $headers_string .= "{$key}: {$value}\r\n";
}

// Send email
$mail_sent = mail($to, $email_subject, $email_body, $headers_string);

if ($mail_sent) {
    // Record submission for rate limiting
    $_SESSION[$rate_limit_key][] = time();
    
    // Send auto-reply to sender (optional)
    $auto_reply_subject = "Thank you for contacting {$config['site_name']}!";
    $auto_reply_body = "Hi {$name},\n\n";
    $auto_reply_body .= "Thank you for reaching out! I've received your message and will get back to you as soon as possible.\n\n";
    $auto_reply_body .= "In the meantime, feel free to check out my work at https://nsheth.in\n\n";
    $auto_reply_body .= "Best regards,\n";
    $auto_reply_body .= $config['recipient_name'] . "\n";
    $auto_reply_body .= "https://nsheth.in";
    
    $auto_reply_headers = "From: {$config['recipient_name']} <{$config['recipient_email']}>\r\n";
    $auto_reply_headers .= "Reply-To: {$config['recipient_email']}\r\n";
    $auto_reply_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    @mail($email, $auto_reply_subject, $auto_reply_body, $auto_reply_headers);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Thank you for your message! I\'ll get back to you soon.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Sorry, there was a problem sending your message. Please try again or contact me directly at ' . $config['recipient_email']
    ]);
}
?>
