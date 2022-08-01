<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ArticleReplies;
use Auth;

class ArticleReplyController extends Controller
{
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, ['message' => 'required|max:1000']);
        $commentReply = new ArticleReplies();
        $commentReply->article_comment_id = $id;
        $commentReply->user_id = Auth::id();
        $commentReply->message = $request->message;
        $commentReply->save();
    
        return redirect()->back();

    }
}
