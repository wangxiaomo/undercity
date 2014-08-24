<?php

function send_mail($to, $title, $content, $cc=NULL){
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.163.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'yueqingwang_robot';
    $mail->Password = 'Yqkzcs123654';
    $mail->SMTPSecure = 'tls';
    $mail->CharSet = 'utf8';

    $mail->From = 'yueqingwang_robot@163.com';
    $mail->FromName = 'yueqingwang_robot';
    $mail->addAddress($to);

    if($cc){
        if(is_string($cc)) $cc = (array)$cc;
        foreach($cc as $c){
            $mail->addCC($c);
        }
    }

    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $content;
    if(!$mail->send()){
        throw new Exception($mail->ErrorInfo);
    }
}
