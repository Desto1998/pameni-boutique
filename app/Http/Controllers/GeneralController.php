<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeneralController extends Controller
{
    //
    public function testAPI(Request $request){
            return Response()->json("Test success");
    }

    public function APIResult(Request $request){
        $balanceurl = 'http://gsc-app.test/api/testAPI';

        $response = Http::get($balanceurl

        );
        return $response;
    }
}
