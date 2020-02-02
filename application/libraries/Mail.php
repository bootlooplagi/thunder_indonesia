<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */


class Mail{
    function register($to=null,$toTitle=null,$subject=null,$html=null,$txtBody=null){
        date_default_timezone_set('Etc/UTC');

        require 'mail/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;
        $mail->Username = "pt.tugupratamaindonesia@gmail.com";
        $mail->Password = "ykdigital";
        $mail->setFrom('pt.tugupratamaindonesia@gmail.com', 'PT. TUGU PRATAMA INDONESIA');
        $mail->addAddress($to, $toTitle);
        $mail->Subject = $subject;

        
            $mail->msgHTML($html);//file_get_contents('contents.html'), dirname(__FILE__));
        $mail->AltBody = $txtBody;
        //$mail->addAttachment('images/phpmailer_mini.png');

        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return '1';
        }
    }

    function forgotPassword($to=null,$toTitle=null,$subject=null,$html=null,$txtBody=null){
        date_default_timezone_set('Etc/UTC');

        require 'mail/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;
        $mail->Username = "pt.tugupratamaindonesia@gmail.com";
        $mail->Password = "ykdigital";
        $mail->setFrom('pt.tugupratamaindonesia@gmail.com', 'PT. TUGU PRATAMA INDONESIA');
        $mail->addAddress($to, $toTitle);
        $mail->Subject = $subject;

        
            $mail->msgHTML($html);//file_get_contents('contents.html'), dirname(__FILE__));
        $mail->AltBody = $txtBody;
        //$mail->addAttachment('images/phpmailer_mini.png');

        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return '1';
        }
    }

    function sendNego($to=null,$toTitle=null,$subject=null,$html=null,$txtBody=null,$attach=null,$attach2=null,$attach3=null){
        date_default_timezone_set('Etc/UTC');

        require 'mail/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';

        $mail->SMTPAuth = true;
        $mail->Username = "demo.thunder.indonesia@gmail.com";
        $mail->Password = "ykdigital12345";
        $mail->setFrom('demo.thunder.indonesia@gmail.com', 'THUNDER INDONESIA');
        $mail->addAddress($to, $toTitle);
        $mail->Subject = $subject;

        
            $mail->msgHTML($html);//file_get_contents('contents.html'), dirname(__FILE__));
        $mail->AltBody = $txtBody;
        $mail->addAttachment($attach);
        $mail->addAttachment($attach2);
        $mail->addAttachment($attach3);



        if (!$mail->send()) {
            return "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return '1';
        }
    }
}

