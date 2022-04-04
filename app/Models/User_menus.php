<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;

class User_menus extends Model
{
    use HasFactory;
    protected $table = 'user_menus';
    protected $primaryKey = 'user_menu_id';
    protected $fillable = [
        'userid',
        'iduser',
        'idmenu',
    ];

    /**
     * Ici on selection les elements du menu du user connecte et on retourne un table de
     * position ou de code de chaque menu;
     * @return array @$data of int
     */
    public function getUserMenu(){
        $data = [];
        $iduser = Auth::user()->id;
        $menu = User_menus::join('menus','menus.menu_id','user_menus.idmenu')
            ->where('user_menus.userid',$iduser)
            ->select('menus.code')
            ->get()
        ;
        foreach ($menu as $key=>$item){
            $data[$key] = $item->code;
        }
        return $data;
    }
}
