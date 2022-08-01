<?php

namespace Modules\Uhelpupdate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller;
use Nwidart\Modules\Routing\Controller;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use Modules\Uhelpupdate\Entities\Cannedmessages;
use DataTables;
use Auth;


class CannedmessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('Canned Response Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()){

            $data = Cannedmessages::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function($data){
            	$button = '<div class = "d-flex">';
				if(Auth::user()->can('Canned Response Edit')){
		
					$button .= '<a href="'.route('admin.cannedmessages.edit',$data->id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
				}else{
				    $button .= '~';
				}
				if(Auth::user()->can('Canned Response Delete')){
					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="delete-cannedmessages" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
				}else{
				    $button .= '~';
				}
           	 	$button .= '</div>';
            	return $button;
          	})
			->addColumn('checkbox', function($data){
				if(Auth::user()->can('Canned Response Delete')){
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" />';
				}else{
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
				}
			})
            ->addColumn('status', function($data){
                if(Auth::user()->can('Canned Response Edit')){
                    if($data->status == '1'){
                        return '
                        <label class="custom-switch form-switch mb-0">
                            <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch" checked>
                            <span class="custom-switch-indicator"></span>
                        </label>';
                    }else{
                        return '
                        <label class="custom-switch form-switch mb-0">
                            <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch">
                            <span class="custom-switch-indicator"></span>
                        </label>';
                    }
                }else{
                    return '~';
                }
            })
            ->rawColumns(['action','checkbox', 'status'])
            ->addIndexColumn()
            ->make(true);

        };

        return view('uhelpupdate::cannedmessages.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->authorize('Canned Response Create');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('uhelpupdate::cannedmessages.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([

            'title'=> 'required|max:255',
            'message' => 'required',
            
        ]);

        Cannedmessages::create([
            'title' => $request->title,
            'messages' => $request->message,
            'status' => $request->statuscanned ? 1 : 0,
        ]);
        return redirect()->route('admin.cannedmessages')->with('success', trans('langconvert.functions.updatecommon'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        

        return view('uhelpupdate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('Canned Response Edit');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $cannedmessages = Cannedmessages::findOrFail($id);
        $data['cannedmessage'] = $cannedmessages;

        return view('uhelpupdate::cannedmessages.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $cannedmessages = Cannedmessages::findOrFail($id);
        $cannedmessages->title = $request->title;
        $cannedmessages->messages = $request->message;
        $cannedmessages->status = $request->statuscanned ? 1 : 0;
        $cannedmessages->update();

       return redirect()->route('admin.cannedmessages')->with('success', trans('langconvert.functions.updatecommon'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->authorize('Canned Response Delete');
        $cannedmessages = Cannedmessages::findOrFail($id);
        $cannedmessages->delete();
        return response()->json(['error'=> trans('langconvert.functions.cannedmessagedelete')]);
    }

    /// Status changing method
    public function status(Request $request)
    {
        $cannedmessages = Cannedmessages::findOrFail($request->id);
        $cannedmessages->status = $request->status;
        $cannedmessages->update();
        return response()->json(['code'=>200, 'success'=>trans('langconvert.functions.updatecommon')], 200);
    }

    // Delete Selected Canned Messages
    public function destroyall(Request $request)
    {
        $id_array = $request->input('id');
        $cannedmessages = Cannedmessages::findOrFail($id_array);
        foreach($cannedmessages as $cannedmessage){

            $cannedmessage->delete();
        }
        return response()->json(['error'=> trans('langconvert.functions.cannedmessagedelete')]);
    }
}
