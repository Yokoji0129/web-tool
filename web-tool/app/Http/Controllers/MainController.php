<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class MainController extends Controller
{
    public function startpage()
    {
        return view('app');
    }
    public function all_account_data()
    {
        $account_object = new Account;
        $data = $account_object->all_data();
        return $data;
    }
    public function make_account()
    {
        $account_object = new Account;
        $id = 'test';
        $password = 'password';
        $random_key = 'hogehoge';
        $name = '匿名希望';

        $account_object->add_account($id,$password,$random_key,$name);
        return redirect("account/data");

    }
}
