<?php
    require_once '../model/Verify.php';
    require '../core/PHPMailer/src/PHPMailer.php';
    require '../core/PHPMailer/src/Exception.php';
    require '../core/PHPMailer/src/SMTP.php';
    require '../core/VerifyEmail/verifyEmail.php';

class Verifyz extends Users {
    private $verifyModel;
    private $verifyEmail;
    private $verifyErr;

    public function __construct() {
        $this->verifyModel = new Verify;
        $this->verifyEmail = new VerifyEmail();
        $this->verifyErr = array();
    }

    public function generateLink() {
        return str_shuffle(substr(md5(time().mt_rand().time()),0,255));
    }

    // Send an verfication email => Gmail
    public function sendToMail($email,$message,$subject){
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;
        $mail->Host = M_HOST;
        $mail->Username = M_USERNAME;
        $mail->Password = M_PASSWORD;
        $mail->SMPTSecure = M_STMPSECURE;
        $mail->Port = M_PORT;

        if(!empty($email)){
            $mail->From = "Socail_ManzoorWayar@gmail.com";
            $mail->FromName = '['. SITENAME .']';
            $mail->addReplyTo("no-reply@gmail.com");
            $mail->addAddress($email);
            
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = $message;

            if(!$mail->send()){
                return false;
            }else{
                return true;
            }
        }
    }

    // Check is email is real
    public function isEmailReal($regEmail) {
        // Set the timeout value on stream
        $this->verifyEmail->setStreamTimeoutWait(20);

        // Set debug output mode
        $this->verifyEmail->Debug = FALSE; 
        $this->verifyEmail->Debugoutput = 'html'; 

        // Set email address for SMTP request
        $this->verifyEmail->setEmailFrom('softwareengineerwayar@gmail.com');

        // Email to check, $regEmail => is user registeration email
        $email = $regEmail; 

        // Check if email is valid and exist
        if($this->verifyEmail->check($email)){ 
           return true;
        } else { 
           return false;
        }
    }

    // Rest passwrd/Send msg to mobile
    public function sendSMS($senderID, $recipient_no, $message){
        // Request parameters array
        $requestParams = array(
            'user' => 'Social',
            'apiKey' => 'dssf645fddfgh565',
            'senderID' => $senderID,
            'recipient_no' => $recipient_no,
            'message' => $message
        );
        
        // Merge API url and parameters
        $apiUrl = "http://api.example.com/http/sendsms?";
        foreach($requestParams as $key => $val){
            $apiUrl .= $key.'='.urlencode($val).'&';
        }
        $apiUrl = rtrim($apiUrl, "&");
        
        // API call
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        // Return curl response
        return $response;
    }
}