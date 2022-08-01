<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;
use DataTables;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use Auth;
use Str;

class TestimonialController extends Controller
{
    public function index()
	{
      	$this->authorize('Testimonial Access');
        if(request()->ajax()) {
          $data = Testimonial::latest()->get();
          return DataTables::of($data)
          	->addColumn('action', function($data){
            	$button = '<div class = "d-flex">';
				if(Auth::user()->can('Testimonial Edit')){
		
					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
				}else{
				    $button .= '~';
				}
				if(Auth::user()->can('Testimonial Delete')){
					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="delete-testimonial" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
				}else{
				    $button .= '~';
				}
           	 	$button .= '</div>';
            	return $button;
          	})
			->addColumn('checkbox', function($data){
				if(Auth::user()->can('Testimonial Delete')){
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" />';
				}else{
					return '<input type="checkbox" name="spruko_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
				}
			})
            ->addColumn('name', function($data){
                return Str::limit($data->name, '40');
            })
            ->addColumn('designation', function($data){
                return Str::limit($data->designation, '40');
            })
            ->rawColumns(['action','checkbox','name','designation'])
            ->addIndexColumn()
            ->make(true);
          
      	}
		$basic = Apptitle::first();

		$title = Apptitle::first();
		$data['title'] = $title;

		$footertext = Footertext::first();
		$data['footertext'] = $footertext;

		$seopage = Seosetting::first();
		$data['seopage'] = $seopage;

		$post = Pages::all();
		$data['page'] = $post;
    

      	return view('admin.testimonial.index',compact('basic','title','footertext'))->with($data)->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:255',
            'designation' => 'required|max:255',
            'description' => 'required',
            
        ]);
        if ($files = $request->file('image')) {

            $this->validate($request, [
                'image' => 'required|mimes:jpg,jpeg,png,svg|max:10240',
            ]);
        }

        $testiId = $request->testimonial_id;
        $testi =  [
            'name' => $request->name,
            'designation' => $request->designation,
            'description' => $request->description,
        ];
        if ($files = $request->file('image')) {
            
            if($request->testimonial_id){
                //delete old file
                $testiimage = Testimonial::find($request->testimonial_id);
                $imagepath =   'public/uploads/testimonial/'. $testiimage->image;
                if(\File::exists($imagepath)){
                    \File::delete($imagepath);
                }
            }
        
            //insert new file
            $destinationPath = 'public/uploads/testimonial/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $testi['image'] = "$profileImage";
        }
               
        $testimonial = Testimonial::updateOrCreate(['id' => $testiId], $testi);
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.testimonialcreateupdate'),'data' => $testimonial], 200);

    }

    public function show($id)
    {
        $this->authorize('Testimonial Edit');
        $post = Testimonial::find($id);

        return response()->json($post);
    }

    public function destroy($id)
    {
        $this->authorize('Testimonial Delete');
        $data = Testimonial::where('id',$id)->first(['image']);
        \File::delete('public/uploads/testimonial/'.$data->image);
        $testimonial = Testimonial::find($id);
        $testimonial->delete();

        return response()->json(['error'=> trans('langconvert.functions.testimonialdelete')]);
    }


    public function alltestimonialdelete(Request $request)
    {
        $id_array = $request->input('id');

        $sendmails = Testimonial::whereIn('id', $id_array)->get();

        foreach($sendmails as $sendmail){
        \File::delete('public/uploads/testimonial/'.$sendmail->image);
            $sendmail->delete();
        
        }
        return response()->json(['error'=> trans('langconvert.functions.testimonialdelete')]);
    
    }




    public function testi(Request $request)
    {
        $request->validate([
            'testimonialtitle' =>'required|max:255',
            
        ]);
        if($request->testimonialsub){
            $request->validate([
                'testimonialsub' =>'max:255',
                
            ]);
        }
        $calID = ['id' => $request->id];
        $calldetails = [
          	'testimonialtitle' => $request->testimonialtitle,
          	'testimonialsub' => $request->testimonialsub,
			'testimonialcheck'  => $request->has('testimonialcheck') ? 'on' : 'off',
         
        ];

        $callaction = Apptitle::updateOrCreate(
          ['id' => $calID], $calldetails);



      return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
    }

}
