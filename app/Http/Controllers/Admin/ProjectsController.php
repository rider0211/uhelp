<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Ticket\Category;
use DataTables;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Imports\ProjectImport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Str;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use App\Models\Projects_category;

class ProjectsController extends Controller
{
    public function index()
    {

        if(request()->ajax()) 
        {
            $data = Projects::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<div class = "d-flex">';
                if(Auth::user()->can('Project Edit')){

                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                }else{
                $button .= '~';
                }
                if(Auth::user()->can('Project Delete')){
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="delete-testimonial" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                }else{
                $button .= '~';
                }
                
                $button .= '</div>';
                return $button;
            })
            ->addColumn('checkbox', function($data){
                if(Auth::user()->can('Project Delete')){
                    return '<input type="checkbox" name="project_checkbox[]" class="checkall" value="'.$data->id.'" />';
                }else{
                    return '<input type="checkbox" name="project_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
                }
            })
            ->addColumn('name', function($data){
                return Str::limit( $data->name, '40');
            })
            ->rawColumns(['action','checkbox','name'])
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

        $projects = Projects::all();
        $data['project'] = $projects;

        $categories = Category::whereIn('display',['ticket', 'both'])->where('status', '1')
        ->get();
        $data['categories'] = $categories;

        $check_category = Projects_category::pluck('category_id')->toArray();
        $data['check_category'] = $check_category;

        return view('admin.projects.index',compact('basic','title','footertext'))->with($data)->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function store(Request $request)
    {
 
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            
        ]);

        if($validator->passes()){
            $testiId = $request->projects_id;
            $testi =  [
                'name' => $request->name,
            ];
               
            $project = Projects::updateOrCreate(['id' => $testiId], $testi);
            return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.projectupdatecreate'),'data' => $project], 200);

        }else{
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function show($id)
    {
      $this->authorize('Project Edit');
        $post = Projects::find($id);

        $cat = DB::table("category_category_user")->where("category_category_user.category_id",$id)
            ->pluck('category_category_user.category_user_id','category_category_user.category_user_id')
            ->all();
            if(request()->ajax()){
                $output = '';
                $data = Category::all();
                $total_row = $data->count();
              if($total_row > 0){
                foreach($data as $row){
                    $output .= '
                            
                            
                    <option  value="'.$row->id.'" >'.$row->name.'</option>
                    
                    ';
                }
              }
              
            }
      
        return response()->json($post);
    }

    public function destroy($id)
    {
      $this->authorize('Project Delete');
      $testimonial = Projects::find($id);
      $testimonial->delete();

      return response()->json(['error'=> trans('langconvert.functions.projectdelete')]);
    }

    public function projectmassdestroy(Request $request){
        $student_id_array = $request->input('id');

        $projects = Projects::whereIn('id', $student_id_array)->get();

        foreach($projects as $project){
        $project->delete();
        }
        return response()->json(['error'=> trans('langconvert.functions.projectdelete')]);
    
    }

    public function projectlist(){

        $category = Category::all();

        $project = Projects::all();

        return response()->json(['category'=>$category,'project'=>$project]);
    }

    public function projectassignee(Request $r)
    {
        $this->authorize('Project Assign');
        $projects = Projects::find($r->projected);
        if(!empty($projects)){
        foreach ($projects as $project){
            $project->updated_at = now();
            $project->update();

            if($r->input('category_id') == null ){ 
            $project->projectscategory()->detach($r->input(['category_id']));
            
            }else{
            foreach ($r->input('category_id') as $value) {
                $category_id[] = $value;  
            }
            $project->projectscategory()->sync($r->input(['category_id']));
            }
        }

        return redirect()->back()->with(['success' => trans('langconvert.functions.projectassigned')]);
        }else{
        return redirect()->back()->with(['error' => trans('langconvert.functions.projectnotassigned')]);
        }
       
    }


    public function projetimport(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.projects.projectimport')->with($data);
    }

  
     /**
    * @return \Illuminate\Support\Collection
    */
    public function projetcsv(Request $req) 
    {
        $this->authorize('Project Importlist');
        $file = $req->file('file')->store('import');

        $import = new ProjectImport;
        $import->import($file);

        return redirect()->route('projects')->with('success', trans('langconvert.functions.projectimport'));
    }

    public function notificationpage(){

        $title = Apptitle::first();
        $data['title'] = $title;
    
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;
    
        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        return view('admin.notificationpage')->with($data);

    }



}
