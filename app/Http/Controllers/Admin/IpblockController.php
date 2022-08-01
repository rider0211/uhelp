<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seosetting;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Setting;
use DataTables;
use App\Models\IPLIST;

class IpblockController extends Controller
{
    public function index(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        if(request()->ajax()){
            $iplist = IPLIST::latest()->get();
            return DataTables::of($iplist)
            ->addColumn('action', function($iplist){
                $button = '<div class = "d-flex">';
                if(auth()->user()->can('IpBlock Edit')){
                    $button .= '<a href="javascript:void(0)" data-id="'.$iplist->id.'" class="action-btns1 edit-iplist"><i class="feather feather-edit text-primary" data-id="'.$iplist->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a> ';
                }else{
                    $button .= '~';
                }
                if(auth()->user()->can('IpBlock Delete')){
                    $button .= '<a href="javascript:void(0)" data-id="'.$iplist->id.'" class="action-btns1" id="delete-iplist" ><i class="feather feather-trash-2 text-danger" data-id="'.$iplist->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                }else{
                    $button .= '~';
                }
                if ($iplist->types != 'Unlock') {
                    $button .= '<a href="javascript:void(0)" data-id="'.$iplist->id.'" class="action-btns1" id="reset-iplist" ><i class="feather feather-rotate-ccw text-success" data-id="'.$iplist->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset"></i></a>';
                }
                $button .= '</div>';
                return $button;
              
            })
            ->addColumn('checkbox', function($iplist){
                if(auth()->user()->can('IpBlock Delete')){
                return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$iplist->id.'" />';
                }else{
                    return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$iplist->id.'" disabled/>';
                }
            })
            ->rawColumns(['action','checkbox'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.securitysetting.ipblocklist')->with($data);
    }

    public function show($id){

        $ip = IPLIST::find($id);

        return response()->json($ip);
    }


    public function store(Request $request){

        $request->validate([
            'ip'=> 'required|ip',
            'types' => 'required',
            
        ]);

        $ipId = $request->IP_id;
        $ipdata =  [
            'ip' => $request->ip,
            'types' => $request->types,
                
        ];


     $ipdtaa = IPLIST::updateOrCreate(['id' => $ipId], $ipdata);

     $ipdataupdate = IPLIST::find($ipdtaa->id);
     if($ipdataupdate->entrytype != 'Auto'){
        $ipdataupdate->entrytype = 'Manual';
     }
     $ipdataupdate->update();
     return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.ipupdatecreate'),'data' => $ipdtaa], 200);

    }

    public function destroy($id){

        $ipdelete = IPLIST::find($id);
        $ipdelete->delete();
        return response()->json(['error'=> trans('langconvert.functions.ipdelete')]);
    }


    public function allipblocklistdelete(Request $request){
        $id_array = $request->input('id');
    
        $sendmails = IPLIST::whereIn('id', $id_array)->get();
    
        foreach($sendmails as $sendmail){
            $sendmail->delete();
           
        }
        return response()->json(['error'=> trans('langconvert.functions.ipdelete')]);
    }

    public function resetipblock($id){

        $ipreset = IPLIST::find($id);
        $ipreset->types = 'Unlock';
        $ipreset->update();
        return response()->json(['success'=> trans('langconvert.functions.updatecommon')]);

    }

}