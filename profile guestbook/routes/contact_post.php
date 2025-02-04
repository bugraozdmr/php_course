<?php

// CSRF
if (!validateCsrfToken($_POST['csrf_token']))
{
    addFlashMessage('error', 'CSRF token validation failed');
    redirect('/contact');
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if (empty($name) || empty($email) || empty($message)) 
{
    badRequest('All fields are required');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
{
    badRequest('Invalid email');
}

$inserted = insertMessage(db_connect(), $name, $email, $message);

if ($inserted) 
{
    $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    addFlashMessage('success', "Message from $safeName saved!");
    redirect('/guestbook');
}

addFlashMessage('error', "Error saving message");

redirect('/guestbook');