<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionAccount;
use App\Models\Account;
use App\Models\Diary;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MainController extends Controller
{
    public function startpage()
    {
        //ページを返します
        return view('app');
    }

    public function all_account_data()
    {   //全てのアカウントのすべてのデータを返す
        $account_object = new Account;
        $data = $account_object->all_data();
        return $data;
    }

    public function all_diary_data()
    {   //全ての日記の全てのデータを返す
        $diary_object = new Diary;
        $data = $diary_object->all_data();
        return $data;
    }

    public function all_page_data()
    {   //全てのページの全てのデータを返す
        $page_object = new Page;
        $data = $page_object->all_data();
        return $data;
    }

    public function search_id($id)
    {   //アカウントが存在するかどうかを返す
        $account_object = new Account;
        $id = MainController::hash($id);
        $data = $account_object->search_id($id);
        //フロントでの確認をしやすくするため文字列で返す
        if (count($data) === 0)
        {   //存在しない状態がtrue
            $torf = 'true';
            return $torf;
        }
        else
        {   //存在する状態がfalse
            $torf = 'false';
            return $torf;
        }
    }

    public function session(Request $request)
    {   //セッションの確認用
        dump($request->cookies->get("laravel_session"));
    }

    public function full_to_half($data)
    {   //全角があれば半角にして返す
        $after_data = mb_convert_kana($data, 'a');
        return $after_data;
    }

    public function add_image($file, $file_name)
    {
        //ファイルの削除
        MainController::delete_image($file_name);
        //ファイルの保存
        $path = $file->storeAs('public', $file_name);
        return $file_name;
    }

    public function delete_image($filename)
    {
        $return_data = 'notdelete';
        //ファイルが存在すれば削除
        if(Storage::disk('public')->exists($filename))
        {
            //ファイルの削除
            Storage::disk('public')->delete($filename);
            $return_data = 'delete';
        }
        return $return_data;
    }

    public function string_check($data)
    {   //入力された文字列が想定している内容と一致するかを確認
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
    {   //数値型もしくは数値形式の文字型であるかを確認
        if (is_numeric($num))
        {   //数値型に変換して返す
            return intval($num);
        }
        else
        {
            return false;
        }
    }

    public function len_check($data)
    {   //文字列の大きさが想定しているものであるか確認
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
    {   //渡されたデータをハッシュ化
        for ($i = 0; $i < 20; $i += 1)
        {
            $data = hash('sha256', $data);
        }
        return $data;
    }

    public function make_account($id,$password)
    {
        $account_object = new Account;
        //$id,passwordの全角英大文字,英子文字,数字を半角にする
        $id = MainController::full_to_half($id);
        $password = MainController::full_to_half($password);
        //文字列が想定している長さと内容か確認
        $str_id = MainController::string_check($id);
        $str_password = MainController::string_check($password);
        $len_id = MainController::len_check($id);
        $len_password = MainController::len_check($password);
        //アカウントの有無、ソルトの作成
        $id_check = MainController::search_id($id);
        $random_key = Str::random(20);
        //入力されたパスワードとソルトを連結、新たなパスワードとする
        $befor_pass = $random_key . $password;
        //パスワードとidをハッシュ化、名前を初期化
        $password = MainController::hash($befor_pass);
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
        //$id,passwordの全角英大文字,英子文字,数字を半角にする 
        $id = MainController::full_to_half($request->id);
        $password = MainController::full_to_half($request->password);
        //文字列が想定している長さと内容か確認
        $str_id = MainController::string_check($id);
        $str_password = MainController::string_check($password);
        $len_id = MainController::len_check($id);
        $len_password = MainController::len_check($password);
        //アカウントの有無、ソルトの作成
        $id_check = MainController::search_id($id);
        $random_key = Str::random(20);
        //入力されたパスワードとソルトを連結、新たなパスワードとする
        $befor_pass = $random_key . $password;
        //パスワードとidをハッシュ化
        $password = MainController::hash($befor_pass);
        $id = MainController::hash($id);
        //名前の取得、返す値の初期化
        $name = $request->accountName;
        $return_data = 'ok';

        if($str_id && $str_password && $len_id && $len_password && $id_check)
        {//上記の処理で問題がなければアカウント作成
            $account_object->add_account($id,$password,$random_key,$name);
            //アカウントidのフォルダがあるか確認
            //無ければ作成
            return $return_data;
        }
        else
        {//上記の処理で問題があったことを返す
            $return_data = 'no';
            return $return_data;
        }
    }

    public function auth($session)
    {
        $session_account_object = new SessionAccount;
        //与えられたセッションidが全角であれば半角に
        $session = MainController::full_to_half($session);
        //与えられたセッションidが想定している文字列か確認
        $str_session = MainController::string_check($session);
        //返す値の初期化
        $login_situ = false;
        //larabelでデフォルトの長さである40と一致するか確認
        if ($str_session && (strlen($session) === 40))
        {   
            $data = $session_account_object->search_session($session);
            //1つだけ存在すれば正常なログインと判断
            if (count($data) === 1)
            {
                $login_situ = true;
            }
            return $login_situ;
        }
    }

    public function testlogin(Request $request, $id, $password)
    {
        $account_object = new Account;
        $session_account_object = new SessionAccount;
        //$id,passwordの全角英大文字,英子文字,数字を半角にする 
        $id = MainController::full_to_half($id);
        $password = MainController::full_to_half($password);

        //文字列が想定している内容、大きさであるかを確認
        $str_id = MainController::string_check($id);
        $str_password = MainController::string_check($password);
        $len_id = MainController::len_check($id);
        $len_password = MainController::len_check($password);

        //idのハッシュ化
        $id = MainController::hash($id);
        //idからアカウント情報の検索
        $account_data = $account_object->search_id($id);
        //返却データの初期化
        $return_data = 'ok';

        if ($str_id && $str_password && $len_id && $len_password && (count($account_data)))
        {   //上記の処理で問題なければログイン処理に移る
            // $account_data = $account_data->toArray();
            //アカウント情報から取得したソルトと入力されたパスワードを結合
            $befor_pass = $account_data[0]->account_random_key . $password;
            //パスワードのハッシュ化
            $password = MainController::hash($befor_pass);
            if ($password === $account_data[0]->account_password)
            {   //パスワードの一致を確認
                $session = $request->cookies->get("laravel_session");
                $torf = MainController::auth($session);
                //ログイン状態でないことを確認
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
            {   //パスワードが一致しなかったことを返す
                $return_data = 'no';
                return view('app', compact('return_data'));
            }
        }
        else
        {   //上記の処理で問題があったことを示す
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
            // $account_data = $account_data->toArray();
            $befor_pass = $account_data[0]->account_random_key . $password;
            $password = MainController::hash($befor_pass);
            if ($password === $account_data[0]->account_password)
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
            // $account_data = $data->toArray();
            // foreach($account_data as $data => $key)
            // {
            //     $return_data = $key['account_name'];
            // }
            $return_data = $data[0]->account_name;
            return $return_data;
        }
    }

    public function s_after_a($session)
    {
        $session_account_object = new SessionAccount;
        $session_account_data = $session_account_object->search_session($session);
        // $session_account_data = $session_account_data->toArray();
        // $account_id = $session_account_data["0"]["account_id"];
        $account_id = $session_account_data[0]->account_id;
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
        {   //画像パスを空として日記情報を登録
            //アカウントIDでフォルダー作成
            //取得した日記数+1の番号のフォルダがあるか
            //無ければ作成あれば処理の中断
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
            {   //一致するidがあれば処理を行う
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
                    //ループを抜け、$return_dataで問題ないことを示すためtrueを入れておく
                    return $return_data = 'true';
                }
                else
                {   //一致するidでなければnoidを入れておく
                    $return_data = 'noid';
                }
            }
            //状態を返す
            return $return_data;
        }
        else
        {   //ログイン状態でないか、idがintでなかった場合falseを返す
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
            if ((count($diary_data) === 0) || (count($page_data) === 0))
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
                        $file3 = 'nodate';
                        $file4 = 'nodata';
                        $file5 = 'nodata';
                        $file6 = 'nodata';
                        //ファイルの存在確認
                        if ($request->hasfile('page_file1'))
                        {
                            $file = $request->file('page_file1');
                            $file1 = MainController::add_image($file, "p_" . "$id" . "_1." . $file->getClientOriginalExtension());
                        }
                        //ファイルの存在確認
                        if ($request->hasfile('page_file2'))
                        {
                            $file = $request->file('page_file2');
                            $file2 = MainController::add_image($file, "p_" . "$id" . "_2." . $file->getClientOriginalExtension());
                        }
                        //ファイルの存在確認
                        if ($request->hasfile('page_file3'))
                        {
                            $file = $request->file('page_file3');
                            $file3 = MainController::add_image($file, "p_" . "$id" . "_3." . $file->getClientOriginalExtension());
                        }
                        //ファイルの存在確認
                        if ($request->hasfile('page_file4'))
                        {
                            $file = $request->file('page_file4');
                            $file4 = MainController::add_image($file, "p_" . "$id" . "_4." . $file->getClientOriginalExtension());
                        }
                        //ファイルの存在確認
                        if ($request->hasfile('page_file5'))
                        {
                            $file = $request->file('page_file5');
                            $file5 = MainController::add_image($file, "p_" . "$id" . "_5." . $file->getClientOriginalExtension());
                        }
                        //ファイルの存在確認
                        if ($request->hasfile('page_file6'))
                        {
                            $file = $request->file('page_file6');
                            $file6 = MainController::add_image($file, "p_" . "$id" . "_6." . $file->getClientOriginalExtension());
                        }

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

    // ログインしているアカウントの画像か確認し画像パスを返す
    public function return_file_path(Request $request, $image_name)
    {
        $account_object = new Account;
        $diary_object = new Diary;
        $page_object = new Page;
        $return_data = 'false';
        $session = $request->cookies->get("laravel_session");
        $torf = MainController::auth($session);
        $image_name = MainController::full_to_half($image_name);
        $len_image_name = MainController::len_check($image_name);
        if($len_image_name && $torf)
        { //画像がアカウントのものか確認
            // 画像のパスがどのページのものか確認
            $page_data = $page_object->search_image($image_name);
            // アカウントの日記を取得
            $diary_data = $diary_object->search_account(MainController::s_after_a($session));
            foreach($diary_data as $diary)
            {
                if($diary->diary_id === $page_data[0]->diary_id)
                {
                    $return_data = MainController::return_image($image_name);
                }
            }
        }
        return $return_data;
    }

    public function add_file(Request $request)
    {
        $return_data = 'false';
        //ファイルが存在するかチェック
        if($request->hasfile('file'))
        {
            //ファイル本体を取得
            $file = $request->file('file');
            //ファイル名を設定
            $file_name = 'test.' . $file->getClientOriginalExtension();
            //ファイルを保存
            MainController::add_image($file, $file_name);
            //ファイル名を基にファイルを削除
            $delete_check = MainController::delete_image($file_name);
        }
        if($delete_check === 'delete')
        {
            //削除されていればtrueを返す
            $return_data = 'true';
        }
        return $return_data;
    }

    public function return_image($image_name)
    {
        $path = storage_path("app/public/{$image_name}");
        $file = File::get($path);
        $type = File::mimeType($path);

        return response($file, 200)->header("Content-Type", $type);
    }
}
