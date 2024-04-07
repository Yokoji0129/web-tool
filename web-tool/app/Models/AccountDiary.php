<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountDiary extends Model
{
    use HasFactory;
    protected $table = 'account_diaries';
    protected $fillable = [  
        'account_id',  
        'diary_id' 
    ]; 

    public function search_account($account_id)
    {
        $data = AccountDiary::where('account_id', 'like', "$account_id")->get(['account_id', 'diary_id']);
        return $data;
    }

    public function add_data($account_id, $diary_id)
    {
        AccountDiary::create([
            'account_id' => $account_id,
            'diary_id' => $diary_id
        ]);
    }
}
