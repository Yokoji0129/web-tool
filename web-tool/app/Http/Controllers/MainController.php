<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\SessionAccount;
use App\Models\AccountDiary;
use App\Models\Diary;
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
                $torf = false;
                return $torf;
            }
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

    public function auth($session)
    {
        $session_account_object = new SessionAccount;
        $session = MainController::full_to_half($session);
        $str_session = MainController::string_check($session);

        $login_situ = true;

        if ($str_session && (strlen($session) === 40))
        {
            $data = $session_account_object->search_session($session);
            if (count($data) === 1)
            {
                return $login_situ;
            }
            else
            {
                $login_situ = false;
                return $login_situ;
            }
        }
    }

    public function testlogin(Request $request, $id, $password)
    {
        $account_object = new Account;
        $session_account_object = new SessionAccount;

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
                $session = $request->cookies->get("laravel_session");
                $torf = MainController::auth($session);
                if ($torf === false)
                {
                    $session_account_object->add_session($session, $id);
                    return $return_data;
                }
                else
                {
                    $return_data = 'ログイン済み';
                    return $return_data;
                }
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

    public function login(Request $request)
    {
        $account_object = new Account;
        $session_account_object = new SessionAccount;

        $id = MainController::full_to_half($request->id);
        $password = MainController::full_to_half($request->password);
        //$id,passwordの全角英大文字,英子文字,数字を半角にする

        $str_id = MainController::string_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $str_password = MainController::string_check($password);//問題なければtrueが問題があればfalseが返ってくる
        $len_id = MainController::len_check($id);//問題なければtrueが問題があればfalseが返ってくる
        $len_password = MainController::len_check($password);//問題なければtrueが問題があればfalseが返ってくる
        $id = MainController::hash($id);
        $id_check = $account_object->search_id($id);

        $return_data = 'true';

        if ($str_id && $str_password && $len_id && $len_password && (count($id_check) > 0))
        {
            $account_data = $account_object->search_id($id);
            $account_data = $account_data->toArray();
            $befor_pass = $account_data["0"]["account_random_key"] . $password;
            $password = MainController::hash($befor_pass);
            if ($password === $account_data["0"]["account_password"])
            {
                $session = $request->cookies->get("laravel_session");
                $torf = MainController::auth($session);
                if ($torf === false)
                {
                    $session_account_object->add_session($session, $id);
                    return $return_data;
                }
                else
                {
                    $return_data = 'logged';
                    return $return_data;
                }
            }
            else
            {
                $reutrn_data = 'false';
                return $reutrn_data;
            }
        }
        else
        {
            abort(500, 'サーバーエラーです');
        }
    }

    public function return_diary(Request $request)
    {
        $session_account_object = new SessionAccount;
        $account_diary_object = new AccountDiary;
        $diary_object = new Diary;
        $session = $request->cookies->get("laravel_session");
        $session_account_data = $session_account_object->search_session($session);

        $return_data = 'true';
        if (count($session_account_data) === 1)
        {
            $session_account_data = $session_account_data->toArray();
            $account_id = $session_account_data["0"]["account_id"];
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }

        if ($return_data === 'true')
        {
            $account_diary_data = $account_diary_object->search_account($account_id);
            if ((count($account_diary_data) > 0))
            {
                $account_diary_data = $account_diary_data->toArray();
                $return_data = [];
                foreach ($account_diary_data as $diaries => $ids)
                {
                    $data = $diary_object->search_data($ids['diary_id']);
                    $data = $data->toArray();
                    $return_data[] = $data;
                }
                return $return_data;
            }
            else
            {
                $return_data = 'nodata';
                return $return_data;
            }
        }
        else
        {
            $return_data = '?';
            return $return_data;
        }
    }

    public function test_add_diarydata(Request $request, $name, $color)
    {
        $diary_object = new Diary;
        $session_account_object = new SessionAccount;
        $account_diary = new AccountDiary;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $return_data = 'true';
        if ($torf)
        {
            $id = $diary_object->all_data();
            $diary_id = count($id) + 1;
            $file = 'nodata';
            $diary_object->add_data($diary_id,$name,$file,$color);

            $session_account_data = $session_account_object->search_session($session);
            $session_account_data = $session_account_data->toArray();
            $account_id = $session_account_data["0"]["account_id"];
            $account_diary->add_data($account_id, $diary_id);
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function add_dairy(Request $request)
    {
        $diary_object = new Diary;
        $session_account_object = new SessionAccount;
        $account_diary = new AccountDiary;

        $name = $request->name;
        $color = $request->color;
        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $return_data = 'true';
        if ($torf)
        {
            $id = $diary_object->all_data();
            $diary_id = count($id) + 1;
            $file = 'nodata';
            $diary_object->add_data($diary_id,$name,$file,$color);

            $session_account_data = $session_account_object->search_session($session);
            $session_account_data = $session_account_data->toArray();
            $account_id = $session_account_data["0"]["account_id"];
            $account_diary->add_data($account_id, $diary_id);
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }
}
