<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use DB;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use DataTables;
use App\Models\User;
use App\Models\CategoryUser;
use App\Models\Groups;
use Str;


class GroupCreateController extends Controller
{
    public function index(){

        
        $this->authorize('Groups List Access');
            $title = Apptitle::first();
            $data['title'] = $title;

            $footertext = Footertext::first();
            $data['footertext'] = $footertext;

            $seopage = Seosetting::first();
            $data['seopage'] = $seopage;

            $post = Pages::all();
            $data['page'] = $post;

            if(request()->ajax()) {
                $data = Groups::get();
                
                return DataTables::of($data)
                ->addColumn('action', function($data){
                    if(Auth::user()->can('Groups Edit')){
                    $button = '<div class = "d-flex"><a href="'.url('admin/groups/view/'.$data->id).'" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a></div>';
                    }else{
                        $button .= '~';
                    }
                    return $button;
                })
                ->addColumn('groupname', function($data){
                    return Str::limit($data->groupname, '40');
                })
                ->addColumn('groupcount', function($data){
                    return '<span class="badge badge-info">'.$data->groupsuser()->count().'</span>';
                })

                ->rawColumns(['action','groupname','groupcount'])
                ->addIndexColumn()
                ->make(true);

            }

            return view('admin.groups.index')->with($data)->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function create(){
        $this->authorize('Groups Create');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $users = User::get();
        $data['users'] = $users;
        

        return view('admin.groups.create')->with($data);
    }


    public function store(Request $request){
        $this->authorize('Groups Create');
        $request->validate([
            'groupname' => 'required|string|max:255|unique:groups',
            
        ]);
        $grop = new Groups;

        $grop->groupname = $request->input('groupname');
        $grop->save();

        if($request->input('user_id')){
            foreach ($request->input('user_id') as $value) {
                $user_id[] = $value;

                
            }
        }
        
        $grop->groupsusers()->sync($request->get('user_id'));

        return redirect('admin/groups')->with('success', trans('langconvert.functions.groupcreate'));
    }

    public function show($id){
        $this->authorize('Groups Edit');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $grop = Groups::find($id);
        $data['group'] = $grop;

        $group = DB::table("groups_users")->where("groups_users.groups_id",$id)
            ->pluck('groups_users.users_id','groups_users.users_id')
            ->all();
        $data['grop'] = $group;

        $users = User::get();
        $data['users'] = $users;

        return view('admin.groups.edit')->with($data);
    }

    public function update(Request $request, $id){
        $this->authorize('Groups Edit');
        
        $grop = Groups::find($id);
        if($grop->groupname == $request->groupname){
            
            if($request->input('user_id')){
                foreach ($request->input('user_id') as $value) {
                    $user_id[] = $value;
    
                    
                }
            }
            
            $grop->groupsusers()->sync($request->get('user_id'));
        }else{
            $request->validate([
                'groupname' => 'required|string|max:255|unique:groups',
            ]);

            $grop->groupname = $request->input('groupname');
            $grop->update();

            if($request->input('user_id')){
                foreach ($request->input('user_id') as $value) {
                    $user_id[] = $value;
                }
            }
            $grop->groupsusers()->sync($request->get('user_id'));
        }
        
        return redirect('admin/groups')->with('success', trans('langconvert.functions.groupupdate'));
    }


}
