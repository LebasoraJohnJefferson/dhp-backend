<?php

namespace App\Traits;
use Pnlinh\InfobipSms\Facades\InfobipSms;


trait SmsSender{
    protected function sendSms($msg, $phone_number){

        // $basic  = new \Vonage\Client\Credentials\Basic(env("VONAGE_API_KEY"), env("VONAGE_API_SECRET"));
        // $client = new \Vonage\Client($basic);

        // $response = $client->sms()->send(
        //     new \Vonage\SMS\Message\SMS($phone_number, 'RHU BARUGO', $msg)
        // );

        // $message = $response->current();

        // if ($message->getStatus() == 0) {
        //     error_log("The message was sent successfully\n");
        // } else {
        //     error_log("The message failed with status: " . $message->getStatus() . "\n");
        // }
        error_log('hi');

        if (substr($phone_number, 0, 2) === '09') {
            // If yes, replace '09' with '+639'
            $phone_number = '+639' . substr($phone_number, 2);
        } elseif (substr($phone_number, 0, 4) !== '+639') {
            // If it doesn't start with '+639', prepend it
            $phone_number = '+639' . $phone_number;
        }
        $response = InfobipSms::send($phone_number,$msg);
        error_log(json_encode($response));
    }
}
