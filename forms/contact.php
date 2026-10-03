<?php
declare(strict_types=1);

header('Content-Type: text/plain; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

function respond(int $status, string $message): void
{
  http_response_code($status);
  echo $message;
  exit;
}

function posted_value(string $key): string
{
  $value = $_POST[$key] ?? '';
  return is_string($value) ? trim($value) : '';
}

function text_length(string $value): int
{
  return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
  respond(405, 'Please submit the contact form.');
}

if (posted_value('website') !== '') {
  respond(200, 'OK');
}

$name = posted_value('name');
$email = posted_value('email');
$subject = posted_value('subject');
$message = posted_value('message');

if ($name === '' || text_length($name) > 120) {
  respond(400, 'Enter your name (up to 120 characters).');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || text_length($email) > 254) {
  respond(400, 'Enter a valid email address.');
}

if ($subject === '' || text_length($subject) > 200) {
  respond(400, 'Enter a subject (up to 200 characters).');
}

if ($message === '' || text_length($message) > 5000) {
  respond(400, 'Enter a message (up to 5000 characters).');
}

$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');

if ($dbHost === false || $dbName === false || $dbUser === false || $dbPassword === false) {
  error_log('Contact form database environment is not configured.');
  respond(503, 'The contact form is temporarily unavailable. Please email samikshachaskar9@gmail.com.');
}

try {
  $pdo = new PDO(
    "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
    $dbUser,
    $dbPassword,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );

  $statement = $pdo->prepare(
    'INSERT INTO contact_messages (name, email, subject, message)
     VALUES (:name, :email, :subject, :message)'
  );
  $statement->execute([
    ':name' => $name,
    ':email' => $email,
    ':subject' => $subject,
    ':message' => $message,
  ]);
} catch (PDOException $exception) {
  error_log('Contact form database error: ' . $exception->getMessage());
  respond(500, 'Your message could not be saved. Please email samikshachaskar9@gmail.com.');
}

respond(200, 'OK');
