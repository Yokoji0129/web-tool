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
    public function make_account($id,$password)
    {
        function string_check($data)
        {
            if (preg_match("/^[a-zA-Z0-9]+$/", $data))
            {
                return $data;
            }
            else
            {
                $data .= 'に使用できない文字が含まれています';
                dd($data);
            }
        }

        function len_check($data)
        {
            if((strlen($data) >= 8) && (strlen($data) <= 32))
            {
                return $data;
            }
            else
            {
                $data .= 'は8文字以上32文字以下の条件に一致していません';
                dd($data);
            }
        }

        $account_object = new Account;

        //$idの全角英大文字,英子文字,数字を半角にする

        string_check($id);
        string_check($password);
        len_check($id);
        len_check($password);

        $account_object->serach_id($id);//idが存在するかチェック,存在するなら何の処理も実行されない

        $random_key = 'hogehoge';//20文字でランダムに生成

        //$password + $random_keyの文字列を20回ハッシュ化
        //$idも20回ハッシュ化
        //ハッシュ化したものをpasswordとして保存

        $name = '匿名希望';

        $account_object->add_account($id,$password,$random_key,$name);
        return redirect("account/data");

    }

    public function add_account(Request $request)
    {
        $account_object = new Account;
        $account_object->add_account($request->id,$request->password,$request->confirmPassword,'匿名希望');
    }
}
