<?php

namespace App\Http\Controllers;

use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class LicenceController extends Controller
{
    //
    public function setLicence(){
        $date = new DateTime(date('Y-m-d'));
        $nbjour = 3;
        $date->add(new DateInterval("P{$nbjour}D"));
        $date = date("Y-m-d", strtotime($date->format('Y-m-d')));
    }
}
