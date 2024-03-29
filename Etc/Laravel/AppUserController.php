<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use App\Models\GetItem;
use Illuminate\Http\Request;

class AppUserController extends Controller
{
    public $ITEM_ID_MAX = 6;

    public function app_user($id)
    {
        $app_user = AppUser::find($id);
        return view('app_user', ['app_user' => $app_user]);
    }

    public function play_chara_gacha($id)
    {
        $app_user = AppUser::find($id);
        $has_chara_flag = $app_user->has_chara_flag;
        $result_string = "";

        $rand_num = mt_rand(1, 10000);
        $jouyo = $rand_num % 32;
        $result_string = $result_string.$jouyo.",";
        $jouyo_flag = 1 << $jouyo;
        $app_user->has_chara_flag = $has_chara_flag | $jouyo_flag;
        $app_user->save();

        return view('play_chara_gacha', ['result_string' => $result_string]);
    }

    public function play_item_gacha($id)
    {
        $result_string = "";

        $rand_num = mt_rand(1, 10000);
        $jouyo = $rand_num % $this->ITEM_ID_MAX;
        $result_string = $result_string.$jouyo.",";

        GetItem::insert([
            'get_item_id' => $jouyo,
            'user_id' => $id
        ]);

        return view('play_item_gacha', ['result_string' => $result_string]);
    }

    public function show_has_item($id)
    {
        $result_string = "";

        // array_fill関数.
        // 開始インデックス、要素数、初期値.
        $itemNumArray = array_fill(0, $this->ITEM_ID_MAX, 0);
        
        $itemList = GetItem::get();

        foreach ($itemList as $item) {
            if($item->user_id != $id){
                continue;
            }

            $itemNumArray[$item->get_item_id] ++;
        }

        for($i = 0; $i < $this->ITEM_ID_MAX; $i ++){
            $result_string = $result_string.$itemNumArray[$i].",";
        }

        return view('show_has_item', ['result_string' => $result_string]);
    }    

    public function play_chara_gacha_10($id)
    {
        $app_user = AppUser::find($id);
        $has_chara_flag = $app_user->has_chara_flag;
        $result_string = "";

        $gachaCount = 10;
        for ($i = 0; $i < $gachaCount; $i++) {
            $rand_num = mt_rand(1, 10000);
            $jouyo = $rand_num % 32;
            $result_string = $result_string.$jouyo.",";
            $jouyo_flag = 1 << $jouyo;
            $has_chara_flag = $has_chara_flag | $jouyo_flag;
        }
        $app_user->has_chara_flag = $has_chara_flag;
        $app_user->save();

        return view('play_chara_gacha', ['result_string' => $result_string]);
    }

    public function clear_has_chara_flag($id)
    {
        $app_user = AppUser::find($id);
        $app_user->has_chara_flag = 0;
        $app_user->save();

        return view('nothing');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AppUser $appUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppUser $appUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppUser $appUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppUser $appUser)
    {
        //
    }
}
