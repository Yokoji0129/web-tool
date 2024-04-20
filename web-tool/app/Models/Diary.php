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
        'account_id',
        'diary_name',
        'diary_top_file',
        'diary_color',
        'diary_text_color',
        'diary_font',
        'diary_favorite'
    ];

    public function all_data()
    {
        $data = DB::table($this->table)->get();
        return $data;
    }

    public function search_account($id)
    {
        $data = Diary::where('account_id', 'like', "$id")
            ->get([
                'diary_id',
                'diary_name',
                'diary_top_file',
                'diary_color',
                'diary_text_color',
                'diary_font',
                'diary_favorite'
            ]);
        return $data;
    }
    public function search_data($id)
    {
        $data = Diary::where('diary_id', 'like', "$id")
            ->get([
                'diary_id',
                'diary_name',
                'diary_top_file',
                'diary_color',
                'diary_text_color',
                'diary_font',
                'diary_favorite'
            ]);
        return $data;
    }

    public function add_data($account_id, $name, $file, $color, $text_color, $font)
    {
        Diary::create([
            'account_id' => $account_id,
            'diary_name' => $name,
            'diary_top_file' => $file,
            'diary_color' => $color,
            'diary_text_color' => $text_color,
            'diary_font' => $font,
            'diary_favorite' => 0
        ]);
    }

    public function add_favorite($id)
    {
        Diary::where('diary_id', 'like', "$id")->update(['diary_favorite' => 1]);
    }

    public function return_favorite($id)
    {
        $data = Diary::where([
            ['account_id', 'like', "$id"],
            ['diary_favorite', '=', '1']
        ])->get([
                'diary_id',
                'diary_name',
                'diary_top_file',
                'diary_color',
                'diary_text_color',
                'diary_font',
                'diary_favorite'
            ]);
        return $data;
    }

    public function delete_favorite($id)
    {
        Diary::where('diary_id', 'like', "$id")->update(['diary_favorite' => 0]);
    }

    public function delete_data($id)
    {
        Diary::where('diary_id', 'like', "$id")->delete();
    }
}
