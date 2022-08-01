<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FAQ;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use DataTables;
use Auth;
use Illuminate\Support\Str;

class FAQController extends Controller
{
    public function index()
	{

     	$this->authorize('FAQs Access');
        $faq = FAQ::get();
        $data['faqs'] = $faq;

        $basic = Apptitle::first();
        $data['basic'] = $basic;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
          $data = FAQ::get();
          return DataTables::of($data)
          	->addColumn('action', function($data){
              $button = '<div class = "d-flex">';
				if(Auth::user()->can('FAQs Edit')){
		
					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" onclick="editPost(event.target)" class="action-btns1">
					<i class="feather feather-edit text-primary" data-id="'.$data->id.' " data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i>
					</a>';            
				}else{
					$button .= '~';
				}
				if(Auth::user()->can('FAQs Delete')){
					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1"  onclick="deletePost(event.target)">
					<i class="feather feather-trash-2 text-danger" data-id="'.$data->id.' " data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>
					</a>';
				}else{
					$button .= '~';
				}
			
				$button .= '</div>';
				
				return $button;
        	})
			->addColumn('checkbox', function($data){
				if(Auth::user()->can('FAQs Delete')){
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" />';
				}else{
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
				}
			})
          	->addColumn('answer', function($data){
            	return Str::limit($data->answer, '50');
          	})
			  ->addColumn('question', function($data){
            	return Str::limit($data->question, '50');
          	})
			->addColumn('status', function($data){
                if(Auth::user()->can('FAQs Edit')){
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
            ->addColumn('privatemode', function($data){
                if(Auth::user()->can('FAQs Edit')){
                    if($data->privatemode == '1'){
                        return '
                        <label class="custom-switch form-switch mb-0">
                            <input type="checkbox" name="privatemode" data-id="'.$data->id.'" id="privatemode'.$data->id.'" value="1" class="custom-switch-input tswitch1" checked>
                            <span class="custom-switch-indicator"></span>
                        </label>';
                    }else{
                        return '
                        <label class="custom-switch form-switch mb-0">
                            <input type="checkbox" name="privatemode" data-id="'.$data->id.'" id="privatemode'.$data->id.'" value="1" class="custom-switch-input tswitch1">
                            <span class="custom-switch-indicator"></span>
                        </label>';
                    }
                }else{
                    return '~';
                }
            })
            ->rawColumns(['action','checkbox','answer','question', 'status', 'privatemode'])
            ->addIndexColumn()
            ->make(true);
          
      	}

        return view('admin.faq.index')->with($data)->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function store(Request $request)
  	{
      $request->validate([
        'question'=> 'required|max:255',
        'answer' => 'required',
        
      ]);
      $faq = FAQ::updateOrCreate( ['id' => $request->id], ['question' => $request->question,'answer' => $request->answer, 'privatemode' => $request->privatemode , 'status' => $request->status ]);

      return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.faqupdatecreate'),'data' => $faq], 200);

  	}

	public function show($id)
	{
		$this->authorize('FAQs Edit');
		$post = FAQ::find($id);

		return response()->json($post);
	}

	public function destroy($id)
	{
		$this->authorize('FAQs Delete');
		$faq = FAQ::find($id);
		$faq->delete();

		return response()->json(['error'=>trans('langconvert.functions.faqdelete')]);
	}


	public function allfaqdelete(Request $request)
	{
		$id_array = $request->input('id');

		$sendmails = FAQ::whereIn('id', $id_array)->get();

		foreach($sendmails as $sendmail){
			$sendmail->delete();
		
		}
		return response()->json(['error'=> trans('langconvert.functions.faqdelete')]);
		
	}

	public function faq(Request $request)
	{
		$request->validate([
			'faqtitle'=> 'required|max:255',
		]);

		if($request->faqsub){
			$request->validate([
				'faqsub' => 'max:255'
			]);
		}
		$calID = ['id' => $request->id];
		$calldetails = [

			'faqtitle'  => $request->faqtitle,
			'faqsub'    => $request->faqsub,
			'faqcheck'  => $request->has('faqcheck') ? 'on' : 'off',
		
		];

		$callaction = Apptitle::updateOrCreate(
		['id' => $calID], $calldetails);


		return redirect()->back()->with('success' , trans('langconvert.functions.updatecommon'));
	}

	public function status(Request $request, $id)
    {
        $calID = FAQ::find($id);
        $calID->status = $request->status;
        $calID->save();
          
        return response()->json(['code'=>200, 'success'=>trans('langconvert.functions.updatecommon')], 200);

    }

    public function privatestatus(Request $request, $id)
    {   
        $calID = FAQ::find($id);
        $calID->privatemode = $request->privatemode;

        $calID->save();
          
        return response()->json(['code'=>200, 'success'=>trans('langconvert.functions.updatecommon')], 200);

    }

}
