<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\customizeerror;

class CustomerrorpagesController extends Controller
{
    public function index()
    {
        
        $this->authorize('404 Error Page Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.errorpages.error404')->with($data);
    }

    public function store(Request $request)
    {
        $this->authorize('404 Error Page Access');
        $request->validate([
			'404title'=> 'required|max:10000',
			
		]);
        if($request->input('404subtitle')){
            $request->validate([
                '404subtitle'=> 'max:10000',
                
            ]);
        }
        $data = $request->only(['404subtitle', '404title']);
        
        $this->updateSettings($data);
        
        return back()->with('success', trans('langconvert.functions.updatecommon'));
    }

    public function maintenancepage()
    {
        $this->authorize('Under Maintanance Page Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.errorpages.undermaintenance')->with($data);
    }

    public function maintenancepagestore(Request $request)
    {
        $this->authorize('Under Maintanance Page Access');
        $request->validate([
			'503title'=> 'required|max:10000',
			'503subtitle'=> 'required|max:10000',
			
		]);
        if($request->input('503description')){
            $request->validate([
                '503description'=> 'max:10000',
                
            ]);
        }
        $data = $request->only(['503subtitle', '503title','503description']);
        
        $this->updateSettings($data);
        
        return back()->with('success', trans('langconvert.functions.updatecommon'));
    }

     /**
     *  Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    private function updateSettings($data)
    {

        foreach($data as $errorname => $errorvalue){
        	$setting = customizeerror::where('errorname', $errorname);
        	if( $setting->exists() )
        		$setting->first()->update(['errorvalue' => $errorvalue]);
        }

    }
}
