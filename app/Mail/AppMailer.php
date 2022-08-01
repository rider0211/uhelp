<?php

namespace App\Mail;

use App\Models\Ticket\Ticket;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{
    protected $mailer;
    protected $fromName = 'Support Ticket';
    protected $to;
    protected $subject;
    protected $view;
    protected $data = [];

    /**
     * AppMailer constructor.
     * @param $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTicketInformation($user, Ticket $ticket)
    {
        $this->to = $user->email;

        $this->subject = "[Ticket ID: $ticket->ticket_id] $ticket->title";

        $this->view = 'user.ticket.emailticket.ticket_info';

        $this->data = compact('user', 'ticket');

        return $this->deliver();
    }

    public function sendTicketComments($ticketOwner, $user, Ticket $ticket, $comment)
    {
        $this->to = $ticketOwner->email;
        $this->subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";
        $this->view = 'user.ticket.emailticket.ticket_comments';
        $this->data = compact('ticketOwner', 'user', 'ticket', 'comment');
    
        return $this->deliver();
    }
   /**
	 * Send ticket status notification
	 * 
	 * @param  User   $ticketOwner
	 * @param  Ticket  $ticket
	 * @return method deliver()
	 */
	public function sendTicketStatusNotification($ticketOwner, Ticket $ticket)
	{
		$this->to = $ticketOwner->email;
		$this->subject = "RE: $ticket->title (Ticket ID: $ticket->ticket_id)";
		$this->view = 'user.ticket.emailticket.ticket_status';
		$this->data = compact('ticketOwner', 'ticket');

		return $this->deliver();
	}
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message){

            $message->from(env('MAIL_USERNAME'), $this->fromName)
                    ->to($this->to)->subject($this->subject);

        });
    }
}