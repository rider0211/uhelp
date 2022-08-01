<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Ticket\Ticket;
use App\Models\Customer;
use App\Models\User;
use App\Models\CustomerSetting;

use Mail;
use App\Mail\mailmailablesend;
use App\Notifications\TicketCreateNotifications;

class EmailtoTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imap:emailticket';

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
        if(setting('IMAP_STATUS') == 'on'){
            $client = \Webklex\IMAP\Facades\Client::make([
                'host'          => setting('IMAP_HOST'),
                'port'          => setting('IMAP_PORT'),
                'encryption'    => setting('IMAP_ENCRYPTION'),
                'validate_cert' => true,
                'username'      => setting('IMAP_USERNAME'),
                'password'      => setting('IMAP_PASSWORD'),
                'protocol'      => setting('IMAP_PROTOCOL')
            ]);
            $client->connect();
            $aFolder = $client->getFolders();
    
            foreach($aFolder as $folder){
                foreach($folder->messages()->unseen()->get() as $message){
                   
                    $userexits = Customer::where('email', $message->getFrom()[0]->mail)->count();
                    if($userexits == 1){
                        $guest = Customer::where('email', $message->getFrom()[0]->mail)->first();
                       
                    }else{
                        $guest = Customer::create([
    
                            'firstname' => '',
                            'lastname' => '',
                            'username' => 'GUEST',
                            'email' => $message->getFrom()[0]->mail,
                            'userType' => 'Guest',
                            'password' => null,
                            'country' => '',
                            'timezone' => 'UTC',
                            'status' => '1',
                            'image' => null,
            
                        ]);
                        $customersetting = new CustomerSetting();
                        $customersetting->custs_id = $guest->id;
                        $customersetting->save();
                    }
                    $body = $message->getHTMLBody(true);
                    $stripped_body = strip_tags($body);
    
                    $ticket = Ticket::create([
                        'subject' => $message->getSubject(),
                        'cust_id' => $guest->id,
                        'category_id' => null,
                        'priority' => null,
                        'message' => $stripped_body,
                        'status' => 'New',
                    ]);
                    $ticket = Ticket::find($ticket->id);
                    $ticket->ticket_id = setting('CUSTOMER_TICKETID').'G-'.$ticket->id;
                    $ticket->auto_overdue_ticket = now()->addDays(setting('AUTO_OVERDUE_TICKET_TIME'));
                    $ticket->update();
                    foreach(User::all() as $user){
                        $user->notify(new TicketCreateNotifications($ticket));
                    }
                    
                    $ticketData = [
                        'ticket_username' => $ticket->cust->username,
                        'ticket_title' => $ticket->subject,
                        'ticket_description' => $ticket->message,
                        'ticket_customer_url' => route('gusetticket', $ticket->ticket_id),
                        'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
                    ];
                    try{
            
                        Mail::to($ticket->cust->email)
                        ->send( new mailmailablesend( 'customer_send_guestticket_created', $ticketData ) );
                    
                    }catch(\Exception $e){
                        
                    }
                    $message->setFlag('SEEN');
                }
            }
        }
    }
}
