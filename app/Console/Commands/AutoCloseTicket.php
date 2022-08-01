<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Ticket\Ticket;
use Mail;
use App\Mail\mailmailablesend;
use App\Mail\VerifyMail;
use Auth;

class AutoCloseTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:autoclose';

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
        
        $autocloses = Ticket::where('auto_close_ticket', '<=', now())->get();
        foreach($autocloses as $autoclose){
            if($autoclose->replystatus == 'Solved'){
                $autoclose->status = 'Closed';
                $autoclose->closing_ticket = now();
                $autoclose->auto_close_ticket = null;
            }else{
                $autoclose->status = 'Closed';
                $autoclose->replystatus = 'Unanswered';
                $autoclose->closing_ticket = now();
                $autoclose->auto_close_ticket = null;
            }
            $autoclose->update();

            $ticketData = [
                'ticket_username' => $autoclose->cust->username,
                'ticket_id' => $autoclose->ticket_id,
                'ticket_title' => $autoclose->subject,
                'ticket_description' => $autoclose->message,
                'ticket_status' => $autoclose->status,
                'ticket_customer_url' => route('loadmore.load_data', $autoclose->ticket_id),
                'ticket_admin_url' => url('/admin/ticket-view/'.$autoclose->ticket_id),
            ];
    
            try{
                Mail::to($autoclose->cust->email)
                ->send( new mailmailablesend( 'customer_send_ticket_autoclose', $ticketData ) );
            }
            catch(\Exception $e){
                //
            }

            $cust = Customer::find($autoclose->cust_id);
            $cust->notify(new TicketCreateNotifications($autoclose));
        }

    }

}
