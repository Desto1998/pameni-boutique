<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;
    public static function totalCartFromCard(){
        $data = session("panier");
        $total = 0;
        if (!empty($data)) {
//        $target_dir = "../../assets/images/";
            foreach ($data as $key => $value) {
                $total += $data[$key]["prix"] * $data[$key]["qte"];
            }
        }
        return $total;
    }
    public static function numberInCard(){
        $number = 0;
        if (session("panier") !== null) {
            $data = session("panier");
            $number = count($data);
        }


        return $number;
    }
}
