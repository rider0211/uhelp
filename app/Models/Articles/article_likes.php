<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Articles\Article;

class article_likes extends Model
{
    use HasFactory;

protected $table = 'articles_likes';
    protected $fillable = array(
        
        'article_id',
        'user_id',
        'rating'
        
    );

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
