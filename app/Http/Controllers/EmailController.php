<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mailjet\Resources;

class EmailController extends Controller
{
    //
    //$send retour 1 si l'envoi reussi;
    public function sendEmail($receiver,$name, $message){
        $mj = new \Mailjet\Client('abe478071648e207d70a849ce2d3b95b', '8d7ce36c402d9585b3c9e2f3d9817064', true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "teneyemdesto@gmail.com",
                        'Name' => "Desto"
                    ],
                    'To' => [
                        [
                            'Email' => $receiver,
                            'Name' => $name
                        ]
                    ],
                    'Subject' => "Validation de compte",
                    'TextPart' => "Veillez cliquer sur le bouton en dessous pour valider votre compte. ",
                    'HTMLPart' => $message,
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
//         && var_dump($response->getData());
        return $response->success();

    }
}
