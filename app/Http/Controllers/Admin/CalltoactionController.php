<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\callaction;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;

class CalltoactionController extends Controller
{
    public function index()
    {
        
        $this->authorize('Call To Action Access');

        $callaction = callaction::first();

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
        

        return view('admin.callaction.index', compact('callaction','title','footertext'))->with($data);
    }

    public function store(Request $request)
    {
        $this->authorize('Call To Action Access');

        $request->validate([
            'title' => 'required|string|max:255',
            'buttonname' => 'required|string|max:255',
            'buttonurl' => 'required|string|max:255',
            
        ]);
        if($request->subtitle){
            $request->validate([
            'subtitle' => 'max:255'
            ]);
        }
        if($request->file('image')){
            $request->validate([
                'image' => 'required|mimes:jpg,jpeg,png,svg|max:10240',
                
            ]);
        }
        $calID = ['id' => $request->id];
        $calldetails = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'buttonname' => $request->buttonname,
            'buttonurl' => $request->buttonurl,
            'callcheck'  => $request->has('callcheck') ? 'on' : 'off',
        ];
        $callimage = callaction::find($request->id);
        $imagepath =   'public/uploads/callaction/'. $callimage->image;
        if(\File::exists($imagepath)){
            \File::delete($imagepath);
        }
        

        if ($files = $request->file('image')) {

            //insert new file
            $destinationPath = 'public/uploads/callaction/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $calldetails['image'] = "$profileImage";
        }

        $callaction = callaction::updateOrCreate(['id' => $calID], $calldetails);
        
        return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
    }
}
