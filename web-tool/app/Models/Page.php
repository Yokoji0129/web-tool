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
        'page_titile_color',
        'page_txt1',
        'page_txt2',
        'page_marker_color',
        'page_txt_color',
        'page_file1',
        'page_file_txt1',
        'page_file2',
        'page_file_txt2',
        'page_file3',
        'page_file_txt3',
        'page_file4',
        'page_file_txt4',
        'page_file5',
        'page_file_txt5',
        'page_file6',
        'page_file_txt6'
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
                'page_title_color',
                'page_txt1',
                'page_txt2',
                'page_marker_color',
                'page_txt_color',
                'page_file1',
                'page_file_txt1',
                'page_file2',
                'page_file_txt2',
                'page_file3',
                'page_file_txt3',
                'page_file4',
                'page_file_txt4',
                'page_file5',
                'page_file_txt5',
                'page_file6',
                'page_file_txt6'
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
                'page_title_color',
                'page_txt1',
                'page_txt2',
                'page_marker_color',
                'page_txt_color',
                'page_file1',
                'page_file_txt1',
                'page_file2',
                'page_file_txt2',
                'page_file3',
                'page_file_txt3',
                'page_file4',
                'page_file_txt4',
                'page_file5',
                'page_file_txt5',
                'page_file6',
                'page_file_txt6'
            ]);
        return $data;
    }

    public function add_data($diary_id, $title, $title_color, $txt1, $txt2, $marker_color, $txt_color, $file1, $file_txt1, $file2, $file_txt2, $file3, $file_txt3, $file4, $file_txt4, $file5, $file_txt5, $file6, $file_txt6)
    {
        Page::create([
            'diary_id' => $diary_id,
            'page_title' => $title,
            'page_title_color' => $title_color,
            'page_txt1' => $txt1,
            'page_txt2' => $txt2,
            'page_marker_color' => $marker_color,
            'page_txt_color' => $txt_color,
            'page_file1' => $file1,
            'page_file_txt1' => $file_txt1,
            'page_file2' => $file2,
            'page_file_txt2' => $file_txt2,
            'page_file3' => $file3,
            'page_file_txt3' => $file_txt3,
            'page_file4' => $file4,
            'page_file_txt4' => $file_txt4,
            'page_file5' => $file5,
            'page_file_txt5' => $file_txt5,
            'page_file6' => $file6,
            'page_file_txt6' => $file_txt6
        ]);
    }

    public function edit_page($id, $title, $title_color, $txt1, $txt2, $marker_color, $txt_color, $file1, $file_txt1, $file2, $file_txt2, $file3, $file_txt3, $file4, $file_txt4, $file5,$file_txt5, $file6, $file_txt6)
    {
        Page::where('page_id', 'like', "$id")
            ->update(['page_title' => $title,
            'page_title_color' => $title_color,
            'page_txt1' => $txt1,
            'page_txt2' => $txt2,
            'page_marker_color' => $marker_color,
            'page_txt_color' => $txt_color,
            'page_file1' => $file1,
            'page_file_txt1' => $file_txt1,
            'page_file2' => $file2,
            'page_file_txt2' => $file_txt2,
            'page_file3' => $file3,
            'page_file_txt3' => $file_txt3,
            'page_file4' => $file4,
            'page_file_txt4' => $file_txt4,
            'page_file5' => $file5,
            'page_file_txt5' => $file_txt5,
            'page_file6' => $file6,
            'page_file_txt6' => $file_txt6
        ]);
    }

    public function delete_data($id)
    {
        Page::where('page_id', 'like', "$id")->delete();
    }
}
