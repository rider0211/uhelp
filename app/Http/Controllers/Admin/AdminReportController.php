<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\User;
use App\Models\Customer;
use App\Models\Ticket\Ticket;
use App\Models\usersettings;
use DB;
use DataTables;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    public function index(){

      $this->authorize('Reports Access');

      if(request()->ajax()){

         $data = User::get();
         return DataTables::of($data)
         ->addColumn('name', function($data){
               if(!empty($data->getRoleNames()[0])){
                  $name = '<div class="h5 mb-0">'.$data->name.'</div><small class="fs-12 text-muted"><span class="font-weight-normal1"><b>('.$data->getRoleNames()[0].')</b></span></small>' ;
               }else{
                  $name = '<div class="h5 mb-0">'.$data->name.'</div><small class="fs-12 text-muted"></small>' ;
               }
               
              
            
               return $name;
         })
         ->addColumn('rating', function($data){

            $avgrating1 = usersettings::where('users_id',$data->id)->sum('star1');
            $avgrating2 = usersettings::where('users_id',$data->id)->sum('star2');
            $avgrating3 = usersettings::where('users_id',$data->id)->sum('star3');
            $avgrating4 = usersettings::where('users_id',$data->id)->sum('star4');
            $avgrating5 = usersettings::where('users_id',$data->id)->sum('star5');

            $avgr = ((5*$avgrating5) + (4*$avgrating4) + (3*$avgrating3) + (2*$avgrating2) + (1*$avgrating1));
            $avggr = ($avgrating1 + $avgrating2 + $avgrating3 + $avgrating4 + $avgrating5);
            
            if($avggr == 0){
               $avggr = 1;
               $avg = $avgr/$avggr;
            }else{
               $avg = $avgr/$avggr;
            }
               
            $rating = $avg;
         
            return '<div class="allemployeerating pt-1" data-rating="'.$rating.'"></div>';
      })
      ->addColumn('replycount', function($data){
            
         $replycount = $data->comments()->count();
         
         return $replycount;
      })
     
        
        ->rawColumns(['name','replycount','rating'])
        ->addIndexColumn()
        ->make(true);
      }

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $agentactivec = User::where('status','1')->count();
        $data['agentactivec'] = $agentactivec;
        $agentinactive = User::where('status','0')->count();
        $data['agentinactive'] = $agentinactive;

        $customeractive = Customer::where('status','1')->count();
        $data['customeractive'] = $customeractive;
        $customerinactive = Customer::where('status','0')->count();
        $data['customerinactive'] = $customerinactive;

        $newticket = Ticket::where('status', 'New')->count();
        $data['newticket'] = $newticket;

        $closedticket = Ticket::where('status', 'Closed')->count();
        $data['closedticket'] = $closedticket;

        $inprogressticket = Ticket::where('status', 'Inprogress')->count();
        $data['inprogressticket'] = $inprogressticket;

        $onholdticket = Ticket::where('status', 'On-Hold')->count();
        $data['onholdticket'] = $onholdticket;

        $reopenticket = Ticket::where('status', 'Re-Open')->count();
        $data['reopenticket'] = $reopenticket;


        return view('admin.reports.index')->with($data);
    }
}
