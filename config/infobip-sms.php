<?php

/**
 * This is config for Infobip SMS.
 *
 * @see https://dev.infobip.com/send-sms/single-sms-message
 */
return [
    'from'     => env('RHU', 'Barugo, Leyte'),
    'username' => env('INFOBIP_USERNAME', 'InfobipLebs'),
    'password' => env('INFOBIP_PASSWORD', '#Fabon1437'),
];
