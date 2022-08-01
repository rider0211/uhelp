<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Seosetting;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Pages;

class SeopageController extends Controller
{
	public function index()
	{

	  $this->authorize('SEO Access');

		$title = Apptitle::first();
		$data['title'] = $title;

		$footertext = Footertext::first();
		$data['footertext'] = $footertext;

		$seopage = Seosetting::first();
		$data['seopage'] = $seopage;

		$post = Pages::all();
		$data['page'] = $post;

		return view('admin.seopage.index')->with($data);
	}

	public function store(Request $request){

		$request->validate([
			'author'=> 'required|max:255',
			'description' => 'required|max:255',
			'keywords' => 'required',
			
		  ]);

		  $boxID = ['id' => $request->seo_id];
		  $boxdetails = [
			'author' => $request->author,
			'description' => $request->description,
			'keywords' => $request->keywords,
		  ];

		  $feature = Seosetting::updateOrCreate(
			['id' => $boxID], $boxdetails);

		return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
	}
}
