<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket\Ticket;
use Mail;
use App\Mail\mailmailablesend;
use App\Mail\VerifyMail;
use Auth;
use Carbon\Carbon;

class AutoResponseTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:autoresponseticket';

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
        $responsetimes = Ticket::where('auto_replystatus', '<=',Carbon::now())->get();

        foreach($responsetimes as $responsetime){
            $responsetime->replystatus = 'Waiting for response';
            $responsetime->auto_replystatus = null;
            $responsetime->update();
        
            $ticketData = [
                'ticket_username' => $responsetime->cust->username,
                'ticket_closingtime' => setting('AUTO_CLOSE_TICKET_TIME'),
                'ticket_title' => $responsetime->subject,
                'ticket_id' => $responsetime->ticket_id,
                'ticket_description' => $responsetime->message,
                'ticket_status' => $responsetime->status,
                'replystatus' => $responsetime->replystatus,
                'ticket_customer_url' => route('loadmore.load_data', $responsetime->ticket_id),
                'ticket_admin_url' => url('/admin/ticket-view/'.$responsetime->ticket_id),
            ];

            try{

                Mail::to($responsetime->cust->email)
                ->send( new mailmailablesend( 'customer_send_ticket_response', $ticketData ) );
            
            }catch(\Exception $e){
                //
            }
            $cust = Customer::find($responsetime->cust_id);
            $cust->notify(new TicketCreateNotifications($responsetime));
        }
    }
}
