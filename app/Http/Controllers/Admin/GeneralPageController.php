<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\SocialAuthSetting;
use Auth;
use Str;

class GeneralPageController extends Controller
{
	public function index(){
		$this->authorize('Pages Access');

		$title = Apptitle::first();
		$data['title'] = $title;
	
		$footertext = Footertext::first();
		$data['footertext'] = $footertext;
	
		$seopage = Seosetting::first();
		$data['seopage'] = $seopage;
				
		$post = Pages::all();
		$data['page'] = $post;

		if(request()->ajax()) {
			$data = Pages::get();
			return DataTables::of($data)
			->addColumn('action', function($data){

				$button = '<div class = "d-flex">';
				if(Auth::user()->can('Pages Edit')){
		
					$button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
				}else{
					$button .= '~';
				}
				if(Auth::user()->can('Pages View')){
						
					$button .= '<a href="'.url('page/'. $data->pageslug).'"  class="action-btns1" target="_blank" ><i class="feather feather-eye text-primary"  data-bs-toggle="tooltip" data-bs-placement="top" title="View"></i></a>';
				}else{
					$button .= '~';
				}
				if(Auth::user()->can('Pages Delete')){
					$button .= '<a href="javascript:void(0)" class="action-btns1 delete-pages" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"></i></a>';
				}else{
					$button .= '~';
				}
						
				$button .= '</div>';
				return $button;
			}) 
			->addColumn('created_at', function($data){
				$date = $data->created_at->format(setting('date_format'));
				return $date;
			})
			->addColumn('pagename', function($data){
                return Str::limit($data->pagename, '40');
            })
							
			->rawColumns(['created_at','action','pagename'])
			->addIndexColumn()
			->make(true);
						
		}

		return view('admin.generalpage.index')->with($data);
	}


	public function store(Request $request)
	{

		$testiId = $request->pages_id;
		$pagesfind = Pages::find($testiId);

		if(!$pagesfind){
			$request->validate([
				'pagename'=> 'required|max:255|unique:pages',
				'pagedescription' => 'required',
				
			]);
		}
		if($pagesfind){
			if($pagesfind->pagename == $request->pagename){
				$request->validate([
					'pagename'=> 'required|max:255',
					'pagedescription' => 'required',
					
				]);
			}
			else{
				$request->validate([
					'pagename'=> 'required|max:255|unique:pages',
					'pagedescription' => 'required',
					
				]);
			}
			
		}
		
		
		if(!$pagesfind){
			$testi =  [
				'pagename' => $request->pagename,
				'pagedescription' => $request->pagedescription,
				'pageslug' => Str::slug($request->pagename, '-'),
				'viewonpages' => $request->display,
				'status' => $request->status ? 1 : 0,
			];
		}
		if($pagesfind){
			
			if($pagesfind->pageslug != null){
				$testi =  [
					'pagename' => $request->pagename,
					'pagedescription' => $request->pagedescription,
					'viewonpages' => $request->display,
					'status' => $request->status ? 1 : 0,
				];
			}
			if($pagesfind->pageslug == null){
				$testi =  [
					'pagename' => $request->pagename,
					'pagedescription' => $request->pagedescription,
					'pageslug' => Str::slug($request->pagename, '-'),
					'viewonpages' => $request->display,
					'status' => $request->status ? 1 : 0,
				];
			}
		}
		$pages = Pages::updateOrCreate(['id' => $testiId], $testi);
		return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon'),'data' => $pages], 200);

	}
	
	public function show($id)
	{
		$this->authorize('Pages Edit');
		$post = Pages::find($id);

		return response()->json($post);
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
        $pages = Pages::findOrFail($id);
        $pages->delete();


        return response()->json(['error'=> trans('langconvert.functions.pagesdelete')]);
    }
		
}
