<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionAccount;
use App\Models\Account;
use App\Models\Diary;
use App\Models\Page;
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

    public function all_diary_data()
    {
        $diary_object = new Diary;
        $data = $diary_object->all_data();
        return $data;
    }

    public function all_page_data()
    {
        $page_object = new Page;
        $data = $page_object->all_data();
        return $data;
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
            $torf = false;
            return $torf;
        }
    }

    public function int_check($num)
    {
        if (is_numeric($num))
        {
            return intval($num);
        }
        else
        {
            return false;
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
            return $return_data;
        }
        else
        {
            $return_data = 'no';
            return $return_data;
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

        if ($str_id && $str_password && $len_id && $len_password && count($id_check))
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
                $return_data = 'false';
                return $return_data;
            }
        }
        else
        {
            abort(500, 'サーバーエラーです');
        }
    }

    public function logout(Request $request)
    {
        $session_account_object = new SessionAccount;
        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $return_data = 'true';
        if ($torf)
        {
            $session_account_object->delete_session($session);
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function return_name(Request $request)
    {
        $account_object = new Account;
        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        if ($torf)
        {
            $account_id = MainController::s_after_a($session);
            $data = $account_object->search_id($account_id);
            $account_data = $data->toArray();
            foreach($account_data as $data => $key)
            {
                $return_data = $key['account_name'];
            }
            return $return_data;
        }
    }

    public function s_after_a($session)
    {
        $session_account_object = new SessionAccount;
        $session_account_data = $session_account_object->search_session($session);
        $session_account_data = $session_account_data->toArray();
        $account_id = $session_account_data["0"]["account_id"];
        return $account_id;
    }

    public function return_diary(Request $request)
    {
        $diary_object = new Diary;
        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $return_data = 'true';
        if ($torf)
        {
            $account_id = MainController::s_after_a($session);
            $data = $diary_object->search_account($account_id);
            if ((count($data)))
            {
                $data = $data->toArray();
                $return_data = [];
                foreach($data as $value => $key)
                {
                    $empty = [];
                    $empty[] = $key;
                    $return_data[] = $empty;
                    $empty = [];
                }
                return $return_data;
            }
            else
            {
                $return_data = 'nodata';
            }
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function test_add_diarydata(Request $request, $name, $color)
    {
        $diary_object = new Diary;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $return_data = 'true';
        if ($torf)
        {
            $account_id = MainController::s_after_a($session);
            $file = 'nodata';
            $text_color = 'nodata';
            $font = 'nodata';
            $diary_object->add_data($account_id,$name,$file,$color,$text_color,$font);
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function add_diary(Request $request)
    {
        $diary_object = new Diary;

        $name = $request->name;
        $color = $request->color;
        $text_color = $request->textColor;
        $font = $request->font;
        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $return_data = 'true';
        if ($torf)
        {
            $account_id = MainController::s_after_a($session);
            $file = 'nodata';
            $diary_object->add_data($account_id,$name,$file,$color,$text_color,$font);
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function delete_diary(Request $request)
    {
        $diary_object = new Diary;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($request->id);
        $return_data = 'true';

        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_data($id);
            if(count($diary_data) === 0)
            {
                $return_data = 'nodata';
                return $return_data;
            }
            $diary_data = $diary_object->search_account($account_id);
            $diary_data = $diary_data->toArray();
            foreach($diary_data as $values => $diary)
            {
                if ($id === $diary['diary_id'])
                {
                    $diary_object->delete_data($id);
                    $return_data = 'true';
                    return $return_data;
                }
                else{
                    $return_data = 'noid';
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function add_favorite(Request $request)
    {
        $diary_object = new Diary;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($request->id);
        $return_data = 'true';
        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            $diary_data = $diary_data->toArray();
            foreach($diary_data as $values => $diary)
            {
                if ($id === $diary['diary_id'])
                {
                    $diary_object->add_favorite($id);
                    $return_data = 'true';
                    return $return_data;
                }
                else{
                    $return_data = 'noid';
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function return_favorite(Request $request)
    {
        $diary_object = new Diary;
        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        if($torf)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->return_favorite($account_id);
            if(count($diary_data))
            {
                $data = $diary_data->toArray();
                $return_data = [];
                foreach($data as $value => $key)
                {
                    $empty = [];
                    $empty[] = $key;
                    $return_data[] = $empty;
                    $empty = [];
                }
                return $return_data;
            }
            else
            {
                $return_data = 'nodata';
            }
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function delete_favorite(Request $request)
    {
        $diary_object = new Diary;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($request->id);
        $return_data = 'true';
        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            $diary_data = $diary_data->toArray();
            foreach($diary_data as $values => $diary)
            {
                if ($id === $diary['diary_id'])
                {
                    $diary_object->delete_favorite($id);
                    $return_data = 'true';
                    return $return_data;
                }
                else{
                    $return_data = 'noid';
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function test_add_page(Request $request, $id, $title, $txt)
    {
        $diary_object = new Diary;
        $page_object = new Page;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($id);
        $return_data = 'true';

        if ($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            if(count($diary_data) === 0)
            {
                $return_data = 'nodata';
                return $return_data;
            }

            foreach ($diary_data as $diaries => $ids)
            {
                if($ids['diary_id'] === $id)
                {
                    $title_color = 'nodata';
                    $txt2 = 'nodata';
                    $marker_color = 'nodata';
                    $txt_color = 'nodata';
                    $file_txt1 = 'nodata';
                    $file_txt2 = 'nodata';
                    $file_txt3 = 'nodata';
                    $file_txt4 = 'nodata';
                    $file_txt5 = 'nodata';
                    $file_txt6 = 'nodata';
                    $file1 = 'nodata';
                    $file2 = 'nodata';
                    $file3 = 'nodata';
                    $file4 = 'nodata';
                    $file5 = 'nodata';
                    $file6 = 'nodata';

                    $page_object->add_data($id, $title, $title_color, $txt, $txt2, $marker_color, $txt_color, $file1, $file_txt1, $file2, $file_txt2, $file3, $file_txt3, $file4, $file_txt4, $file5, $file_txt5, $file6, $file_txt6);
                }
                else
                {
                    $return_data = 'noid';
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function add_page(Request $request)
    {
        $diary_object = new Diary;
        $page_object = new Page;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($request->id);
        $return_data = 'true';

        if ($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            if(count($diary_data) === 0)
            {
                $return_data = 'nodata';
                return $return_data;
            }

            foreach ($diary_data as $diaries => $ids)
            {
                if($ids['diary_id'] === $id)
                {   
                    $title = $request->title;
                    $title_color = $request->title_color;
                    $txt = $request->txt;
                    $txt2 = $request->txt2;
                    $marker_color = $request->marker_color;
                    $txt_color = $request->txt_color;
                    $file_txt1 = $request->file_txt1;
                    $file_txt2 = $request->file_txt2;
                    $file_txt3 = $request->file_txt3;
                    $file_txt4 = $request->file_txt4;
                    $file_txt5 = $request->file_txt5;
                    $file_txt6 = $request->file_txt6;
                    $file1 = 'nodata';
                    $file2 = 'nodata';
                    $file3 = 'nodata';
                    $file4 = 'nodata';
                    $file5 = 'nodata';
                    $file6 = 'nodata';

                    $page_object->add_data($id, $title, $title_color, $txt, $txt2, $marker_color, $txt_color, $file1, $file_txt1, $file2, $file_txt2, $file3, $file_txt3, $file4, $file_txt4, $file5, $file_txt5, $file6, $file_txt6);
                    return $return_data;
                }
                else
                {
                    $return_data = 'noid';
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function return_page(Request $request, $id)
    {
        $diary_object = new Diary;
        $page_object = new Page;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $return_data = 'true';
        $id = MainController::int_check($request->id);

        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            foreach ($diary_data as $diaries => $ids)
            {
                if($ids['diary_id'] === $id)
                {
                    $data = $page_object->search_diary($id);
                    $data = $data->toArray();
                    $return_data = [];
                    foreach($data as $value => $key)
                    {
                        $empty = [];
                        $empty[] = $key;
                        $return_data[] = $empty;
                        $empty = [];
                    }
                    return $return_data;
                }
                else
                {
                    $return_data = 'noid';
                    return $return_data;
                }
            }
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function delete_page(Request $request)
    {
        $diary_object = new Diary;
        $page_object = new Page;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($request->id);
        $return_data = 'true';

        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            $diary_data = $diary_data->toArray();
            $page_data = $page_object->search_id($id);
            $page_data = $page_data->toArray();
            if(count($page_data) === 0)
            {
                $return_data = 'nodata';
                return $return_data;
            }

            foreach($diary_data as $index => $diary)
            {
                foreach($page_data as $value => $page)
                {
                    if($diary['diary_id'] === $page['diary_id'])
                    {
                        $page_object->delete_data($id);
                        $return_data = 'true';
                        return $return_data;
                    }
                    else
                    {
                        $return_data = 'noid';
                    }
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function test_delete_page(Request $request, $id)
    {
        $diary_object = new Diary;
        $page_object = new Page;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($id);
        $return_data = 'true';

        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            $diary_data = $diary_data->toArray();
            $page_data = $page_object->search_id($id);
            $page_data = $page_data->toArray();
            if(count($page_data) === 0)
            {
                $return_data = 'nodata';
                return $return_data;
            }

            foreach($diary_data as $index => $diary)
            {
                foreach($page_data as $value => $page)
                {
                    if($diary['diary_id'] === $page['diary_id'])
                    {
                        $page_object->delete_data($id);
                        $return_data = 'true';
                        return $return_data;
                    }
                    else
                    {
                        $return_data = 'noid';
                    }
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function edit_page(Request $request)
    {
        $diary_object = new Diary;
        $page_object = new Page;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($request->id);
        $return_data = 'true';

        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            $diary_data = $diary_data->toArray();
            $page_data = $page_object->search_id($id);
            $page_data = $page_data->toArray();
            if (count($page_data) === 0)
            {
                $return_data = 'nodata';
                return $return_data;
            }

            $title = $request->title;
            $txt = $request->txt;
            foreach($diary_data as $index => $diary)
            {
                foreach($page_data as $value => $page)
                {
                    if($diary['diary_id'] === $page['diary_id'])
                    {
                        $title = $request->title;
                        $title_color = $request->title_color;
                        $txt = $request->txt;
                        $txt2 = $request->txt2;
                        $marker_color = $request->marker_color;
                        $txt_color = $request->txt_color;
                        $file_txt1 = $request->file_txt1;
                        $file_txt2 = $request->file_txt2;
                        $file_txt3 = $request->file_txt3;
                        $file_txt4 = $request->file_txt4;
                        $file_txt5 = $request->file_txt5;
                        $file_txt6 = $request->file_txt6;
                        $file1 = 'nodata';
                        $file2 = 'nodata';
                        $file3 = 'nodata';
                        $file4 = 'nodata';
                        $file5 = 'nodata';
                        $file6 = 'nodata';

                        $page_object->edit_page($id, $title, $title_color, $txt, $txt2, $marker_color, $txt_color, $file1, $file_txt1, $file2, $file_txt2, $file3, $file_txt3, $file4, $file_txt4, $file5, $file_txt5, $file6, $file_txt6);
                        $return_data = 'true';
                        return $return_data;
                    }
                    else
                    {
                        $return_data = 'noid';
                    }
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function test_edit_page(Request $request, $id, $title, $txt)
    {
        $diary_object = new Diary;
        $page_object = new Page;

        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $id = MainController::int_check($id);
        $return_data = 'true';

        if($torf && $id)
        {
            $account_id = MainController::s_after_a($session);
            $diary_data = $diary_object->search_account($account_id);
            $diary_data = $diary_data->toArray();
            $page_data = $page_object->search_id($id);
            $page_data = $page_data->toArray();
            if (count($page_data) === 0)
            {
                $return_data = 'nodata';
                return $return_data;
            }

            foreach($diary_data as $index => $diary)
            {
                foreach($page_data as $value => $page)
                {
                    if($diary['diary_id'] === $page['diary_id'])
                    {
                        $title_color = 'nodata';
                        $txt2 = 'nodata';
                        $marker_color = 'nodata';
                        $txt_color = 'nodata';
                        $file_txt1 = 'nodata';
                        $file_txt2 = 'nodata';
                        $file_txt3 = 'nodata';
                        $file_txt4 = 'nodata';
                        $file_txt5 = 'nodata';
                        $file_txt6 = 'nodata';
                        $file1 = 'nodata';
                        $file2 = 'nodata';
                        $file3 = 'nodata';
                        $file4 = 'nodata';
                        $file5 = 'nodata';
                        $file6 = 'nodata';

                        $page_object->edit_page($id, $title, $title_color, $txt, $txt2, $marker_color, $txt_color, $file1, $file_txt1, $file2, $file_txt2, $file3, $file_txt3, $file4, $file_txt4, $file5, $file_txt5, $file6, $file_txt6);
                        $return_data = 'true';
                        return $return_data;
                    }
                    else
                    {
                        $return_data = 'noid';
                    }
                }
            }
            return $return_data;
        }
        else
        {
            $return_data = 'false';
            return $return_data;
        }
    }

    public function add_file(Request $request)
    {
        return $request;
    }
}
