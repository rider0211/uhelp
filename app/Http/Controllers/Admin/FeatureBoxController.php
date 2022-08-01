<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FeatureBox;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Validator;
use Response;
use File;

class FeatureBoxController extends Controller
{
    public function index()
	{

      $this->authorize('Feature Box Access');
        $feature = FeatureBox::get();
        $basic = Apptitle::first();

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
			$data = FeatureBox::latest()->get();
			return DataTables::of($data)
			->addColumn('subtitle', function (FeatureBox $user) {
				return $user->subtitle ? str_limit($user->subtitle, 40, '...') : '';
			})
			->addColumn('title', function (FeatureBox $user) {
				return $user->title ? str_limit($user->title, 40, '...') : '';
			})
			->addColumn('action', function($data){
				$button = '<div class = "d-flex">';
				if(Auth::user()->can('Feature Box Edit')){

					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
				}else{
					$button .= '~';
				}
				if(Auth::user()->can('Feature Box Delete')){
					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="delete-testimonial" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
				}else{
					$button .= '~';
				}
				
				$button .= '</div>';
				return $button;
			})
			->addColumn('checkbox', function($data){
				if(Auth::user()->can('Feature Box Delete')){
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" />';
				}else{
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
				}
			})
			->rawColumns(['action','checkbox'])
			->addIndexColumn()
			->make(true);
          
      	}
        return view('admin.featurebox.index', compact('feature','basic','title','footertext'))->with($data);
    }

    public function show($id)
    {
      $this->authorize('Feature Box Edit');
        $post = FeatureBox::find($id);
  
        return response()->json($post);
    }

    public function store(Request $request)
    {

		$validator = Validator::make($request->all(), [
            'title'=> 'required|string|max:255',
			'subtitle' => 'required|string|max:255',
        ]);
		

		if ($files = $request->file('image')) {

			$validator = Validator::make($request->all(), [
				'image' => 'required|mimes:jpg,jpeg,png,svg|max:10240',
			]);
		}
		
       
		if($validator->passes()){

		
        	$boxID = ['id' => $request->featurebox_id];
			$boxdetails = [
				'title' => $request->title,
				'subtitle' => $request->subtitle,
			];

          	if ($files = $request->file('image')) {
				$files = $request->file('image');
				
				if($request->featurebox_id){
					$testiimage = FeatureBox::find($request->featurebox_id);
					$imagepath =   'public/uploads/featurebox/'. $testiimage->image;
					if(\File::exists($imagepath)){
						\File::delete($imagepath);
					}
				}	
					
				//insert new file
				$destinationPath = 'public/uploads/featurebox/'; // upload path
				$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
				$files->move($destinationPath, $profileImage);
				$boxdetails['image'] = $profileImage;
           	}

          	$feature = FeatureBox::updateOrCreate(['id' => $boxID], $boxdetails);

        	return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.featureboxcreateupdate'),'data' => $feature], 200);
		}else{
			return Response::json(['errors' => $validator->errors()]);
		}

    }

    public function destroy($id)
    {
      $this->authorize('Feature Box Delete');
      $data = FeatureBox::where('id',$id)->first(['image']);
      \File::delete('public/uploads/feature-box/'.$data->image);
      $testimonial = FeatureBox::find($id);
      $testimonial->delete();
  
      return response()->json(['error'=> trans('langconvert.functions.featureboxdelete')]);
    }

    public function allfeaturedelete(Request $request){
      $id_array = $request->input('id');
  
      $sendmails = FeatureBox::whereIn('id', $id_array)->get();
  
      foreach($sendmails as $sendmail){
        \File::delete('public/uploads/feature/'.$sendmail->image);
          $sendmail->delete();
         
      }
      return response()->json(['error'=> trans('langconvert.functions.featureboxdelete')]);
      
  }

    public function feature(Request $request){
      	$request->validate([
            'featuretitle'=> 'required|string|max:255',
		]);

		if($request->featuresub){
			$request->validate([
				'featuresub'=> 'string|max:255',   
			]);
		}

          $calID = ['id' => $request->id];
          $calldetails = [
            'featuretitle' => $request->featuretitle,
            'featuresub' => $request->featuresub,
            'featurecheck' => $request->has('featurecheck') ? 'on' : 'off',
            
          ];
          $callaction = Apptitle::updateOrCreate(
            ['id' => $calID], $calldetails);
  
  
        return redirect()->back()->with('success' , trans('langconvert.functions.updatecommon'));
    }
}
