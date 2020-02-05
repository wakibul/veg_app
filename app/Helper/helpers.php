<?php
function sendNewSMS($mobilenumbers, $message) {
    $user 		= 'oneindia';
    $password	= '0a9bc4a70aXX';
    $senderid	= 'DELIND';

    $url 		= 'http://t.instaclicksms.in/sendsms.jsp';
    $message 	= urlencode($message);


    $m 			= '91' . $mobilenumbers;
    $mobileno 	= $m;

    $ch 		= curl_init($url."?user=$user&password=$password&mobiles=$m&sms=".$message."&senderid=DELIND");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $ch     	= curl_exec($ch);

}

