<?php

use App\Events\OrderPusherEvent;
use App\Models\Order;

function sendNewSMS($mobilenumbers, $message)
{
    $user = 'oneindia';
    $password = '0a9bc4a70aXX';
    $senderid = 'DELIND';

    $url = 'http://t.instaclicksms.in/sendsms.jsp';
    $message = urlencode($message);

    $m = '91' . $mobilenumbers;
    $mobileno = $m;

    $ch = curl_init($url . "?user=$user&password=$password&mobiles=$m&sms=" . $message . "&senderid=DELIND");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $ch = curl_exec($ch);

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
function testPusher()
{
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
function sendMobilePushNotification(String $message = null, String $title = null, array $tokens = [], $data = [], $notification_code = 100, $for_service_provider = false, array $buttons = [])
{

    /*
     * 100 = Default Code
     * 102=confirm code

     */
    $app_id = env("ONE_SIGNAL_APP_ID", '');
    $app_key =env("ONE_SIGNAL_PI_KEY", '');
    $content = [
        "en" => $message,
    ];
    if (!$tokens) {
        $tokens = [
            "69a1fc40-3dfa-4a15-9a2b-fb6e378f2269",
            // "76ece62b-bcfe-468c-8a78-839aeaa8c5fa",
            // "8e0f21fa-9a5a-4ae7-a9a6-ca1f24294b86"
        ];
    }
    if (gettype($data) == "object") {

        $data->notification_code = $notification_code;
    } elseif (gettype($data) == "array") {
        $data["notification_code"] = $notification_code;
    }

    $fields = [
        'app_id' => $app_id,
        'include_player_ids' => $tokens,
        'data' => $data,
        'notification_code'=>$notification_code,
        'contents' => $content,
        'headings' => [
            "en" => $title,
        ],
/*         "buttons" => [
["id" => "accept", "text" => "Accept", "icon" => "ic_menu_share" ],
["id" => "reject", "text" => "Reject", "icon" => "ic_menu_send" ]
], */
        "android_accent_color" => "FF00A896",
        "android_led_color" => "FF00A896",
        // "android_background_layout" => [
        //     "headings_color"    => "FF00A896",
        //     "image "            => "R.drawable.allbazi_logo_white",
        // ],
        //"small_icon" => "allbazi_logo_white",
        // "large_icon"    => "https://fakeimg.pl/512x256/?text=Hello+World&font=lobster"
    ];
    if (sizeof($buttons)) {
        $fields["buttons"] = $buttons;
    }
    $fields = json_encode($fields);
    \Log::debug('PUSH Notification to Devices');
    \Log::debug($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $app_key,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// type must be Day, Month, Year
function dateDiff($from_date, $to_date, $type)
{
    if (trim($from_date) == "") {
        $from_date = "2019-01-01";
    }
    $from_date = new \DateTime($from_date);
    $to_date = new \DateTime($to_date);
    $diff = $from_date->diff($to_date);
    if ($type == "Month") {
        return (($diff->format('%y') * 12) + $diff->format('%m'));
    } elseif ($type == "Day") {
        return $diff->format('%r%a');
    }
    return 0;
}
