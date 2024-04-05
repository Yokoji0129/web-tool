<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\SessionAccount;
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
        $id = MainController::hash($id);
        $data = $account_object->search_id($id);
        if (count($data) === 0)
        {
            $torf = 'true';
            return $torf;
        }
        else
        {
            $torf = 'false';
            return $torf;
        }
    }

    public function session(Request $request)
    {
        dump($request->cookies->get("laravel_session"));
    }

    public function search_session($session)
    {
        $session_account_object = new SessionAccount;
        $data = $session_account_object->search_session($session);
        if (count($data) === 0)
        {
            $torf = true;
            return $torf;
        }
        else
        {
            $torf = false;
            return $torf;
        }
    }

    public function full_to_half($data)
    {
        $after_data = mb_convert_kana($data, 'a');
        return $after_data;
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
            // $data .= 'に使用できない文字が含まれています';
            // echo $data;
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
                // $data .= 'は8文字以上32文字以下の条件に一致していません';
                // echo $data;
                $torf = false;
                return $torf;
            }
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

    public function hash($data)
    {
        for ($i = 0; $i < 20; $i += 1)
        {
            $data = hash('sha256', $data);
        }
        return $data;
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

        $id = MainController::hash($id);
        $id_check = MainController::search_id($id);
        $random_key = Str::random(20);

        $befor_pass = $random_key . $password;

        $password = MainController::hash($befor_pass);//ハッシュ化したものをpasswordとして保存
        $id = MainController::hash($id);
        $name = '匿名希望';

        if($str_id && $str_password && $len_id && $len_password && $id_check)
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

        $id_check = MainController::search_id($id);
        $random_key = Str::random(20);
        $befor_pass = $random_key . $password;
        $password = MainController::hash($befor_pass);//ハッシュ化したものをpasswordとして保存
        $id = MainController::hash($id);

        $name = $request->accountName;
        $return_data = 'ok';

        if($str_id && $str_password && $len_id && $len_password && $id_check)
        //上記の処理で問題がなければアカウント作成
        {
            $account_object->add_account($id,$password,$random_key,$name);
            return view('app', compact('return_data'));
        }
        else
        {
            $return_data = 'no';
            return view('app', compact('return_data'));
        }
    }

    public function auth($session, $id)
    {
        $session_account_object = new SessionAccount;
        $session = MainController::full_to_half($session);
        $str_session = MainController::string_check($session);
        if ($str_session && (strlen($session) === 40))
        {
            if (MainController::search_session($session))
            {
                $session_account_object->add_session($session, $id);
                echo 'ログインしました';
            }
            else
            {
                echo 'ログイン済みです';
            }
        }
    }

    public function testlogin(Request $request, $id, $password)
    {
        $account_object = new Account;

        $id = MainController::full_to_half($id);
        $password = MainController::full_to_half($password);
        //$id,passwordの全角英大文字,英子文字,数字を半角にする

        $str_id = MainController::string_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $str_password = MainController::string_check($password);//問題なければtrueが問題があればfalseが返ってくる
        $len_id = MainController::len_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $len_password = MainController::len_check($password);//問題なければtrueが問題があればfalseが返ってくる
        $id = MainController::hash($id);
        $id_check = $account_object->search_id($id);

        $return_data = 'ok';

        if ($str_id && $str_password && $len_id && $len_password && (count($id_check) > 0))
        {
            $account_data = $account_object->search_id($id);
            $account_data = $account_data->toArray();
            $befor_pass = $account_data["0"]["account_random_key"] . $password;
            $password = MainController::hash($befor_pass);
            if ($password === $account_data["0"]["account_password"])
            {
                MainController::auth($request->cookies->get("laravel_session"), $id);
            }
            else
            {
                $return_data = 'no';
                // return view('app', compact('return_data'));
                echo $return_data;
            }
        }
        else
        {
            abort(500, 'サーバーエラーです');
        }
    }

    public function login(Request $request)
    {
        $account_object = new Account;

        $id = MainController::full_to_half($request->id);
        $password = MainController::full_to_half($request->password);
        //$id,passwordの全角英大文字,英子文字,数字を半角にする

        $str_id = MainController::string_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $str_password = MainController::string_check($password);//問題なければtrueが問題があればfalseが返ってくる
        $len_id = MainController::len_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $len_password = MainController::len_check($password);//問題なければtrueが問題があればfalseが返ってくる
        $id = MainController::hash($id);
        $id_check = $account_object->search_id($id);

        $return_data = 'ok';

        if ($str_id && $str_password && $len_id && $len_password && (count($id_check) > 0))
        {
            $account_data = $account_object->search_id($id);
            $account_data = $account_data->toArray();
            $befor_pass = $account_data["0"]["account_random_key"] . $password;
            $password = MainController::hash($befor_pass);
            if ($password === $account_data["0"]["account_password"])
            {
                return view('app', compact('return_data'));
            }
            else
            {
                $return_data = 'no';
                return view('app', compact('return_data'));
            }
        }
        else
        {
            abort(500, 'サーバーエラーです');
        }
    }
}
