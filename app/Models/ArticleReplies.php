<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ArticleComment;

class ArticleReplies extends Model
{
    use HasFactory;

    protected $fillable = [

        'article_comment_id','user_id','message',

    ];


    public function articlecomments(){
        return $this->belongsTo(ArticleComment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
