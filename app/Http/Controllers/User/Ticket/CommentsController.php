<?php

namespace App\Http\Controllers\User\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket\Comment;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Category;
use App\Models\User;
use App\Mail\AppMailer;
use Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Hash;
use App\Notifications\TicketCreateNotifications;



class CommentsController extends Controller
{
    public function postComment(Request $request,  $ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        if($ticket->status == "Closed"){
            
             return redirect()->back()->with("error", trans('langconvert.functions.ticketalreadyclosed'));
        }
        else{
            $this->validate($request, [
                'comment' => 'required'
            ]);
            $tic = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            if($tic->comments()->get() != null){
                $comm = $tic->comments()->update([
                    'display' => null
                ]);
            }
            $comment = Comment::create([
                'ticket_id' => $request->input('ticket_id'),
                'cust_id' => Auth::guard('customer')->user()->id,
                'user_id' => null,
                'display' => 1,
                'comment' => $request->input('comment')
            ]);

            foreach ($request->input('comments', []) as $file) {
                $comment->addMedia(public_path('uploads/comment/' . $file))->toMediaCollection('comments');
            }

            // Closing the ticket
            if(request()->has(['status'])){

                $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

                $ticket->status = $request->input('status');
                $ticket->closing_ticket = now()->format('Y-m-d');
                $ticket->update();

                $ticketOwner = $ticket->user;

            }

            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $ticket->last_reply = now();
            // Auto Overdue Ticket

            if(setting('AUTO_OVERDUE_TICKET') == 'no'){
                $ticket->auto_overdue_ticket = null;
            }else{
                if(setting('AUTO_OVERDUE_TICKET_TIME') == '0'){
                    $ticket->auto_overdue_ticket = null;
                }else{
                    if(Auth::guard('customer')->check() && Auth::guard('customer')->user()){
                        if($ticket->status == 'Closed'){
                            $ticket->auto_overdue_ticket = null;
                        }
                        else{
                            $ticket->auto_overdue_ticket = now()->addDays(setting('AUTO_OVERDUE_TICKET_TIME'));
                        }
                    } 
                }
            }
            // Auto Overdue Ticket

            // Auto Closing Ticket

            if(setting('AUTO_CLOSE_TICKET') == 'no'){
                $ticket->auto_close_ticket = null;
            }else{
                if(setting('AUTO_CLOSE_TICKET_TIME') == '0'){
                    $ticket->auto_close_ticket = null;
                }else{
                    
                    if(Auth::guard('customer')->check() && Auth::guard('customer')->user()){
                        $ticket->auto_close_ticket = null;
                    }
                }
            }
            // End Auto Close Ticket

            if(request()->input(['status']) == 'Closed'){
                $ticket->replystatus = 'Solved';
            }
            $ticket->update();
        
            if(request()->input(['status']) == 'Closed'){
                // Close Ticket notificaton
                $notificationcat = $ticket->category->groupscategoryc()->get();
                $icc = array();
                    if($notificationcat->isNotEmpty()){

                        foreach($notificationcat as $igc){
                                
                            foreach($igc->groupsc->groupsuser()->get() as $user){
                                $icc[] .= $user->users_id;
                            }
                        }
                        
                        if(!$icc){
                            $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                            foreach($admins as $admin){
                                $admin->notify(new TicketCreateNotifications($ticket));
                            }
                            
                        }else{
                        
                            $user = User::whereIn('id', $icc)->get();
                            foreach($user as $users){
                                $users->notify(new TicketCreateNotifications($ticket));
                            }
                            $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                            foreach($admins as $admin){
                                $admin->notify(new TicketCreateNotifications($ticket));
                            }
                            
                            
                        }
                    }else{
                        $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                        foreach($admins as $admin){
                            $admin->notify(new TicketCreateNotifications($ticket));
                        }
                    }

                return redirect()->route('rating', $ticket->ticket_id);
            }else{
                
                // reply ticket notification
                $notificationcat = $ticket->category->groupscategoryc()->get();
                $icc = array();
                    if($notificationcat->isNotEmpty()){

                        foreach($notificationcat as $igc){
                                
                            foreach($igc->groupsc->groupsuser()->get() as $user){
                                $icc[] .= $user->users_id;
                            }
                        }
                        
                        if(!$icc){
                            $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                            foreach($admins as $admin){
                                $admin->notify(new TicketCreateNotifications($ticket));
                            }
                            
                        }else{
                        
                            $user = User::whereIn('id', $icc)->get();
                            foreach($user as $users){
                                $users->notify(new TicketCreateNotifications($ticket));
                            }
                            $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                            foreach($admins as $admin){
                                $admin->notify(new TicketCreateNotifications($ticket));
                            }
                            
                            
                        }
                    }else{
                        $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                        foreach($admins as $admin){
                            $admin->notify(new TicketCreateNotifications($ticket));
                        }
                    }

                return redirect()->back()->with("success", trans('langconvert.functions.ticketreply'));
            }
        }
       
    }

    public function storeMedia(Request $request)
    {
        $path = public_path('uploads/comment');
    
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    
        $file = $request->file('file');
    
        $name = $file->getClientOriginalName();
    
        $file->move($path, $name);
    
        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


    public function updateedit(Request $request, $id){
        if ($request->has('message')) {

            $this->validate($request, [
                'message' => 'required'
            ]);
            $ticket = Ticket::findOrFail($id);
            $ticket->message = $request->input('message');
            
            $ticket->update(); 
            return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));

        }else{
            $this->validate($request, [
                'editcomment' => 'required'
            ]);
            $comment = Comment::findOrFail($id);
            $comment->comment = $request->input('editcomment');
            
            $comment->update(); 
            return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
        }

       
    }

    public function imagedestroy($id)
        {   //For Deleting Users
            $commentss = Media::findOrFail($id);
            $commentss->delete();
            return response()->json([
                'success' => trans('langconvert.functions.ticketimagedelete')
            ]);
        }

}

