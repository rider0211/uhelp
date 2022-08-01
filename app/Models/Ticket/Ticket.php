<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\Comment;
use App\Models\Ticket\Category;
use App\Models\Customer;
use App\Models\User;
use App\Models\Role;
use App\Models\CategoryUser;
use App\Models\Ticketnote;
use App\Models\Subcategorychild;
use App\Models\Subcategory;


class Ticket extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table ="tickets";
    protected $fillable = [
        'cust_id', 'category_id', 'image', 'ticket_id', 'title', 'priority', 'message', 'status','subject','user_id','project_id','auto_close_ticket',
        'project', 'purchasecode', 'purchasecodesupport','subcategory'
    ];

    protected $dates = [
        'closing_ticket',
        'last_reply',
        'craeted_at',
        'updated_at',
        'auto_replystatus'
    ];

    public function cust()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function toassignuser()
    {
        return $this->belongsTo(User::class, 'toassignuser_id');
    }
    public function myassignuser()
    {
        return $this->belongsTo(User::class, 'myassignuser_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest('created_at');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function role()
    {
        return $this->hasMany(Role::class);
    }

    public function product()
    {
        return $this->hasMany(CategoryUser::class, 'category_id');
    }

    public function ticketnote(){
        return $this->hasmany(Ticketnote::class, 'ticket_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ticket');
            //add option
    }
    public function subcategories()
    {
    	return $this->belongsTo(Subcategorychild::class, 'subcategory', 'subcategory_id');
    }

    public function subcategoriess()
    {
    	return $this->belongsTo(Subcategory::class, 'subcategory', 'id');
    }

}
