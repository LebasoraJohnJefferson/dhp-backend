<?php

namespace App\Traits;
use Illuminate\Support\Facades\Log;

trait SmsSender{
    protected function sendSms($msg, $phone_number){

        $basic  = new \Vonage\Client\Credentials\Basic(env("VONAGE_API_KEY"), env("VONAGE_API_SECRET"));
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($phone_number, 'RHU BARUGO', $msg)
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            error_log("The message was sent successfully\n");
        } else {
            error_log("The message failed with status: " . $message->getStatus() . "\n");
        }
    }
}
