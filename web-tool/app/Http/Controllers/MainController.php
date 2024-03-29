<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Str;

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
        return $data;//全てのアカウントのすべてのデータを返す
    }

    public function search_id($id)
    {
        $account_object = new Account;
        $data = $account_object->search_id($id);
        return $data;
    }

    public function string_check($data)
    {
        if (preg_match("/^[a-zA-Z0-9]+$/", $data))
        {
            $torf = true;
            return $torf;
        }
        else
        {
            $data .= 'に使用できない文字が含まれています';
            echo $data;
            $torf = false;
            return $torf;
        }
    }

    public function len_check($data)
    {
        if((strlen($data) >= 8) && (strlen($data) <= 32))
            {
                $torf = true;
                return $torf;
            }
        else
            {
                $data .= 'は8文字以上32文字以下の条件に一致していません';
                echo $data;
                $torf = false;
                return $torf;
            }
    }

    public function full_to_half($data)
    {
        $data = mb_convert_kana($data, 'a');
        return $data;
    }

    public function hash_password($solt,$password)
    {
        $str = $solt . $password;
        for ($i = 0; $i < 20; $i += 1)
        {
            $str = hash('sha256', $str);
        }
        return $str;
    }

    public function make_account($id,$password)
    {
        $account_object = new Account;
        $id = MainController::full_to_half($id);
        $password = MainController::full_to_half($password);
        //$id,passwordの全角英大文字,英子文字,数字を半角にする

        $str_id = MainController::string_check($id);
        $str_password = MainController::string_check($password);
        $len_id = MainController::len_check($id);
        $len_password = MainController::len_check($password);

        $id_check = $account_object->search_id($id);
        $random_key = Str::random(20);
        $password = MainController::hash_password($random_key,$password);//ハッシュ化したものをpasswordとして保存
        $name = '匿名希望';

        if($str_id && $str_password && $len_id && $len_password && (count($id_check) === 0))
        //上記の処理で問題がなければアカウント作成
        {
            $account_object->add_account($id,$password,$random_key,$name);
        }
    }

    public function add_account(Request $request)
    {
        $account_object = new Account;

        $id = MainController::full_to_half($request->id);
        $password = MainController::full_to_half($request->password);
        //$id,passwordの全角英大文字,英子文字,数字を半角にする

        $str_id = MainController::string_check($id);
        $str_password = MainController::string_check($password);
        $len_id = MainController::len_check($id);
        $len_password = MainController::len_check($password);

        $id_check = $account_object->serach_id($id);

        $random_key = Str::random(20);
        $password = MainController::hash_password($random_key,$password);//ハッシュ化したものをpasswordとして保存
        $name = '匿名希望';

        if($str_id && $str_password && $len_id && $len_password && (count($id_check) === 0))
        //上記の処理で問題がなければアカウント作成
        {
            $account_object->add_account($id,$password,$random_key,$name);
        }
    }

    public function login($id, $password)
    {
        $account_object = new Account;

        $id = mb_convert_kana($id,"a");
        $password = mb_convert_kana($password,"a");
        //$id,passwordの全角英大文字,英子文字,数字を半角にする

        $str_id = MainController::string_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $str_password = MainController::string_check($password);//問題なければtrueが問題があればfalseが返ってくる
        $len_id = MainController::len_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $len_password = MainController::len_check($password);//問題なければtrueが問題があればfalseが返ってくる

        //上記の4つがtrueであれば処理を行う
        //id検索をして対象となるアカウントがあれば認証に、なければ何もしない
        //対象となるアカウントの情報だけをデーターベースから取ってきて、そのソルトと入力されたpasswordをハッシュ化し一致するか確認
        //一致すればセッションidとidを紐づけ保存
    }
}
