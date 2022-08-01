<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Announcement;
use Auth;
use Str;

class AdminAnnouncementController extends Controller
{

    public function index()
    {

        $this->authorize('Announcements Access');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
            $data = Announcement::get();
            return DataTables::of($data)
            ->addColumn('status', function($data){
                if(Auth::user()->can('Announcements Edit')){
                    if($data->status == '1'){
                        $button = '
                        <label class="custom-switch form-switch mb-0">
                            <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch" checked>
                            <span class="custom-switch-indicator"></span>
                        </label>';
                    }else{
                        $button = '
                            <label class="custom-switch form-switch mb-0">
                                <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch" >
                                <span class="custom-switch-indicator"></span>
                            </label> ';
                    }
                    return $button;
                }else{
                    return '~';
                }
               
              })
            ->addColumn('action', function($data){
                $button = '<div class = "d-flex">';
                if(Auth::user()->can('Announcements Edit')){
        
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';            
                }else{
                    $button .= '~';
                }
                if(Auth::user()->can('Announcements Delete')){
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="delete-testimonial" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                }else{
                    $button .= '~';
                }
                
                $button .= '</div>';
              
                return $button;
            })
            ->addColumn('checkbox', function($data){
                if(Auth::user()->can('Announcements Delete')){
                    return '<input type="checkbox" name="custom_checkbox[]" class="checkall" value="'.$data->id.'" />';
                }else{
                    return '<input type="checkbox" name="custom_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
                }
            })
            ->addColumn('title', function($data){
                return Str::limit($data->title, '40');
            })
            ->rawColumns(['action','status','checkbox','title'])
            ->addIndexColumn()
            ->make(true);
            
        }

        return view('admin.announcement.index')->with($data);
    }

    public function store(Request $request)
    {

        $request->validate([

            'title'=> 'required|max:255',
            'notice' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            
        ]);

        $testiId = $request->testimonial_id;
        $testi =  [
            'title' => $request->title,
            'notice' => $request->notice,
            'startdate' => $request->startdate,
            'enddate' => $request->enddate,
            'status' => $request->status,
        ];

              
        $testimonial = Announcement::updateOrCreate(['id' => $testiId], $testi);
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.announcementupdateorcreate'),'data' => $testimonial], 200);

    }

    public function show($id){

        $post = Announcement::find($id);

        return response()->json($post);
    }


    public function destroy($id){

        $announcement = Announcement::find($id);
        $announcement->delete();
        return response()->json(['error'=> trans('langconvert.functions.announcementdelete')]);

    }

    public function allannouncementdelete(Request $request)
    {

        $id_array = $request->input('id');
    
        $sendmails = Announcement::whereIn('id', $id_array)->get();
    
        foreach($sendmails as $sendmail){
            $sendmail->delete();
           
        }
        return response()->json(['error'=> trans('langconvert.functions.announcementdelete')]);
        
    }

    public function status(Request $request, $id)
    {
        $calID = Announcement::find($id);
        $calID ->status = $request->status;
        $calID ->save();
          
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);

    }
}
