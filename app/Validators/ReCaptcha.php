<?php
namespace App\Validators;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator){
        $client = new Client();
        try {
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                ['form_params' =>
                    [
                        'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
                        'response' => $value
                    ]
                ]
            );
        } catch (GuzzleException $e) {
        }
        $body = json_decode((string)$response->getBody());
        return $body->success;
    }
}
