<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ticket\Comment;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Category;
use App\Models\User;
use App\Models\Customer;
use Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Hash;
use App\Notifications\TicketCreateNotifications;
use App\Mail\mailmailablesend;
use Mail;

class CommentsController extends Controller
{
    public function postComment(Request $request,  $ticket_id)
    {

        if($request->status == 'Solved')
        {

            $this->validate($request, [
                'comment' => 'required'
            ]); 
            $comment = Comment::create([
                'ticket_id' => $request->input('ticket_id'),
                'user_id' => Auth::user()->id,
                'cust_id' => null,
                'comment' => $request->input('comment')
            ]);
            foreach ($request->input('comments', []) as $file) {
                $comment->addMedia(public_path('uploads/comment/' . $file))->toMediaCollection('comments');
            }
            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $ticket->status = 'Closed';
            $ticket->replystatus = $request->input('status');
            // Auto Close Ticket
            $ticket->auto_close_ticket = null;
            // Auto Response Ticket
            $ticket->auto_replystatus = null;
            $ticket->last_reply = now();
            $ticket->closing_ticket = now();
            $ticket->update();

            $cust = Customer::find($ticket->cust_id);
            $cust->notify(new TicketCreateNotifications($ticket));
           
            if($ticket->cust->userType == 'Guest'){
                $ticketData = [
                    'ticket_username' => $ticket->cust->username,
                    'ticket_title' => $ticket->subject,
                    'ticket_id' => $ticket->ticket_id,
                    'comment' => $comment->comment,
                    'ratinglink' => route('guest.rating', $ticket->ticket_id),
                    'ticket_customer_url' => route('gusetticket', $ticket->ticket_id),
                    'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
                ];
            }
            if($ticket->cust->userType == 'Customer'){
                $ticketData = [
                    'ticket_username' => $ticket->cust->username,
                    'ticket_title' => $ticket->subject,
                    'ticket_id' => $ticket->ticket_id,
                    'comment' => $comment->comment,
                    'ratinglink' => route('guest.rating', $ticket->ticket_id),
                    'ticket_customer_url' => route('loadmore.load_data', $ticket->ticket_id),
                    'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
                ];
            }
            
    
            try{
    
                Mail::to($ticket->cust->email)
                ->send( new mailmailablesend( 'customer_rating', $ticketData) );
            
            }catch(\Exception $e){
                return redirect()->back()->with("success", trans('langconvert.functions.ticketreply'));
            }

            return redirect()->back()->with("success", trans('langconvert.functions.ticketreply'));

        }else{
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
                'user_id' => Auth::user()->id,
                'cust_id' => null,
                'comment' => $request->input('comment'),
                'display' => 1,
            ]);
            foreach ($request->input('comments', []) as $file) {
                $comment->addMedia(public_path('uploads/comment/' . $file))->toMediaCollection('comments');
            }
            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $ticket->status = $request->input('status');
            $ticket->replystatus = null;
            if($request->status == 'On-Hold'){
                $ticket->note = $request->input('note');
                // Auto Close Ticket
                $ticket->auto_close_ticket = null;
                // Auto Response Ticket
                $ticket->auto_replystatus = null;
            }
            else{
                // Auto Closing Ticket
                if(setting('AUTO_CLOSE_TICKET') == 'no'){
                    $ticket->auto_close_ticket = null;
                }else{
                    if(setting('AUTO_CLOSE_TICKET_TIME') == '0'){
                        $ticket->auto_close_ticket = null;
                    }else{
                        if(Auth::check() && Auth::user()){
                            if($ticket->status == 'Closed'){
                                $ticket->auto_close_ticket = null;
                            }
                            else{
                                $ticket->auto_close_ticket = now()->addDays(setting('AUTO_CLOSE_TICKET_TIME'));
                            }
                        } 
                    }
                }
                // End Auto Close Ticket

                // Auto Response Ticket

                if(setting('AUTO_RESPONSETIME_TICKET') == 'no'){
                    $ticket->auto_replystatus = null;
                }else{
                    if(setting('AUTO_RESPONSETIME_TICKET_TIME') == '0'){
                        $ticket->auto_replystatus = null;
                    }else{
                        if(Auth::check() && Auth::user()){
                            $ticket->auto_replystatus = now()->addHours(setting('AUTO_RESPONSETIME_TICKET_TIME'));
                        } 
                    }
                }
                // End Auto Response Ticket
            }
            $ticket->last_reply = now();
            $ticket->update();

            $cust = Customer::find($ticket->cust_id);
            $cust->notify(new TicketCreateNotifications($ticket));

            if($ticket->cust->userType == 'Guest'){
                $ticketData = [
                    'ticket_username' => $ticket->cust->username,
                    'ticket_title' => $ticket->subject,
                    'ticket_id' => $ticket->ticket_id,
                    'comment' => $comment->comment,
                    'ratinglink' => route('guest.rating', $ticket->ticket_id),
                    'ticket_customer_url' => route('gusetticket', $ticket->ticket_id),
                    'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
                ];
            }
            if($ticket->cust->userType == 'Customer'){
                $ticketData = [
                    'ticket_username' => $ticket->cust->username,
                    'ticket_title' => $ticket->subject,
                    'ticket_id' => $ticket->ticket_id,
                    'comment' => $comment->comment,
                    'ratinglink' => route('guest.rating', $ticket->ticket_id),
                    'ticket_customer_url' => route('loadmore.load_data', $ticket->ticket_id),
                    'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
                ];
            }
    
            try{
    
                Mail::to($ticket->cust->email)
                ->send( new mailmailablesend( 'customer_send_ticket_reply', $ticketData) );
            
            }catch(\Exception $e){
                return redirect()->back()->with("success", trans('langconvert.functions.ticketreply'));
            }

            return redirect()->back()->with("success", trans('langconvert.functions.ticketreply'));
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
            return redirect()->back();

        }else{
            $this->validate($request, [
                'editcomment' => 'required'
            ]);
            $comment = Comment::findOrFail($id);
            $comment->comment = $request->input('editcomment');
            
            $comment->update(); 
            return redirect()->back();
        }

       
    }
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ticket_id)
    {
        
    }

    public function imagedestroy($id)
    {   //For Deleting Users
        $commentss = Media::findOrFail($id);
        $commentss->delete();
        return response()->json([
            'success' => trans('langconvert.functions.ticketreply')
        ]);
    }

    public function reopenticket(Request $req){

        $reopenticket = Ticket::find($req->reopenid);
        $reopenticket->status = 'Re-Open';
        $reopenticket->replystatus = null;
        $reopenticket->update();


        $cust = Customer::with('custsetting')->find($reopenticket->cust_id);
        $cust->notify(new TicketCreateNotifications($reopenticket));
        
        if($ticket->cust->userType == 'Guest'){
            $ticketData = [
                'ticket_username' => $ticket->cust->username,
                'ticket_title' => $ticket->subject,
                'ticket_id' => $ticket->ticket_id,
                'comment' => $comment->comment,
                'ratinglink' => route('guest.rating', $ticket->ticket_id),
                'ticket_customer_url' => route('gusetticket', $ticket->ticket_id),
                'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
            ];
        }
        if($ticket->cust->userType == 'Customer'){
            $ticketData = [
                'ticket_username' => $ticket->cust->username,
                'ticket_title' => $ticket->subject,
                'ticket_id' => $ticket->ticket_id,
                'comment' => $comment->comment,
                'ratinglink' => route('guest.rating', $ticket->ticket_id),
                'ticket_customer_url' => route('loadmore.load_data', $ticket->ticket_id),
                'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
            ];
        }

        try{

            Mail::to($reopenticket->cust->email )
            ->send( new mailmailablesend( 'customer_send_ticket_reopen', $ticketData ) );

            
        
        }catch(\Exception $e){
            return response()->json([
                'success' => trans('langconvert.functions.ticketreopen'),
            ]);
        }
        return response()->json([
            'success' => trans('langconvert.functions.ticketreopen'),
        ]);
        
    }

}