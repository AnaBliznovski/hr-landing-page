<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Semos Education | Job Application Form Resume Upload">
    <meta name="author" content="semosedu">
    <title>Semos Education | Job Application Form</title>

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="../css/custom.css" rel="stylesheet">

    <script type="text/javascript">
        function delayedRedirect() {
            window.location = "../index.html"
        }
    </script>

</head>

<body style="background-color:#fff;" onLoad="setTimeout('delayedRedirect()', 5000)">
    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';

    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    try {

        $mail->CharSet = 'UTF-8';                     // Set characters to utf-8  

        $mail->isSMTP();                        // Send using SMTP

        $mail->Host = 'ms.semos.com.mk'; // Set the SMTP server to send through
        $mail->Port = 26;                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->SMTPSecure = 'STARTTLS';          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        // $mail->SMTPAuth = false;                          // Enable SMTP authentication
        // $mail->SMTPSecure = 'tls';
        // $mail->Username   = '';                              // SMTP username
        // $mail->Password   = '';                              // SMTP password


        //Recipients - main edits
        $mail->setFrom('no-reply@semosedu.com', 'Message from SEMOS EDUCATION');                    // Email Address and Name FROM
        $mail->addAddress('vladimir.jakimovski@semos.com.mk', 'Vladimir Jakimovski');  // Email Address and Name TO - Name is optional
        $mail->addAddress('ance.jovanoska@semos.com.mk', 'Ance Jovanoska');
        $mail->addAddress('ivana.ciplakovska@semos.com.mk', 'Ivana Ciplakovska');
        $mail->addAddress('zoran.kimov@semos.com.mk', 'Zoran Kimov');  // Email Address and Name TO - Name is optional
        $mail->addReplyTo('no-reply@semosedu.com', 'Message from SEMOS EDUCATION');              // Email Address and Name NOREPLY
        $mail->isHTML(true);
        $mail->Subject = 'Message from SEMOS EDUCATION Attachment';                            // Email Subject


        //The email body message
        $message  = "<strong>Job Application from:</strong><br />";
        $message .= "<br/>First Name: " . $_POST['firstname'];
        $message .= "<br/>Last Name: " . $_POST['lastname'];

        $message .= "<br />Email: " . $_POST['email'];
        $message .= "<br />Telephone: " . $_POST['phone'];
        $message .= "<br />Country: " . $_POST['country'];
        $message .= "<br />Position: " . $_POST['position'];

        /* FILE UPLOAD */
        if (isset($_FILES['fileupload'])) {
            $errors = array();
            $file_name = $_FILES['fileupload']['name'];
            $file_size = $_FILES['fileupload']['size'];
            $file_type = $_FILES['fileupload']['type'];
            $file_ext = strtolower(end(explode('.', $_FILES['fileupload']['name'])));
            $expensions = array("pdf", "doc", "docx"); // Define with files are accepted
            $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['fileupload']['tmp_name']));

            if (in_array($file_ext, $expensions) === false) {
                $errors[] = "Extension not allowed, please choose a .pdf, .doc, .docx file.";
            }
            // Set the files size limit. Use this tool to convert the file size param https://www.thecalculator.co/others/File-Size-Converter-69.html
            if ($file_size > 2097152) {
                $errors[] = 'File size must be max 2MB';
            }
            if (empty($errors) == true) {
                move_uploaded_file($_FILES['fileupload']['name'], $uploadfile);
                $mail->AddAttachment($_FILES['fileupload']['tmp_name'], $_FILES['fileupload']['name']);
            } else {
                $message .= "<br />File name: no files uploaded";
            }
        };
        /* end FILE UPLOAD */


        $message .= "<br /><br />Message: " . $_POST['message'];
        $message .= "<br /><br />Terms and conditions accepted: " . $_POST['terms'];


        $mail->Body = "" . $message . "";

        $mail->send();

        // Confirmation/autoreplay email send to who fill the form/ without template

        // $mail->ClearAddresses();
        // $mail->isSMTP();
        // $mail->addAddress($_POST['email']); // Email address entered on form
        // $mail->isHTML(true);
        // $mail->Subject    = 'Confirmation'; // Custom subject
        // $mail->Body = "" . $message . "";

        // $mail->Send();

        // Confirmation end without template

        // confirmation start with template

        $mail->ClearAddresses();
        $mail->addAddress($_POST['email']); // Email address entered on form
        $mail->isHTML(true);
        $mail->Subject    = 'Confirmation'; // Custom subject

        // Get the email's html content
        $email_html_confirm = file_get_contents('confirmation.html');

        // Setup html content
        $body = str_replace(array('message'), array($message), $email_html_confirm);
        $mail->MsgHTML($body);

        $mail->Send();

        // confirmation end with template

        echo '<div id="success">
            <div class="icon icon--order-success svg">
                 <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                  <g fill="none" stroke="#8EC343" stroke-width="2">
                     <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                     <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                  </g>
                 </svg>
             </div>
            <h4><span>Job application successfully sent!</span>Thank you for your time</h4>
            <small>You will be redirected back in 5 seconds.</small>
        </div>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    ?>
    <!-- END SEND MAIL SCRIPT -->

</body>

</html>