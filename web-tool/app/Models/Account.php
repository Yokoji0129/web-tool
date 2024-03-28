<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';
    protected $fillable = [  
        'account_id',  
        'account_password',
        'account_random_key',
        'account_name'  
    ];  
    public function all_data()
    {
        $data = DB::table($this->table)->get();
        return $data;
    }

    public function add_account($id,$password,$random_key,$name)
    {
        Account::create([
            'account_id' => $id,
            'account_password' => $password,
            'account_random_key' => $random_key,
            'account_name' => $name
        ]);
    }

    public function search_id($id)
    {
        $data = Account::where('account_id', 'like', "$id")->get();
        return $data;
    }
}
