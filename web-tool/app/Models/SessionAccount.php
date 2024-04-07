<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SessionAccount extends Model
{
    use HasFactory;
    protected $table = 'session_accounts';
    protected $fillable = [  
        'session_id',  
        'account_id' 
    ];

    public function add_session($session, $account_id)
    {
        SessionAccount::create([
            'session_id' => $session,
            'account_id' => $account_id
        ]);
    }

    public function search_session($id)
    {
        $data = SessionAccount::where('session_id', 'like', "$id")->get(['session_id', 'account_id']);
        return $data;
    }

    public function search_account($id)
    {
        $data = SessionAccount::where('account_id', 'like', "$id")->get(['session_id', 'account_id']);
        return $data;
    }

    public function delete_session($session)
    {
        $data = SessionAccount::find($session);
        $data->delete();
    }
}
