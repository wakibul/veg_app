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
function dateFormat($dateTime, $format = "d-m-Y")
{
    if ($dateTime == "0000-00-00" || $dateTime == "0000-00-00 00:00:00") {
        return " ";
    }
    $date = strtotime($dateTime);
    if (date('d-m-Y', $date) != '01-01-1970') {
        return date($format, $date);
    } else {
        return " ";
    }
}

// type must be Day, Month, Year
function dateDiff($from_date, $to_date, $type)
{
    if (trim($from_date) == "") {
        $from_date = "2019-01-01";
    }
    $from_date = new \DateTime($from_date);
    $to_date   = new \DateTime($to_date);
    $diff      = $from_date->diff($to_date);
    if ($type == "Month") {
        return (($diff->format('%y') * 12) + $diff->format('%m'));
    } elseif ($type == "Day") {
        return $diff->format('%r%a');
    }
    return 0;
}
