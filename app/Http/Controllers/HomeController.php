<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Ticket\Category;
use App\Models\Articles\Article;

use App\Models\User;
use App\Models\Role;
use App\Models\ArticleComment;
use App\Models\Articles\article_likes;
use App\Models\Articles\article_dislikes;
use App\Models\FAQ;
use App\Models\Testimonial;
use App\Models\callaction;
use App\Models\FeatureBox;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Announcement;
use App\Models\SocialAuthSetting;
use Cookie;
use Session;
use Storage;
use Carbon;
use Str;

class HomeController extends Controller
{

 
    
    public function index()
    {
        if (setting('defaultlogin_on') == 'on'){
            return redirect()->route('auth.login');
        }
        $articlecomments = ArticleComment::latest('created_at')->get();
        $data['articlecomments'] = $articlecomments;
        
        $categorys = Category::with('articles')->paginate();
        $data['categorys'] = $categorys;

        $faq = FAQ::where('status', '1')->latest()->paginate(5);
        $data['faq'] = $faq;

        $article = Article::where('status', 'published')->latest('created_at')->paginate(5);
        $data['article'] = $article;

        $populararticle = Article::where('status', 'published')->paginate(5)->sortByDesc('views');
        $data['populararticle'] = $populararticle;

        $testimonial = Testimonial::get();
        $data['testimonial'] = $testimonial;

        $call = callaction::first();
        $data['call'] = $call;

        $feature = FeatureBox::get();
        $data['feature'] = $feature;

        $title = Apptitle::first();
        $data['title'] = $title;
        
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
        
        $now = now();
        $announcement = announcement::whereDate('enddate', '>=', $now->toDateString())->whereDate('startdate', '<=', $now->toDateString())->get();
        $data['announcement'] = $announcement;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        return view ('home')-> with($data);
        

    }
    


    public function knowledge($id){
       
        $articleslug = Article::where('articleslug', $id)->first();
        if($articleslug != null){

            $article = Article::where('articleslug', $id)->firstOrFail();
            $data['articles'] = $article;

            $like_post = Article::where('articleslug', $id)->firstOrFail();
            $like = article_likes::where('rating', '1')->where(['article_id'=>$like_post->id])->paginate();
            $data['like'] = $like;

            $dislike = article_likes::where('rating', '-1')->where(['article_id'=>$like_post->id])->paginate();
            $data['dislike'] = $dislike;

            if(Auth::guard('customer')->check()){
                $viewrating = article_likes::where('user_id', Auth::guard('customer')->user()->id)->where(['article_id'=>$like_post->id])->first();
                $data['viewrating'] = $viewrating;
            }
        }
        if($articleslug == null){

            $article = Article::where('id', $id)->firstOrFail();
            $data['articles'] = $article;

            $like_post = Article::find($id);
            $like = article_likes::where('rating', '1')->where(['article_id'=>$like_post->id])->paginate();
            $data['like'] = $like;

            $dislike = article_likes::where('rating', '-1')->where(['article_id'=>$like_post->id])->paginate();
            $data['dislike'] = $dislike;

            if(Auth::guard('customer')->check()){
                $viewrating = article_likes::where('user_id', Auth::guard('customer')->user()->id)->where(['article_id'=>$like_post->id])->first();
                $data['viewrating'] = $viewrating;
            }
            
        }

        $articleKey = 'articles_'.$article->id;
        if(!Session::has($articleKey)){
            $article->increment('views');
            Session::put($articleKey, 1);
        }

        $articlecomment = ArticleComment::latest('created_at')->get();
        $data['articlecomment'] = $articlecomment;

        $category = Category::whereIn('display', ['knowledge', 'both'])->paginate(5);
        $data['category'] = $category;

        $categorys = Category::with('articles')->paginate(5);
        $data['categorys'] = $categorys;
        

        $recentarticles = Article::latest()->paginate(5);
        $data['recentarticles'] = $recentarticles;

        $populararticle = Article::orderBy('views','desc')->latest()->paginate(5);
        $data['populararticles'] = $populararticle;

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

        return view('knowledge-view')-> with($data);
        
    }

    public function searchlist(Request $request){
        
        $article = Article::latest('created_at')->paginate(5);
        $data['articles'] = $article;

    
        if($request->get('data'))
        {

            $keyword = $request->get('data');
            $data = Article::select("title","message","tags",'id','category_id','articleslug', 'status')
            ->where('status', 'published')
            ->where('title','LIKE', "%{$keyword}%")
            ->orWhere('tags','LIKE','%'.$keyword.'%')
            ->orWhere('message','LIKE','%'.$keyword.'%')->orderby('title','asc')
            ->get();
            
            $output = '<ul class="dropdown-menu sprukohomesearch ">';
            if($data->isNotEmpty()){
                
                foreach ($data as $row) {
                    if($row->status == 'Published')
                    if($row->articleslug != null){
                        $output .= '<li><a href="'
                        .url('/article/'.$row->articleslug).
                        
                        '" class=""  style="color:black;">' . Str::limit($row->title, '60') . '<span class="badge bg-success-transparent text-success float-end fs-11">'.Str::limit($row->category->name, '20').'</span></a>
                        </li>';
                    }else{
                        $output .= '<li><a href="'
                        .url('/article/'.$row->id).
                        
                        '" class=""  style="color:black;">' . Str::limit($row->title, '60') . '<span class="badge bg-success-transparent text-success float-end fs-11">'.Str::limit($row->category->name, '20').'</span></a>
                        </li>';
                    }
                   
                }

            }else{
                $output .= '<li><a href="#" class=""  style="color:black;"> No Data Found </a></li>';
            }
        }
            $output .= '</ul>';
           
            return response()->json($output);

    }

    public function likedislike(Request $request, $id){

        switch($request->input('likedislike')){

            case 'like';
            $user_id = Auth::user()->id;
            $like_user = article_likes::where(
            ['user_id'=>$user_id,
            'article_id' => $id]
            )->first();

            if(empty($like_user->user_id)){
                $user_id = Auth::user()->id;
                $article_id = $id;
                $rating = 1;
                $likes = new article_likes();
                $likes->user_id = $user_id;
                $likes->article_id = $article_id;
                $likes->rating = $rating;
                $likes->save();

                return redirect()->back();
            }else{

                return redirect()->back();
            }
            break;
            case 'dislike';

            $user_id = Auth::user()->id;
            $like_user = article_likes::where(['user_id'=>$user_id,'article_id' => $id])->first();

        if(empty($like_user->user_id)){
            $user_id = Auth::user()->id;
            $article_id = $id;
            $rating = -1;

            $likes = new article_likes();
            $likes->user_id = $user_id;
            $likes->article_id = $article_id;
            $likes->rating = $rating;
            $likes->save();

            return redirect()->back();
        }else{
            return redirect()->back();
        }

            break;
        }
    }
        
         public function like($id)
        {
            $user_id = Auth::user()->id;
            $like_user = article_likes::where(
                ['user_id'=>$user_id,
                'article_id' => $id]
            )->first();

            if(empty($like_user->user_id)){
                $user_id = Auth::user()->id;
                $article_id = $id;
                $rating = 1;

                $likes = new article_likes();
                $likes->user_id = $user_id;
                $likes->article_id = $article_id;
                $likes->rating = $rating;
                $likes->save();


                return redirect()->back();
            }else{
                return redirect()->back();
            }
        }

        public function dislike($id){

            $user_id = Auth::user()->id;
                $like_user = article_likes::where(
                ['user_id'=>$user_id,
                'article_id' => $id]
            )->first();

            if(empty($like_user->user_id)){
                $user_id = Auth::user()->id;
                $article_id = $id;
                $rating = -1;

                $likes = new article_likes();
                $likes->user_id = $user_id;
                $likes->article_id = $article_id;
                $likes->rating = $rating;
                $likes->save();

                return redirect()->back();
            }else{
                return redirect()->back();
            }
        }

        public function faqpage(){

            $faq = FAQ::where('status', '1')->latest()->get();
            $data['faq'] = $faq;

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
            

            return view('faqpage')-> with($data);
        }

        public function frontshow($pageslug)
    {
        $title = Apptitle::first();
        $data['title'] = $title;
  
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;
  
        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $page = Pages::where('pageslug', $pageslug)->first();
        $data['pages'] = $page;

        $post = Pages::all();
        $data['page'] = $post;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        return view('generalspage.index')->with($data);
    }

    public function captchareload(){
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function setLanguage($locale)
    {
      
        \App::setlocale($locale);        
        session()->put('locale', $locale);
        return redirect()->back()->with('success', trans('langconvert.functions.languageupdate'));
    }

    public function suggestarticle(Request $request)
    {
        
        $article = Article::latest('created_at')->paginate(5);
        $data['articles'] = $article;

    
        if($request->get('data')){
            // $keyword = $request->title;
            $keyword = $request->get('data');
            $data = Article::where('title','LIKE', "%{$keyword}%")
            ->orWhere('tags','LIKE','%'.$keyword.'%')
            ->orWhere('message','LIKE','%'.$keyword.'%')->orderby('title','asc')->paginate(10);
            
            // $data = preg_replace("/($keyword )/i", "<b></b>", $data);
            $output = '<div class="card sprukocard wow shake" data-wow-duration="1500ms">
                    <div class="card-header border-0">
                        <h4 class="card-title">Suggested Articles</h4>
                    </div>
                    <div class= "card-body">
                        <div class="list-catergory">
                        <ul class="item-list item-list-scroll mb-0 custom-ul">
                ';
            if($data->isNotEmpty()){
                
                foreach ($data as $row) {
                    $output .= '<li class="item mb-4 position-relative">';
                    
                    if($row->articleslug != null){
                        $output .= '<a href="'.url('/article/' . $row->articleslug).'" class=" admintickets"></a>';
                    }
                    if($row->articleslug == null){
                        $output .= ' <a href="'.url('/article/' . $row->id).'" class=" admintickets"></a>';
                    }

                    $output .= '
                        <div class="d-flex">
                            <div class="me-7">
                                <i class="typcn typcn-document-text item-list-icon"></i>
                            </div>
                            <div class="">
                                <span class="">'.Str::limit($row->title, '40').'</span>
                            </div>
                            <div class="ms-auto">
                                    <span class="badge badge-light badge-md fs-10">
                                        <i class="fa fa-eye me-1"></i>'.$row->views.'</span>
                            </div>
                        </div>
                    </li>';
                }

            }else{
                $output .= '<li class="item mb-4 position-relative">
                    <div class="d-flex">
                        <div class="me-7">
                            <i class="typcn typcn-document-text item-list-icon"></i>
                        </div>
                        <div class="">
                            <span class="">No Suggested Articles</span>
                        </div>
                    </div>
                </li>';
            }
        }
        $output .= '</ul>
                </div>
            </div>
        </div>';
           
        return response()->json($output);

    }
}