<?php
    require '../libraries/PHPMailer/vendor/autoload.php';

    use PHPmailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;

// Function to send a verification email
    function sendVerificationEmail($EmailStr,$TokenStr) {
        // Initialize libraries
        $MailObj = new PHPMailer(true);

        try {
            // Server settings
            $MailObj->isSMTP();
            $MailObj->Host = 'smtp-mail.outlook.com';
            $MailObj->SMTPAuth = true;
            $MailObj->Username = 'Howzitsocial@outlook.com';
            $MailObj->Password = 'GHZ-pCzvAfNCC6z';
            $MailObj->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $MailObj->Port = 587;

            // Configure SMTP
            $MailObj->setFrom('Howzitsocial@outlook.com', 'Howzit Social');
            $MailObj->addAddress($EmailStr);

            // Content
            $MailObj->isHTML(true);
            $MailObj->Subject = 'Verify your email address';

            $HtmlTemplate = file_get_contents('../../frontend/assets/templates/verification_email_template.html');
            $HtmlTemplate = str_replace('{email}', $EmailStr, $HtmlTemplate);
            $HtmlTemplate = str_replace('{token}', $TokenStr, $HtmlTemplate);

            $MailObj->Body = $HtmlTemplate;

            // Send email
            $MailObj->send();
            die(json_encode(array("message" => "Verification email sent.")));
        } catch (Exception $e) {
            die(json_encode(array("error" => "Email could not be sent.")));
        }
    }
