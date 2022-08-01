<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket\Category;
use App\Models\Ticket\Ticket;
use Auth;
use DB;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Projects;
use App\Models\Groups;
use DataTables;
use App\Models\User;
use App\Models\Subcategory;
use App\Models\Subcategorychild;
use App\Models\CategoryUser;
use Illuminate\Support\Facades\Validator;
use Response;
use Str;
use Modules\Uhelpupdate\Entities\CategoryEnvato;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('Category Access');

            $categories = DB::table('categories')->paginate();
            $data['categories'] = $categories;

            $title = Apptitle::first();
            $data['title'] = $title;

            $footertext = Footertext::first();
            $data['footertext'] = $footertext;

            $seopage = Seosetting::first();
            $data['seopage'] = $seopage;

            $post = Pages::all();
            $data['page'] = $post;

            if(request()->ajax()) {
                $data = Category::get();
                
                return DataTables::of($data)

                ->addColumn('groupcategory', function($data){
                    if(Auth::user()->can('Category Assign To Groups')){
                    
                        if($data->display == 'ticket' || $data->display == 'both'){
                            $button = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigneds" class="badge badge-pill badge-info mt-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign to group">
                        '.$data->groupscategoryc()->count().'
                        </a>';
                        return $button;
                        }
                        
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
                    if(Auth::user()->can('Category Edit')){
                        if($data->status == '1'){
                            $button = '
                            <label class="custom-switch form-switch mb-0">
                                <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch" checked>
                                <span class="custom-switch-indicator"></span>
                            </label>';
                        }else{
                            $button = ' 
                                <label class="custom-switch form-switch mb-0">
                                    <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch">
                                    <span class="custom-switch-indicator"></span>
                                </label> ';
                        }
                        return $button;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('action', function($data){
                    if(Auth::user()->can('Category Edit')){
                  $button = '<div class = "d-flex"><a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a></div>';
                    }else{
                        $button = '~';
                    }
                  return $button;
                })
                ->addColumn('name', function($data){
                    return Str::limit($data->name, '40');
                })
                ->addColumn('priority', function($data){
                    if($data->priority != null){

                        if($data->priority == "Low"){

                            return '<span class="badge badge-success-light" >'.$data->priority.'</span>';
                                
                        }
                        elseif($data->priority == "High"){

                            return '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                                
                        }elseif($data->priority == "Critical"){

                            return '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                            
                        }else{

                            return ' <span class="badge badge-warning-light">'.$data->priority.'</span>';
                                
                        }
                    }
                    else{
                        return '~';
                    }

                })
                ->rawColumns(['action','status','Assigncategory','groupcategory','name','priority'])
                ->addIndexColumn()
                ->make(true);
                
            }
            
            
            return view('admin.category.index')-> with($data)->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function status(Request $request, $id)
    {
          $calID = Category::find($id);
          $calID ->status = $request->status;
          $calID ->save();
          

        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'display' => 'required|in:both,ticket,knowledge',
            
        ]);

        if($validator->passes()){

        
            $testiId = $request->testimonial_id;
            $categoryfind = Category::find($testiId);
            if($categoryfind){
                if($categoryfind->categoryslug == null){

                    $testi =  [
                        'name' => $request->name,
                        'display' => $request->display,
                        'priority' => $request->priority,
                        'categoryslug' => Str::slug($request->name, '-'),
                        'status' => $request->status ?  '1' :  '0',
                    ];
                }
                if($categoryfind->categoryslug != null){

                    $testi =  [
                        'name' => $request->name,
                        'display' => $request->display,
                        'priority' => $request->priority,
                        'status' => $request->status ?  '1' :  '0',
                    ];
                }
            }
            if(!$categoryfind){
                $testi =  [
                    'name' => $request->name,
                    'display' => $request->display,
                    'priority' => $request->priority,
                    'categoryslug' => Str::slug($request->name, '-'),
                    'status' => $request->status ?  '1' :  '0',
                ];
            }
        
             
         
            $testimonial = Category::updateOrCreate(['id' => $testiId], $testi);
         
         
            return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.categoryupdateorcreate'),'data' => $testimonial], 200);
        }else{
            return Response::json(['errors' => $validator->errors()]);
        }

    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Category Edit');
        $post = Category::find($id);
        
        $data = [
            'post' => $post,
        ];
        return response()->json($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Category Edit');
        $categories = Category::where('id', $id)->findOrFail();
        $data['categories'] = $categories;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $title = Apptitle::first();
        $data['title'] = $title;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        return view('admin.category.showcategory')-> with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'catogorynam' => 'required|string|max:255',
            
        ]);
        $Category = Category::findOrFail($id);

        $Category->name = $request->input('catogorynam');
        $Category->update();
        return redirect('/admin/categories')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('Category Delete');
        $Category = Category::findOrFail($id);
        
        $Category->delete();


        return response()->json(['error'=> trans('langconvert.functions.categorydelete')]);
    }


    public function agentshow(Request $req, $id)
    {
        
        if($req->ajax()){
            $output = '';

            $assign = Category::find($id);

            $group =User::
            leftJoin('groups_users', 'users.id','groups_users.users_id')
            ->leftJoin('groups_categories','groups_users.groups_id','groups_categories.group_id')
            ->where('groups_categories.category_id', $id)->first();

            if($group != null){
                $data =User::
                leftJoin('groups_users', 'users.id','groups_users.users_id')
                ->leftJoin('groups_categories','groups_users.groups_id','groups_categories.group_id')
                ->whereNull('groups_categories.category_id')->get();
            }else{
                $data =User::
                leftJoin('groups_users', 'users.id','groups_users.users_id')
                ->leftJoin('groups_categories','groups_users.groups_id','groups_categories.group_id')
                ->whereNull('groups_categories.category_id')->get();
            }
            
            

            $total_row = $data->count();

            $cat = DB::table("category_category_user")->where("category_category_user.category_id",$id)
            ->pluck('category_category_user.category_user_id','category_category_user.category_user_id')
            ->all();
           
            if($total_row > 0){
                foreach($data as $row){

                    
                        $output .= '
                        
                            <option  value="'.$row->id.'" ' .( $row->id  ? in_array($row->id,$cat) ?  'selected' : '' : '').'>'.$row->name.' '.(!empty($row->getRoleNames()[0])? $row->getRoleNames()[0] : '').'</option>
                            
                            ';
                    
                }					
								
            }else{
                $output = '
                <option label="Select Agent"></option>
                <option >No Data Found</option>
                ';
            }
            $data = array(
                'assign_data'=> $assign,
                'table_data' => $output,
                'total_data' => $total_row,
                'data' => $cat
            );
           
           
        }

    }


    public function agentshowcreate(Request $request){



        $data =  $request->assigned_id;
        $cat = Category::find($data);
        $cat->update($request->only(['assigned_name']));

        if($request->input('assigned_user_id')){
            foreach ($request->input('assigned_user_id') as $value) {
                $assigned_user_id[] = $value;  
            }
        }
        
        $cat->catagent()->sync($request->get('assigned_user_id'));

        return response()->json(['success'=> trans('langconvert.functions.updatecommon')]);

    }


    public function groupshow(Request $req, $id)
    {

        if($req->ajax()){
            $output = '';

            $assign = Category::find($id);
            
            $data = Groups::get();

            $total_row = $data->count();

            $cat = DB::table("groups_categories")->where("groups_categories.category_id",$id)
            ->pluck('groups_categories.group_id','groups_categories.group_id')
            ->all();
           
            if($total_row > 0){
                foreach($data as $row){

                    
                    $output .= '
                        
                        
                        <option  value="'.$row->id.'" ' .( $row->id  ? in_array($row->id,$cat) ?  'selected' : '' : '').'>'.$row->groupname.'</option>
                            
                    ';
             
                   
                }					
								
            }else{
                $output = '
                <option label="Select Group"></option>
                <option >No Data Found</option>
                ';
            }
            $data = array(
                'assign_data'=> $assign,
                'table_data' => $output,
                'total_data' => $total_row,
                'data' => $cat
            );

           
            return response()->json($data);
        }

    }

    public function categorygroupassign(Request $request)
    {

        $data =  $request->category_id;
        $cat = Category::find($data);
        $cat->update($request->only(['category_name']));

        if($request->input('group_id')){
            foreach ($request->input('group_id') as $value) {
                $group_id[] = $value;

                
            }
        }
        
        $cat->groupscategory()->sync($request->get('group_id'));
        

        return response()->json(['success'=> trans('langconvert.functions.updatecommon')]);

    }


    /// category list 

    public function categorylist(Request $req, $ticket_id)
    {

        if($req->ajax()){
            $output = '';
            $category = Category::whereIn('display',['ticket', 'both'])->where('status', '1')->get();

            $totalrow = $category->count();
            $ticket = DB::table('tickets')->where('ticket_id', $ticket_id)->first();
            if($totalrow > 0){
                $output .='<option label="Select Category"></option>';
                foreach($category as $categories){
                    $output .= '
                    <option  value="'.$categories->id.'"'.($categories->id == $ticket->category_id ? 'selected': '').'>'.$categories->name.'</option>
                    ';
                }
            }else{
                $output .= '
                <option label="No Data Found"></option>
                ';
            }

            $projectoutput = '';
            $projects = Projects::get();
            if($projects->count() > 0){
                foreach($projects as $project){
                    $projectoutput .= '<option  value="'.$project->name.'"'.($project->name == $ticket->project ? 'selected': '').'>'.$project->name.'</option>';
                }
            }else{
                $projectoutput .= '
                <option label="No Data Found"></option>
                ';
            }

            $subcategory = '';
            $ticket1 = DB::table('tickets')->where('ticket_id', $ticket_id)->first();
            $category1 = Subcategorychild::where('category_id',$ticket1->category_id)->get();
           
            $totalrow1 = $category1->count();
            if($totalrow1 > 0){
                $subcategory .='<option label="Select Category"></option>';
                foreach($category1 as $categories){

                    foreach ($categories->subcatlists()->where('status', '1')->get() as $subcategorylist) {
                       $subcategory .= '
                        <option  value="'.$subcategorylist->id.'"'.($subcategorylist->id == $ticket1->subcategory ? 'selected': '').'>'.$subcategorylist->subcategoryname.'</option>
                        ';
                    }
                   
                }
            }
            
            $data = array(
                
                'table_data' => $output,
                'total_data' => $totalrow,
                'ticket' => $ticket,
                'projectop' => $projectoutput,
                'subcategoryt' => $subcategory,
                
            );
          return response()->json($data, 200);
        }

        
    }


    public function categorychange(Request $req)
    {

        $this->validate($req, [
            'category' => 'required',
        ]);

        $ticketcategory = Ticket::find($req->ticket_id);
        $ticketcategory->category_id = $req->category;
        $ticketcategory->project = $req->project;
        $ticketcategory->subcategory = $req->subscategory;
        $ticketcategory->purchasecodesupport = $req->envato_support;
        $ticketcategory->purchasecode = $req->envato_id;
        
        $findcat = Category::find($req->category);
        $ticketcategory->priority = $findcat->priority;
        $ticketcategory->update();

        return response()->json(['success' => trans('langconvert.functions.updatecommon')]);
        

    }

    public function categorylistshow(Request $request)
    {

        if($request->ajax()){

            $output = '';
            $category = Category::whereIn('display',['ticket', 'both'])->where('status', '1')->get();

            $categoryenvato = CategoryEnvato::pluck('category_id')->toArray();
            

            $totalrow = $category->count();

            if($totalrow > 0){
                $output .='<option label="Select Category"></option>';
                foreach($category as $categories){
                    $output .= '
                    <option  value="'.$categories->id.'" '.(in_array($categories->id, $categoryenvato) ? 'selected':'' ).'>'.$categories->name.'</option>
                    ';
                }
            }
            return response()->json($output, 200);
        }

    }

    public function categoryenvatoassign(Request $r)
    {

        if($r->input('categorys_id') != null){
            
            $categories = CategoryEnvato::get();
           
            foreach($categories as $category){

                $category->truncate();
            }
            foreach($r->input('categorys_id') as $value){
                
                $category = CategoryEnvato::create([
                    'category_id' => $value,
                    'envato_enable' => '1'
                ]);
    
            }
        }else{

            $categories = CategoryEnvato::get();
           
            foreach($categories as $category){

                $category->truncate();
            }
        }


        return response()->json(['success' => trans('langconvert.functions.updatecommon'), 200]);

        
    }

    public function subcategoryindex()
    {
        $subcategory = Subcategory::get();
        $data['subcategory'] = $subcategory;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
        
        return view('admin.category.subcategory')->with($data);
    }

    public function categorygetall(Request $request)
    {
        $categoryall = Category::get();
        
        // $categoryArray = Category::pluck('parent_id')->toArray();
        
        $output = '';
        if($categoryall != ''){
            $output .= '<option label="No Parent"></option>';
            foreach($categoryall as $catall){
                $output .= '<option value="'.$catall->id.'">'.$catall->name.' </option>';
            }
        }
        return response()->json($output);
    }

    public function subcategorystore(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            
        ]);

        if($validator->passes()){

            $testiId = $request->subcategory_id;
            $testi =  [
                'subcategoryname' => $request->name,
                'status' => $request->status ?  '1' :  '0',
            ];
            $testimonial = Subcategory::updateOrCreate(['id' => $testiId], $testi);

            if($request->parent_id){
                foreach ($request->parent_id as $value) {
                    $parent_id[] = $value;
                }
            }
            
            $testimonial->subcategorysync()->sync($request->get('parent_id'));

            return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.categoryupdateorcreate'),'data' => $testimonial], 200);
        }else{
            return Response::json(['errors' => $validator->errors()]);
        }
    }   

    public function subcategoryshow($id)
    {
        $subcategory = Subcategory::find($id);

        if(request()->ajax()){
            $categoryall = Category::get();
        
            $categoryArray = Subcategorychild::where("subcategory_id",$id)->pluck('category_id')->toArray();

        
            $output = '';
            if($categoryall != ''){
                $output .= '<option label="No Parent"></option>';
                foreach($categoryall as $catall){
                    $output .= '<option value="'.$catall->id.'"'.($catall->id  ? in_array($catall->id,$categoryArray) ?  'selected' : '' : '').'>'.$catall->name.' </option>';
                }
            }
        }
        $data = [
            'subcategory' => $subcategory,
            'categorylist' => $output
        ];
        return response()->json($data);
        
    }

    public function subcategorystatusupdate(Request $request)
    {
        $subcategorystatus = Subcategory::find($request->id);
        $subcategorystatus->status = $request->status;
        $subcategorystatus->update();
        return response()->json([$subcategorystatus, 'success' => trans('langconvert.functions.updatecommon')], 200);
    }

    public function subcategorydelete(Request $request)
    {
        $subcategorydelete = Subcategory::find($request->id);
        $subcategorydelete->delete();   
        return response()->json([$subcategorydelete, 'error' => trans('langconvert.functions.deletecommon')], 200);
    }





}
