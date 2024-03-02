<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class NotificationController extends Controller
{
    public function sendSmsNotificaition()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("6825edb0", "XrG7rbedwmKRbCDu");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("639853316238", 'Christian Paranas', 'I love you jil')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            dd("The message was sent successfully\n");
        } else {
           dd("The message failed with status: " . $message->getStatus() . "\n");
        }
    }
}
