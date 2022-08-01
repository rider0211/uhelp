<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket\Ticket;
use App\Models\User;
use Mail;
use App\Mail\mailmailablesend;
use App\Mail\VerifyMail;
use Auth;

class AutoOverdueTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:autooverdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $autooverdues = Ticket::where('auto_overdue_ticket', '<=', now())->get();

        foreach($autooverdues as $autooverdue){
            $autooverdue->overduestatus = 'Overdue';
            $autooverdue->auto_overdue_ticket = null;
        
            $autooverdue->update();

            $ticketData = [
                'ticket_title' => $autooverdue->subject,
                'ticket_overduetime' => setting('AUTO_OVERDUE_TICKET_TIME'),
                'ticket_id' => $autooverdue->ticket_id,
                'ticket_description' => $autooverdue->message,
                'ticket_status' => $autooverdue->status,
                'ticket_customer_url' => route('loadmore.load_data', $autooverdue->ticket_id),
                'ticket_admin_url' => url('/admin/ticket-view/'.$autooverdue->ticket_id),
            ];

            try{

                Mail::to($autooverdue->cust->email)
                ->send( new mailmailablesend( 'customer_send_ticket_overdue', $ticketData ) );
            
            }catch(\Exception $e){
                //
            }

            $icc = '';
            $notificationcat = $ticket->category->groupscategoryc()->get();

            if($notificationcat->isNotEmpty()){

                foreach($notificationcat as $igc){
                        
                    foreach($igc->groupsc->groupsuser()->get() as $user){
                        $icc = $user->users_id;
                    }
                }
            }
            
            if($icc == ''){
                foreach(User::where('id','!=', $icc)->get() as $user){
                    $user->notify(new TicketCreateNotifications($autooverdue));
                }
            }else{
                $user = User::whereIn('id', ['1',$icc])->get();
                foreach($user as $users){
                    $users->notify(new TicketCreateNotifications($autooverdue));
                }
                
            }
        }
        
    }
}
