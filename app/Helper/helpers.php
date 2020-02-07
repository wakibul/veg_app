<?php

use App\Events\OrderPusherEvent;
use App\Models\Order;

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

function getCurrentDate($format = "Y-m-d H:i:s")
{
    return date($format);
}
function getOrderConfirmId()
{
    $order_count = Order::count() + 1;
    $order_no = 'SOR/ORD/' . $order_count;
    return $order_no;

}
function testPusher(){
    $order = Order::first();
    return event(new OrderPusherEvent($order));
}

