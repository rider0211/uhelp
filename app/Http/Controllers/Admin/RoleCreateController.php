<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use DataTables;
use Auth;
use Str;

class RoleCreateController extends Controller
{
    public function index(){
        
        $this->authorize('Roles & Permission Access');
        $permission = Permission::get();
        $data['permission'] = $permission;
        
        $title = Apptitle::first();
        $data['title'] = $title;
    
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;
    
        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;
    
        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
            $data = Role::all();
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<div class = "d-flex">';
                if(Auth::user()->can('Roles & Permission Edit')){
        
                   if($data->name != 'superadmin'){
                    $button .= '<a href="'.url('/admin/role/edit/'.$data->id).'" class="action-btns1"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>';
                   }
                }else{
                    $button .= '~';
                }
                $button .= '</div>';
                return $button;
            })
            ->addColumn('rolescount', function($data){
                return '<span class="badge badge-primary">'.$data->users->count().'</span>';
            })
            ->addColumn('permissioncount', function($data){
                return '<span class="badge badge-success">'.$data->permissions->count().'</span>';
            })
            ->addColumn('name', function($data){
                return Str::limit($data->name, '40');
            })
            ->addIndexColumn()
            ->rawColumns(['action','rolescount','permissioncount'])
            ->make(true);
        }

        return view('admin.rolecreate.index')->with($data)->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(){

        $this->authorize('Roles & Permission Create');
        
        $permission = Permission::get();
        $data['permission'] = $permission;

            
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
    
        return view('admin.rolecreate.create')->with($data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Roles & Permission Create');
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        $data   =   $request->only(['name']);
        $data['guard_name'] =   'web';
        $role = Role::create($data);
        if($request->get('permission')){
            foreach($request->get('permission') as $prm){
                $role->givePermissionTo($prm);
            }
        }
     
        return redirect('admin/role')->with('success', trans('langconvert.functions.rolecreated'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('Roles & Permission Edit');
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.rolecreate.edit', compact('role', 'permissions'))->with($data);
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
        $this->authorize('Roles & Permission Edit');

        $role = Role::find($id);

        $role = Role::find($id);
        if($role->name == $request->name){
                if($request->get('permission')){
            foreach ($request->get('permission') as $value) {
                $permission[] = $value;
            }
        }

        $role->syncPermissions($request->get('permission'));
        }
        else{
             $request->validate([
                "name" => "required|max:255|unique:roles,name",
            ]);
            
            $role->update($request->only(['name']));
            if($request->get('permission')){
                foreach ($request->get('permission') as $value) {
                    $permission[] = $value;
                }
            }
            $role->syncPermissions($request->get('permission'));
        }
     
        return redirect('admin/role')->with('success', trans('langconvert.functions.roleupdated'));
    }
}
