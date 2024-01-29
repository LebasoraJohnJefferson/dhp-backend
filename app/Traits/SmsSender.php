<?php


namespace App\Traits;
use Twilio\Rest\Client;

trait SmsSender{
    protected function sendSms($msg,$phone_number){
        $sid = env("TWOLIO_SID");
        $token = env("TWOLIO_TOKEN");
        $phone = env("TWOLIO_PHONE");
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
        ->create($phone_number, // to
        [
            "body" => $msg,
            "from" => $phone
        ]);
    }
}