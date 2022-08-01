<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Ticket\Ticket;
use App\Models\Articles\Article;
use App\Models\Articles\Category_articles;
use App\Models\CategoryUser;
use App\Models\User;
use App\Models\Projects;
use App\Models\Groupscategories;
use App\Models\Projects_category;
use Modules\Uhelpupdate\Entities\CategoryEnvato;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','display','status','project_id','categoryslug','priority','parent_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }
    
    public function catagent()
    {
        return $this->belongsToMany(CategoryUser::class);
    }

    public function catagents()
    {
        return $this->hasMany(CategoryUser::class, 'category_id');
    }

    public function user(){
        return $this->hasMany(User::class);
    }

    public function groupscategory()
    {
        return $this->belongsToMany(Groupscategories::class, 'groups_categories','category_id','group_id');
    }

    public function groupscategoryc()
    {
        return $this->hasMany(Groupscategories::class,'category_id');
    }

    public function subcategories(){
        return $this->hasMany(Projects::class, 'project_id');
    }

    public function projectscategory()
    {
        return $this->belongsToMany(Projects_category::class,'projects_categories','projects_id','category_id');
    }
    public function procat()
    {
        return $this->hasMany(Projects_category::class,'category_id');
    }

    public function envato()
    {
        return $this->hasMany(CategoryEnvato::class, 'category_id');

    }

    public function childs()
    {
    	return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
    	return $this->belongsTo(Category::class, 'parent_id');
    }
   
}
