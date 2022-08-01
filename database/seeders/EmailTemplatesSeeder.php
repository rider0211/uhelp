<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_templates')->insert([

            [
                'code' => 'customer_sendmail_contactus',
                'title' => 'Customer receives e-mail from Admin for submitting Contact_us form',
                'subject' => 'Thank you for contacting us.',
                'body' => '<p class="root-block-node" data-paragraphid="16" data-from-init="true" data-changed="false">Dear {{Contact_name}},</p>
                <p class="root-block-node" data-paragraphid="17" data-from-init="true" data-changed="false">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Thanks for your kind information shared with our support. Our team will respond shortly.</p><p class="root-block-node" data-paragraphid="17" data-from-init="true" data-changed="false"><br></p>
                <p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p>
                <p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'code' => 'admin_sendmail_contactus',
                'title' => 'Admin receives e-mails from Customers through Contact_us form',
                'subject' => 'Received new contact details from a new user.',
                'body' => '<p class="root-block-node" data-paragraphid="16" data-from-init="true" data-changed="false">Dear Admin,</p><p class="root-block-node" data-paragraphid="16" data-from-init="true" data-changed="false">&nbsp; &nbsp;Received the new contact information from the new c<span class="red-underline" data-startindex="56" data-endindex="60" data-paragraphid="21">ustomer.</span></p><p>&nbsp; &nbsp;Name: {{Contact_name}}</p><p>&nbsp; &nbsp;Email: {{Contact_email}}</p><p>&nbsp; &nbsp;Phone Number: {{Contact_phone}}</p><p>&nbsp; &nbsp;Subject: {{Contact_subject}}</p><p>&nbsp; &nbsp;Message:{{Contact_message}}</p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'code' => 'customer_sendmail_verification',
                'title' => 'Receives e-mail, when users get registered with app',
                'subject' => 'Thanks you for registering. Please verify your email.',
                'body' => '<p class="root-block-node" data-paragraphid="16" data-from-init="true" data-changed="false">Dear {{username}},</p><p>
                </p><p class="root-block-node" data-paragraphid="23" data-from-init="true" data-changed="false"><span class="red-underline" data-startindex="0" data-endindex="2" data-paragraphid="23">&nbsp; &nbsp;</span>Thank you for registering as our customer. Be part of our family. Before you log in to your portal, please verify your email by clicking this&nbsp;link:-&nbsp;<a href="{{email_verify_url}}" style="color: var(--primary); background-color: rgb(255, 255, 255); outline: 0px;">VerifyLink</a>.</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // New Ticket is creating
            [
                'code' => 'customer_send_ticket_created',
                'title' => 'Send email to customer, when Ticket is Created!',
                'subject' => 'We received your ticket successfully',
                'body' => '<p>Dear {{ticket_username}},</p><p><br></p><p>We would like to acknowledge that we have received your request and a ticket has been created.</p><p>A support representative will be reviewing your request and will send you a personal response.(usually within 24 hours).</p><p><br></p><p>To view the status of the ticket or add comments, please visit</p><p><a href="{{ticket_customer_url}}" target="_blank">{{ticket_customer_url}}</a></p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p><p>Thank you for your patience.</p><p><br></p><p>Sincerely,</p><p>Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'admin_send_email_ticket_created',
                'title' => 'Send email to admin, when Ticket is Created!',
                'subject' => 'New ticket is created',
                'body' => '<p>Dear Admin,</p><p>A ticket has been created with Ticket ID {{ticket_id}}.&nbsp;<br></p><p>Assign the ticket to support representatives who will be reviewing the request.</p><p>To view the status of the ticket or add comments, please visit</p><p><a href="{{ticket_admin_url}}" target="_blank">{{ticket_admin_url}}</a></p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // When ticke get reply by Admin
            [
                'code' => 'customer_send_ticket_reply',
                'title' => 'Send email to customer, when he/she gets reply to ticket',
                'subject' => 'You got replay for the ticket',
                'body' => '<p>Our support representatives have started reviewing your request. </p><p>Please visit the application to&nbsp;<a href="{{ticket_customer_url}}" style="background-color: rgb(255, 255, 255);">ViewTicket</a></p><p>Thank you for reaching us</p><p>Your Ticket Title: {{ticket_title}}<br></p><p>Your Ticket ID: {{ticket_id}}</p><p>Admin Last Reply: {{comment}}</p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // When ticke get closed  by Admin
            [
                'code' => 'customer_rating',
                'title' => 'Customer Rating For Agents',
                'subject' => 'Your ticket has been closed succesfully',
                'body' => '<p class="root-block-node" data-paragraphid="33" data-from-init="true" data-changed="false">Dear {{ticket_username}},</p><p class="root-block-node" data-paragraphid="34" data-from-init="true" data-changed="false">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Your ticket has been closed by our team support. We’re always looking for ways to improve and would love to know how we did recently. How would you rate our support?</p><p class="root-block-node" data-paragraphid="34" data-from-init="true" data-changed="false">How would you rate the support you received?</p><p>Please click on the link to rate us:&nbsp;<a href="{{ratinglink}}">Click here</a></p><p class="root-block-node" data-changed="false" data-paragraphid="45"><br></p><p class="root-block-node" data-changed="false" data-paragraphid="45">Sincerely,<br></p><p class="root-block-node" data-changed="false" data-paragraphid="45">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // When Customer is Reopen the ticket 
            [
                'code' => 'customer_send_ticket_reopen',
                'title' => 'Send email to customer, when Ticket is Reopen!',
                'subject' => 'Your ticket has been reOpened succesfully',
                'body' => '<p>Thank you for reaching us again&nbsp;</p><p>Our support representatives will be reviewing your request again and will send you a personal response within 1-2 business working days.<br></p><p><br> Title : {{ticket_title}}<br>Ticket URL : <a href="{{ticket_customer_url}}">VIEW Ticket</a></p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // forgot password link user & admin
            
             [
                'code' => 'forget_password',
                'title' => 'when customer/admin or any user forgets password',
                'subject' => 'Password Reset Email Link',
                'body' => '<p>															</p><p class="root-block-node" data-paragraphid="51" data-from-init="true" data-changed="false">Hi there,</p><p class="root-block-node" data-paragraphid="52" data-from-init="true" data-changed="false">To regain access to your password</p><p class="root-block-node" data-paragraphid="53" data-from-init="true" data-changed="false">It looks like you lost your password.</p>Please click the below link to reset your account password. <p></p><p><a href="{{reset_password_url}}">Reset Password</a>&nbsp;</p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>
                ',
                'created_at' => now(),
                'updated_at' => now()
            ], 

            // When admin creates a customerthen send email to Customer email

            [
                'code' => 'customer_send_registration_details',
                'title' => 'Send email to customers, when customers are created by admin',
                'subject' => 'The administrator created your account. ',
                'body' => '<p>Dear {{username}},</p><p>Your account has been successfully created by our support team.</p><p>Please visit the URL {{url}} and use the below credentials to access your account.</p><p> Email : {{useremail}}<br>Name : {{username}}<br>Password : {{userpassword}}</p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
                /// When admin creates a employee then send email to employee email
            [
                'code' => 'employee_send_registration_details',
                'title' => 'Send email to employees, when employees created by admin',
                'subject' => 'The administrator created your account. ',
                'body' => '<p>Dear {{username}},</p><p>Your account has been successfully created by your admin.</p><p>Please visit the URL {{url}} and use the below credentials to access your account.</p><p> Email : {{useremail}}<br>Name : {{username}}<br>Password : {{userpassword}}</p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
                // When admin createa guest ticket send a email to customer or requested email
            [
                'code' => 'customer_send_guestticket_created',
                'title' => 'Send email to customer, when GuestTicket is Created!',
                'subject' => 'We received your guest ticket successfully',
                'body' => '<p>Dear {{ticket_username}},</p><p><br></p><p>We would like to acknowledge that we have received your request and a gust ticket has been created.</p><p>A support representative will be reviewing your request and will send you a personal response 1-2 bussiness days.</p><p><br></p><p>To view the status of the ticket or add comments, please visit</p><p><a href="{{ticket_customer_url}}" target="_blank">{{ticket_customer_url}}</a></p><p><br></p><p>Thank you for your patience.</p><p><br></p><p>Sincerely,</p><p>Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],

            
            [
                'code' => 'customer_send_ticket_overdue',
                'title' => 'Send email to customer, when Ticket is Overdue!',
                'subject' => 'This ticket status has been overdue.',
                'body' => '<p class="root-block-node" data-paragraphid="2" data-from-init="true" data-changed="false">Dear Admin,</p><p>
                </p><p class="root-block-node" data-paragraphid="10" data-from-init="true" data-changed="false">This ticket status has been overdue for {{ticket_overduetime}} days. </p><p class="root-block-node" data-paragraphid="10" data-from-init="true" data-changed="false">Please give attention to the ticket. The customer is waiting for your response.</p><p class="root-block-node" data-paragraphid="10" data-from-init="true" data-changed="false"><br></p><p> Title : {{ticket_title}}<br>Ticket URL : <a href="{{ticket_admin_url}}">VIEW Ticket</a></p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],[
                'code' => 'customer_send_ticket_response',
                'title' => 'When the customer does not respond to the ticket, an email is sent to the customer.',
                'subject' => 'Waiting for a response to your ticket from our team.',
                'body' => '<p>Dear {{ticket_username}},<br></p><p class="root-block-node" data-paragraphid="6" data-from-init="true" data-changed="false">Your ticket is in an idle state. Our team is waiting for your response.</p><p class="root-block-node" data-paragraphid="6" data-from-init="true" data-changed="false">If you do not respond to this ticket (ticket_id), it will be automatically closed after {{ticket_closingtime}} days.</p><p class="root-block-node" data-paragraphid="2" data-from-init="true" data-changed="false">
                </p><p class="root-block-node" data-paragraphid="8" data-from-init="true" data-changed="true">Please check your ticket by clicking here.</p><p class="root-block-node" data-paragraphid="8" data-from-init="true" data-changed="true"><br></p><p> Title : {{ticket_title}}<br>Ticket URL : <a href="{{ticket_customer_url}}">VIEW Ticket</a></p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => 'customer_send_ticket_autoclose',
                'title' => 'Send email to customer, when Ticket is Autoclose!',
                'subject' => 'Your Ticket has been Closed Succesfully',
                'body' => '<p class="root-block-node" data-paragraphid="2" data-from-init="true" data-changed="false">Dear {{ticket_username}},</p><p class="root-block-node" data-paragraphid="11" data-from-init="true" data-changed="false">Your ticket has been closed successfully because there was no response from your end, so the ticket was closed automatically&nbsp;(ticket_id).&nbsp;</p><p class="root-block-node" data-paragraphid="12" data-from-init="true" data-changed="false">If you want to reopen this ticket, please log in to your portal.</p><p> Title : {{ticket_title}}<br>Ticket URL : <a href="{{ticket_customer_url}}">VIEW Ticket</a></p><p><br></p><p class="root-block-node" data-paragraphid="19" data-from-init="true" data-changed="false">Sincerely,</p><p class="root-block-node" data-paragraphid="20" data-from-init="true" data-changed="false">Support Team</p>',
                'created_at' => now(),
                'updated_at' => now()
            ],


        ]);
    }
}
