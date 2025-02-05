<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['btn-send'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        header("Location: admin_contact.php?error=emptyfields");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: admin_contact.php?error=invalidemail");
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'hmkitcheninfo@gmail.com'; 
        $mail->Password = 'wlyajxkzxocmgvmo'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; 

        // Recipients
        $mail->setFrom($email, $name); // Use your Gmail as sender
        $mail->addAddress('hmkitcheninfo@gmail.com'); // Receiving email
        $mail->addReplyTo($email, $name); // User's email as Reply-To

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: " . $subject;
        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        header("Location: contact.php?success=1");
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        header("Location: admin_contact.php?error=sendfail");
    }
} else {
    header("Location: contact.php");
    exit();
}
