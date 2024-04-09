<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryPage extends Model
{
    use HasFactory;
    protected $table = 'diary_pages';
    protected $fillable = [  
        'diary_id',  
        'page_id'
    ];

    public function search_diary($id)
    {
        $data = DiaryPage::where('diary_id', 'like', "$id")->get(['diary_id', 'page_id']);
        return $data;
    }

    public function search_page($id)
    {
        $data = DiaryPage::where('page_id', 'like', "$id")->get(['diary_id', 'page_id']);
        return $data;
    }

    public function add_data($diary_id, $page_id)
    {
        DiaryPage::create([
            'diary_id' => $diary_id,
            'page_id' => $page_id
        ]);
    }
}
