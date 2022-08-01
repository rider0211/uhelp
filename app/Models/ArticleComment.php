<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ArticleReplies;
use App\Models\Articles\Article;

class ArticleComment extends Model
{
    use HasFactory;

    protected $fillable = array(
        
        'article_id',
        'comment',
        'user_id'
        
    );

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function articlereplies(){
       
        return $this->hasMany(ArticleReplies::class)->latest('created_at');
    }

    public function articles()
    {
        return $this->belongsTo(Article::class);
    }
}
