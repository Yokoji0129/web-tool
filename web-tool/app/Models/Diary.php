<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Diary extends Model
{
    use HasFactory;
    protected $table = 'diaries';
    protected $fillable = [  
        'diary_id',  
        'diary_name',
        'diary_top_file',
        'diary_color'
    ];

    public function all_data()
    {
        $data = DB::table($this->table)->get();
        return $data;
    }

    public function search_data($id)
    {
        $data = Diary::where('diary_id', 'like', "$id")->get(['diary_id', 'diary_name', 'diary_top_file', 'diary_color']);
        return $data;
    }

    public function add_data($id, $name, $file, $color)
    {
        Diary::create([
            'diary_id' => $id,
            'diary_name' => $name,
            'diary_top_file' => $file,
            'diary_color' => $color
        ]);
    }
}
