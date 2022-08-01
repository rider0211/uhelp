<?php

namespace Modules\Uhelpupdate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use Modules\Uhelpupdate\Entities\APIData;
use App\Helper\Installer\trait\ApichecktraitHelper;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class EnvatoAppinfoController extends Controller
{
    use ApichecktraitHelper;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $this->authorize('App Purchase Code Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $apidata = APIData::first();
        $data['apidata'] = $apidata;

        // Check purchase code
        $output = '';
        $purchaseCodeData = $this->purchaseCodeChecker(setting('envato_purchasecode'));
        if ($purchaseCodeData->valid == false) {
            $output .= '
                    <div class="card">
                        <div class="card-header border-0">
                            <h4 class="card-title">'.trans('uhelpupdate::langconvert.newwordslang.apppurchcode').'</h4>
                        </div>
                        <div class="card-body">
                            <form action="'.url('admin/licenseinfoenter/').'" method="POST"  enctype="multipart/form-data" >
                            '.csrf_field().'
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <input type="text" class="form-control" name="envato_id" >
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <button type="submit" class="btn btn-success">'.trans('uhelpupdate::langconvert.newwordslang.submitpurchase').'</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div
                    </div>
                ';
        }
        if ($purchaseCodeData->valid == true) {
            $checkapis = $this->purchaseCodecheckingapi(setting('envato_purchasecode'));
            
            // Format object data
            $result = json_decode($checkapis);
            
            if($result != null){
                $output .= '
                    <div class="card">
                        <div class="card-header border-0">
                            <h4 class="card-title">'.trans('uhelpupdate::langconvert.newwordslang.apppurchcode').'</h4>
                        </div>
                        <div class="card-body">
                            <form action="'.url('admin/licenseinfo/'.$result->id).'" method="POST"  enctype="multipart/form-data" >
                            '.csrf_field().'
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <input type="text" class="form-control" name="envato_search" value="'.str_pad(substr($result->purchaseCode, -4), strlen($result->purchaseCode), '*', STR_PAD_LEFT).'" readonly>
                                            <input type="hidden" class="form-control" name="envato_id" value="'.$result->purchaseCode.'">
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <button type="submit" class="btn btn-danger">'.trans('uhelpupdate::langconvert.newwordslang.deletepurchase').'</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="w-30"><b>App License:</b></td>													
                                        <td>'.$result->license.'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-30"><b>Application Url:</b></td>
                                        <td>'.$result->url.'</td>
                                    </tr>
                                    <tr>
                                        <td class="w-30"><b>Author:</b></td>
                                        <td>'.$result->author.'</td>
                                    </tr>
                                           
                                </tbody>
                            </table> 
                        </div>
                    </div>
                ';
            }
            if($result == null){
                $output .= '
                    <div class="card">
                        <div class="card-header border-0">
                            <h4 class="card-title">'.trans('uhelpupdate::langconvert.newwordslang.apppurchcode').'</h4>
                        </div>
                        <div class="card-body">
                            <form action="'.url('admin/licenseinfoenter/').'" method="POST"  enctype="multipart/form-data" >
                            '.csrf_field().'
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <input type="text" class="form-control" name="envato_id" >
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <button type="submit" class="btn btn-success">'.trans('uhelpupdate::langconvert.newwordslang.submitpurchase').'</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div
                    </div>
                ';
            }


            
        }
        return view('uhelpupdate::appinfo.index', compact('output'))->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('uhelpupdate::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // Check purchase code
        $purchaseCodeData = $this->purchaseCodeChecker($request->envato_id);
        if ($purchaseCodeData->valid == false) {
            return redirect()->back()->with('error', 'Enter Valid Purchase Code');
        }
        if ($purchaseCodeData->valid == true) {

            if($purchaseCodeData->item_id != config('installer.requirements.itemId')){
                
                return redirect()->back()->with('error', 'Invalid purchase code. Incorrect data format.');
            }
            if($purchaseCodeData->item_id == config('installer.requirements.itemId')){
                $purchaseCodeDatas = $this->purchaseCodecreate($request->envato_id, $request->app_firstname,$request->app_lastname, $request->app_email, url('/'),
                $purchaseCodeData->license, $purchaseCodeData->buyer, $purchaseCodeData->author);
                
                if($purchaseCodeDatas->App == 'old'){
                    return redirect()->back()->with('error', 'Purchase Code Already Installed On Other domain');
                }
                if($purchaseCodeDatas->App == 'New')
                {

                    $data['envato_purchasecode'] = $request->envato_id;
                    $this->updateSettings($data);

                    return redirect()->back()->with('success', 'Purchase Code Added Successfully');
                }
                if($purchaseCodeDatas->App == 'update'){
                    return redirect()->back()->with('error', 'Purchase Code Already Installed On Other domain');
                }
            }
        }
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
        return view('uhelpupdate::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function envatogetdetails($id)
    {

        $apiURL = 'https://api.spruko.com/api/api/apidetail/deletes/'. $id;
           
        $client = new \GuzzleHttp\Client();
        $response = Http::delete($apiURL);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);

        $data['envato_purchasecode'] = null;
        $this->updateSettings($data);
  
       return redirect()->back()->with('error', 'Deleted Successfully');
      
        // dd('a4edd8b1-b48e-42e7-8a5c-77a86c44ad93');
    }

    /**
     *  Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    private function updateSettings($data)
    {

        foreach($data as $key => $val){
        	$setting = Setting::where('key', $key);
        	if( $setting->exists() )
        		$setting->first()->update(['value' => $val]);
        }

    }
}
