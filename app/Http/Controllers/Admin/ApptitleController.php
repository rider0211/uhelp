<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;

class ApptitleController extends Controller
{
	public function index()
	{
		$this->authorize('General Setting Access');
		$basic = Apptitle::first();

		$title = Apptitle::first();
		$data['title'] = $title;

		$footertext = Footertext::first();
		$data['footertext'] = $footertext;

		$seopage = Seosetting::first();
		$data['seopage'] = $seopage;

		$post = Pages::all();
		$data['page'] = $post;


		return view('admin.generalsetting.apptitle', compact('basic','title','footertext'))->with($data);
	}

	public function store(Request $request)
	{
		
			$request->validate([
				'title'=> 'required',
					
			]);
			$calID = ['id' => $request->id];

			$calldetails = [
					'title' => $request->title,
					'checkbox' => $request->input('checkbox'),
			];

			// light logo upload
			if ($files = $request->file('image')) 
			{

					$request->validate([
						'image' => 'required|mimes:jpg,jpeg,png,svg|max:5120',
					]);
					
					//delete old file
					$testiimage = Apptitle::find($request->id);
					$imagepath =   'public/uploads/logo/logo/'. $testiimage->image;
					if(\File::exists($imagepath)){
						\File::delete($imagepath);
					}
				
					//insert new file
					$destinationPath = 'public/uploads/logo/logo/'; // upload path
					$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
					$files->move($destinationPath, $profileImage);
					$calldetails['image'] = "$profileImage";
			}

			// dark logo upload
			if ($files = $request->file('image1')) 
			{
					
					$request->validate([
						'image1' => 'required|mimes:jpg,jpeg,png,svg|max:5120',
					]);

					//delete old file
					$testiimage1 = Apptitle::find($request->id);
					$imagepath1 =   'public/uploads/logo/darklogo/'. $testiimage1->image1;
					if(\File::exists($imagepath1)){
						\File::delete($imagepath1);
					}
				
					//insert new file
					$destinationPath = 'public/uploads/logo/darklogo/'; // upload path
					$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
					$files->move($destinationPath, $profileImage);
					$calldetails['image1'] = "$profileImage";
			}

			// Dark-Icon upload 
			if ($files = $request->file('image2')) 
			{
					
					$request->validate([
						'image2' => 'required|mimes:jpg,jpeg,png,svg|max:5120',
					]);

					//delete old file
					$testiimage2 = Apptitle::find($request->id);
					$imagepath2 =   'public/uploads/logo/icon/'. $testiimage2->image2;
					if(\File::exists($imagepath2)){
						\File::delete($imagepath2);
					}

					//insert new file
					$destinationPath = 'public/uploads/logo/icon/'; // upload path
					$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
					$files->move($destinationPath, $profileImage);
					$calldetails['image2'] = "$profileImage";
			}

			// Light-Icon upload
			if ($files = $request->file('image3')) 
			{
					
					$request->validate([
						'image3' => 'required|mimes:jpg,jpeg,png,svg|max:5120',
					]);

					//delete old file
					$testiimage3 = Apptitle::find($request->id);
					$imagepath3 =   'public/uploads/logo/darkicon/'. $testiimage3->image3;
					if(\File::exists($imagepath3)){
						\File::delete($imagepath3);
					}
				
					//insert new file
					$destinationPath = 'public/uploads/logo/darkicon/'; // upload path
					$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
					$files->move($destinationPath, $profileImage);
					$calldetails['image3'] = "$profileImage";
			}

			// Upload Favicon uploa	 
			if ($files = $request->file('image4')) 
			{
					
					$request->validate([
						'image4' => 'required|mimes:jpg,jpeg,png,svg|max:5120',
					]);

					//delete old file
					$testiimage4 = Apptitle::find($request->id);
					$imagepath4 =   'public/uploads/logo/favicons/'. $testiimage4->image4;
					if(\File::exists($imagepath4)){
						\File::delete($imagepath4);
					}
					
				
					//insert new file
					$destinationPath = 'public/uploads/logo/favicons/'; // upload path
					$profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
					$files->move($destinationPath, $profileImage);
					$calldetails['image4'] = "$profileImage";
			}

			$callaction = Apptitle::updateOrCreate(
				['id' => $calID], $calldetails);

			return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
	}


	public function bannerpage()
	{
		$this->authorize('Banner Access');
		$basic = Apptitle::first();

		$title = Apptitle::first();
		$data['title'] = $title;

		$footertext = Footertext::first();
		$data['footertext'] = $footertext;

		$seopage = Seosetting::first();
		$data['seopage'] = $seopage;

		$post = Pages::all();
		$data['page'] = $post;


		return view('admin.generalsetting.bannerpage', compact('basic','title','footertext'))->with($data);
	}

	public function bannerstore(Request $request)
	{
		$this->authorize('Banner Access');
		$request->validate([
			'searchtitle'=> 'required|string|max:255',
				
		]);

		if($request->searchsub){
			$request->validate([
				'searchsub'=> 'string|max:255',
				
			]);
		}
		$calID = ['id' => $request->id];
		$calldetails = [
			'searchtitle' => $request->searchtitle,
			'searchsub' => $request->searchsub,
				
		];

		$callaction = Apptitle::updateOrCreate(['id' => $calID], $calldetails);

		return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
	}

	public function footer()
	{

		$title = Apptitle::first();
		$data['title'] = $title;

		$footertext = Footertext::first();
		$data['footertext'] = $footertext;

		$seopage = Seosetting::first();
		$data['seopage'] = $seopage;

		$post = Pages::all();
		$data['page'] = $post;

		return view('admin.footer.index')->with($data);
	}

	public function footerstore(Request $request)
	{

		$request->validate([
			'copyright'=> 'required',
			
		]);
		$calID = ['id' => $request->id];
		$calldetails = [
			
			'copyright' => $request->copyright,
			
		];
		$callaction = Footertext::updateOrCreate(
			['id' => $calID], $calldetails);

		return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
	}


	public function logodelete(Request $request)
		{
			$logo = Apptitle::find($request->id);
			if($request->logo == 'logo1'){
				if($logo->image != null){
					$imagepath =   'public/uploads/logo/logo/'. $logo->image;
					if(\File::exists($imagepath)){
						\File::delete($imagepath);
					}
				}
				$logo->image = null;
				$logo->update();
			}
			if($request->logo == 'logo2'){
				if($logo->image1 != null){
					$imagepath =   'public/uploads/logo/darklogo/'. $logo->image1;
					if(\File::exists($imagepath)){
						\File::delete($imagepath);
					}
				}
				$logo->image1 = null;
				$logo->update();
			}
			if($request->logo == 'logo3'){
				if($logo->image2 != null){
					$imagepath =   'public/uploads/logo/icon/'. $logo->image2;
					if(\File::exists($imagepath)){
						\File::delete($imagepath);
					}
				}
				$logo->image2 = null;
				$logo->update();
			}
			if($request->logo == 'logo4'){
				if($logo->image3 != null){
					$imagepath =   'public/uploads/logo/darkicon/'. $logo->image3;
					if(\File::exists($imagepath)){
						\File::delete($imagepath);
					}
				}
				$logo->image3 = null;
				$logo->update();
			}
			if($request->logo == 'logo5'){
				if($logo->image4 != null){
					$imagepath =   'public/uploads/logo/favicons/'. $logo->image4;
					if(\File::exists($imagepath)){
						\File::delete($imagepath);
					}
				}
				$logo->image4 = null;
				$logo->update();
			}
			
			return response()->json(['success' => trans('langconvert.functions.updatecommon'), 200]);
		}

	 
}
