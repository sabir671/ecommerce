<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    public function sendSMS(Request $request)
    {
        // Check if the form has been submitted
        if ($request->isMethod('post')) {
            try {
                // Retrieve Twilio credentials from .env file
                $account_sid = env('TWILIO_SID');
                $account_token = env('TWILIO_TOKEN');
                $number = env('TWILIO_FROM');

                // Initialize Twilio Client
                $client = new Client($account_sid, $account_token);

                // Compose and send the SMS
                $client->messages->create($number, [
                    "from" => "+17652744234",
                    'body' => $request->input('message') // Use the message from the form
                ]);

                // Redirect back to the sendsms.blade.php view after sending the SMS
                return view('sendsms');
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        // If the form has not been submitted (GET request), display the sendsms.blade.php view
        return view('sendsms');
    }

}
