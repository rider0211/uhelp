<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\Ticket\Category;
use App\Models\Role;
use App\Models\ArticleComment;
use App\Models\Articles\article_likes;
use App\Models\Articles\Category_articles;
use App\Models\Subcategory;


class Article extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;



    protected $fillable = [
        'category_id', 'title', 'message', 'status', 'featureimage','views','tags',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cat()
    {
        return $this->belongsTo(Category_articles::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function articlecomments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function article_likes()
    {
        return $this->hasMany(article_likes::class);
    }
    
    public function article_like()
    {
        return $this->hasMany(article_likes::class, 'rating');
    }
   
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('article');
            //add option
    }

    public function subcategorys()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory', 'id');
    }
}
