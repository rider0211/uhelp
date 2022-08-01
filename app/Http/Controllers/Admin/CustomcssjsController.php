<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customcssjs;
use App\Models\Setting;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;

class CustomcssjsController extends Controller
{
    public function index()
    {
        $this->authorize('Custom JS & CSS Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.generalsetting.customcssjs')->with($data);
    }

    /**
     * Frontend Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function customcssjs(Request $request)
    {

        $data = $request->only(['customcss', 'customjs']);

        $this->updateSettings($data);
        
        return back()->with('success', trans('langconvert.functions.updatecommon'));
    }


    public function customchat(){
        $this->authorize('Custom Chat Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.generalsetting.customchat')->with($data);
    }
    /**
     * Frontend Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function customchats(Request $request)
    {

        $data = $request->only(['customchat']);
        $data['CUSTOMCHATENABLE']  =  $request->has('CUSTOMCHATENABLE') ? 'enable' : 'disable';
        $data['CUSTOMCHATUSER']  =  $request->CUSTOMCHATUSER;

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

        foreach($data as $name => $val){
        	$setting = Customcssjs::where('name', $name);
        	if( $setting->exists() )
        		$setting->first()->update(['value' => $val]);
        }

    }
}
