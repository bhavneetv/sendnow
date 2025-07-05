<?php

// $conn = new mysqli("localhost", "root", "", "self_notes");
require("../include/config.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendMail($email, $link, $msg)
{
    require('PHPMailer.php');
    require('Exception.php');
    require('SMTP.php');

    // if($_COOKIE["forgot_"])

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'sendnowofficials@gmail.com';                     //SMTP username
        $mail->Password   = 'YOUR PASSWORD';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('sendnowofficials@gmail.com', "SendNow");
        $mail->addAddress($email);     //Add a recipient




        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "SendNow";
        $mail->Body    = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Link is Here</title>
        <style>
            /* Email client compatibility styles */
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
            }
            
            table {
                border-collapse: collapse;
                width: 100%;
            }
            
            .email-container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
            }
            
            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 40px 30px;
                text-align: center;
            }
            
            .header h1 {
                color: #ffffff;
                margin: 0;
                font-size: 28px;
                font-weight: bold;
            }
            
            .content {
                padding: 40px 30px;
                text-align: center;
            }
            
            .content h2 {
                color: #333333;
                margin: 0 0 20px 0;
                font-size: 24px;
            }
            
            .content p {
                color: #666666;
                line-height: 1.6;
                margin: 0 0 25px 0;
                font-size: 16px;
            }
            
            .link-button {
                display: inline-block;
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: #ffffff;
                text-decoration: none;
                padding: 15px 30px;
                border-radius: 8px;
                font-weight: bold;
                font-size: 16px;
                margin: 20px 0;
                text-transform: uppercase;
                letter-spacing: 1px;
            }
            
            .link-button:hover {
                background: linear-gradient(135deg, #5a6fd8, #6a42a0);
            }
            
            .alternative-link {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 8px;
                padding: 20px;
                margin: 30px 0;
            }
            
            .alternative-link p {
                margin: 0 0 10px 0;
                font-size: 14px;
                color: #666666;
            }
            
            .alternative-link a {
                color: #667eea;
                word-break: break-all;
                text-decoration: none;
            }
            
            .footer {
                background-color: #f8f9fa;
                padding: 30px;
                text-align: center;
                border-top: 1px solid #dee2e6;
            }
            
            .footer p {
                color: #999999;
                font-size: 14px;
                margin: 0 0 10px 0;
            }
            
            .footer a {
                color: #667eea;
                text-decoration: none;
            }
            
            .icon {
                font-size: 48px;
                margin-bottom: 20px;
            }
            
            /* Mobile responsive */
            @media only screen and (max-width: 600px) {
                .email-container {
                    width: 100% !important;
                }
                
                .header, .content, .footer {
                    padding: 20px !important;
                }
                
                .header h1 {
                    font-size: 24px !important;
                }
                
                .content h2 {
                    font-size: 20px !important;
                }
                
                .link-button {
                    padding: 12px 25px !important;
                    font-size: 14px !important;
                }
            }
        </style>
    </head>
    <body>
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td>
                    <div class="email-container">
                        <!-- Header -->
                        <div class="header">
                            <div class="icon">🔗</div>
                            <h1>Your Link is Ready!</h1>
                        </div>
                        
                        <!-- Main Content -->
                        <div class="content">
                            <h2>Hello there!</h2>
                            <p>' . $msg . '</p>                            
                            <!-- Main Call-to-Action Button -->
                            <a href="' . $link . '" class="link-button">Access Your Link</a>
                            
                            <p>This link will take you to the content youre looking for. If you have any questions or need assistance, dont hesitate to reach out to us.</p>
                            
                            <!-- Alternative Link Section -->
                            <div class="alternative-link">
                                <p><strong>Cant click the button above?</strong></p>
                                <p>Copy and paste this link into your browser:</p>
                                <a href="' . $link . '">' . $link . '</a>
                            </div>
                            
                            <p>Thank you for your interest, and we hope you find what youre looking for!</p>
                            <p><strong>Best regards,</strong><br>The Team</p>
                        </div>
                        
                        <!-- Footer -->
                        <div class="footer">
                            <p>You received this email because you requested a link from us.</p>
                           
                            <p>&copy; 2025 SendNow. All rights reserved.</p>
                            <p>Ambala, Haryana, India</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
    </html>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
if ($db->connect_error) {


    echo "Connection Lost";
} else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = $_POST['email'];
        $link = $_POST['link'];
        if ($_POST['msg'] == "") {
            $msg = "We will prepared the link you requested. Click the button below to access it immediately.";
        } else {
            $msg = $_POST['msg'];
        }
       // echo $msg;

        if (sendMail($email, $link, $msg)) {
            echo "yes";
        } else {
            echo "no";
        }
    } else {
        echo 'User not found';
    }
}
