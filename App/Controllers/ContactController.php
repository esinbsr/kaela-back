<?php

namespace Controllers;

use Models\ContactModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class ContactController
{
    protected $model;

    // Constructor to initialize the ContactModel
    public function __construct()
    {
        $this->model = new ContactModel();
    }

    public function sendEmail()
    {
        // Get the input data from the request body (JSON format)
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        // Retrieve and validate the email, object, and message from the request data
        $email = isset($data['email']) ? filter_var($data['email'], FILTER_VALIDATE_EMAIL) : null;
        $object = isset($data['object']) ? strip_tags($data['object']) : null;
        $message = isset($data['message']) ? strip_tags($data['message']) : null;
        $userId = isset($data['userId']) ? $data['userId'] : null;

        // Check if the object and message fields are not empty
        if (empty($object) || empty($message)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "Subject and message are required"];
        }

        // If the user is logged in, retrieve the user's email from the database using their userId
        if ($userId) {
            $userEmail = $this->model->getUserEmailById($userId);

            // If a user email is found, use it instead of the one provided in the request
            if ($userEmail) {
                $email = $userEmail;
            }
        }

        // If the email is still empty or invalid, return an error
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400); // Bad Request
            return ["success" => false, "message" => "A valid email is required"];
        }

        try {
            // Insert the contact message into the database
            $rowCount = $this->model->addContactMessage($email, $object, $message, $userId);

            // Check if the message was successfully inserted
            if ($rowCount > 0) {
                // Configure PHPMailer to send the email
                $mail = new PHPMailer(true);  // Create a new PHPMailer instance with exception handling enabled
                $mail->isSMTP();  // Use SMTP for email sending
                $mail->Host = 'smtp.gmail.com';  // Specify the SMTP server to use (Gmail's SMTP server in this case)
                $mail->SMTPAuth = true;  // Enable SMTP authentication
                $mail->Username = $_ENV['EMAIL'];  // Set the SMTP username, loaded from environment variables
                $mail->Password = $_ENV['PASSWORD'];  // Set the SMTP password, also loaded from environment variables
                $mail->SMTPSecure = 'tls';  // Set the encryption protocol to TLS
                $mail->Port = 587;  // Specify the SMTP port to use (587 for TLS)
                $mail->CharSet = 'UTF-8';  // Set the character encoding to UTF-8 for email content

                // Set up the email content
                $mail->setFrom($email);  // Set the "From" address to the sender's email
                $mail->addAddress($_ENV['EMAIL']);  // Add a recipient address (the email from environment variables)
                $mail->addReplyTo($email);  // Set the "Reply-To" address to the sender's email
                $mail->isHTML(true);  // Enable HTML format for the email body
                $mail->Subject = $object;  // Set the subject of the email
                $mail->Body = nl2br($message);  // Set the body content of the email, converting line breaks to <br> for HTML formatting

                // Attempt to send the email
                if ($mail->send()) {
                    http_response_code(200); // OK
                    return ["success" => true, "message" => "Email sent successfully"];
                } else {
                    throw new PHPMailerException($mail->ErrorInfo);
                }
            } else {
                http_response_code(500); // Internal Server Error
                return ["success" => false, "message" => "Error occurred while saving the message"];
            }
        } catch (\PDOException) {
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Database error"];
        } catch (PHPMailerException) {
            http_response_code(500); // Internal Server Error
            return ["success" => false, "message" => "Error sending email"];
        }
    }
}
