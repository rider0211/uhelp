<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Ticket\Category;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\SocialAuthSetting;
use App\Models\Articles\Article;

class CategorypageController extends Controller
{
    public function index($id){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $categoryss = Category::where('categoryslug', $id)->first();
        if($categoryss == null)
        {
            $category = Category::find($id);
            $data['category'] = $category;

            $categorys = Category::where('id',$id)->with('articles')->paginate(5);
            $data['categorys'] = $categorys;
        }
        if($categoryss != null)
        {
            $category = Category::where('categoryslug', $id)->first();
            $data['category'] = $category;

            $categorys = Category::where('categoryslug',$id)->with('articles')->paginate(5);
            $data['categorys'] = $categorys;
        }

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        $populararticle = Article::where('status', 'published')->orderBy('views','desc')->latest()->paginate(5);
        $data['populararticles'] = $populararticle;

        $article = Article::where('status', 'published')->latest('created_at')->paginate(5);
        $data['recentarticles'] = $article;

        return view('categorypage')->with($data);
    }
}
