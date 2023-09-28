<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
    public function SendOtp(Request $request)
    {
        $otp = strval(rand(100000, 999999));

        try {
            $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
            $phoneNumber = $request->input('phone_number');

            $message = $client->messages->create(
                $phoneNumber,
                [
                    'from' => env('TWILIO_FROM'),
                    'body' => 'Your OTP is: ' . $otp,
                ]
            );

            return response()->json(['message' => 'OTP sent successfully']);
        } catch (\Exception $e) {
            Log::error('Error sending OTP: ' . $e);
            return response()->json(['error' => 'Failed to send OTP'], 400);
        }
    }
    public function otp()
    {
        return view('otp');
    }
}
