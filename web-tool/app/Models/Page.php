<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model
{
    use HasFactory;
    protected $table = 'pages';
    protected $fillable = [  
        'diary_id',
        'page_id',  
        'page_title',
        'page_txt',
        'page_file1',
        'page_file2',
        'page_file3',
        'page_file4',
        'page_file5',
        'page_file6'
    ];

    public function all_data()
    {
        $data = DB::table($this->table)->get();
        return $data;
    }

    public function search_diary($id)
    {
        $data = Page::where('diary_id', 'like', "$id")
            ->get([
                'diary_id',
                'page_id',
                'page_title',
                'page_txt',
                'page_file1',
                'page_file2',
                'page_file3',
                'page_file4',
                'page_file5',
                'page_file6'
            ]);
        return $data;
    }

    public function search_id($id)
    {
        $data = Page::where('page_id', 'like', "$id")
            ->get([
                'diary_id',
                'page_id',
                'page_title',
                'page_txt',
                'page_file1',
                'page_file2',
                'page_file3',
                'page_file4',
                'page_file5',
                'page_file6'
            ]);
        return $data;
    }

    public function add_data($diary_id, $title, $txt, $file1, $file2, $file3, $file4, $file5, $file6)
    {
        Page::create([
            'diary_id' => $diary_id,
            'page_title' => $title,
            'page_txt' => $txt,
            'page_file1' => $file1,
            'page_file2' => $file2,
            'page_file3' => $file3,
            'page_file4' => $file4,
            'page_file5' => $file5,
            'page_file6' => $file6
        ]);
    }

    public function edit_page($id, $title, $txt, $file1, $file2, $file3, $file4, $file5, $file6)
    {
        Page::where('page_id', 'like', "$id")
            ->update(['page_title' => $title,
                'page_txt' => $txt,
                'page_file1' => $file1,
                'page_file2' => $file2,
                'page_file3' => $file3,
                'page_file4' => $file4,
                'page_file5' => $file5,
                'page_file6' => $file6
        ]);
    }

    public function delete_data($id)
    {
        Page::where('page_id', 'like', "$id")->delete();
    }
}
