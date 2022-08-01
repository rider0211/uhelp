<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ArticleComment;
use Auth;

use App\Models\Ticket\Category;
use App\Models\Articles\Article;

use App\Models\User;
use App\Models\Role;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\SocialAuthSetting;
use Saptie\MediaLibrary\Support\MediaStream;


class ArticleCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $article = Article::where('status', 'published')->latest('created_at')->paginate(5);
        $data['article'] = $article;

        $populararticle = Article::where('status', 'published')->paginate(5)->sortByDesc('views');
        $data['populararticle'] = $populararticle;

        $articlecomments = ArticleComment::latest('created_at')->get();
        $data['articlecomment'] = $articlecomments;

        $category = Category::paginate();
        $data['category'] = $category;

        $categorys = Category::with('articles')->paginate();
        $data['categorys'] = $categorys;


        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        return view ('knowledge')-> with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (Auth::check()) {

            $this->validate($request, [
                'comment' => 'required',
                
            ]);

            $articlecomments = new ArticleComment();
            $articlecomments->article_id = $id;
            $articlecomments->user_id = Auth::user()->id;
            $articlecomments->comment = $request->comment;
            $articlecomments->save();
                     
            return redirect()->back()->with('success','Comment Added successfully..!');
        }
    }
    
}
