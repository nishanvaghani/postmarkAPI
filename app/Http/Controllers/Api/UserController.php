<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserLoginMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;

class UserController extends Controller
{
    // Send email
    public function sendMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_token' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors()->first(), Response::HTTP_BAD_REQUEST);
        }

        $link = \Linkeys\UrlSigner\Facade\UrlSigner::generate(route('login'), ['data' => ''], '+30 seconds');

        $user = new User;
        $user->email = $request->email;
        $user->uuid = $link->uuid;
        $user->save();
        // Mail::to($request->email)->send(new UserLoginMail($link, $link->uuid));

        // Send Link by Postmart API.
        $curl = curl_init();
        curl_setopt_array($curl, 
        array(
            CURLOPT_URL => 'https://api.postmarkapp.com/email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array(
                "From"=> env('POSTMARK_EMAIL'),
                "To"=> $request->email,
                "Subject"=> "Postmark Demo Code",
                "TextBody"=> "Hello dear Postmark user.",
                "HtmlBody"=> emailHtml($link, $link->uuid),
                "MessageStream"=> "outbound"
            )),
            CURLOPT_HTTPHEADER => array(
                'X-Postmark-Server-Token: 7f46be21-efd8-413e-b6fa-02f2592de55f',
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return sendSuccess('Email Sent. Please check your inbox.');
    }

    public function changeUserEmail(Request $request)
    {
        $user = User::find($request->user_id);
        $validator = Validator::make($request->all(), [
            'old_email' => 'required|email',
            'new_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors()->first(), Response::HTTP_BAD_REQUEST);
        }

        // Check Email with exhisting Email
        if ($user->email != $request->old_email) {
            return sendError("Your Email is not registered.", Response::HTTP_BAD_REQUEST);
        }
        $user->email = $request->new_email;
        $user->save();
        return sendSuccess('Your Email is changed.');
    }
}
