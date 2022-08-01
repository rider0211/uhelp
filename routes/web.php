<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleReplyController;
use App\Http\Controllers\Contactform\ContactController;
use App\Http\Controllers\CategorypageController;

use App\Http\Controllers\GuestticketController;
use App\Http\Controllers\User\Ticket\CommentsController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include('installer.php');


Route::middleware(ProtectAgainstSpam::class)->group(function() {

	Route::middleware(['checkinstallation'])->group(function () {


		Route::middleware(['admincountryblock','throttle:refresh', 'ipblockunblock'])->group(function () {
		

			Route::group(['namespace' => 'Admin', 'prefix'	 => 'admin'], function () {

				Auth::routes([
					'register'	=>	false
				]);
				Route::get('/change-password', 'ChangepasswordController@index');
				Route::post('/change-password', 'ChangepasswordController@changePassword');
				
				Route::middleware('auth','admin.auth')->group( function () {
					Route::get('/mark-as-read', 'AdminDashboardController@markNotification')->name('admin.markNotification');

					Route::get('/', 'AdminDashboardController@index');
					Route::get('/activeticket', 'AdminDashboardController@activeticket')->name('admin.activeticket');
					Route::get('/closedticket', 'AdminDashboardController@closedticket')->name('admin.closedticket');
					Route::get('/assignedtickets', 'AdminDashboardController@assignedTickets');
					Route::get('/myassignedtickets', 'AdminDashboardController@myassignedTickets');
					Route::get('/onholdtickets', 'AdminDashboardController@onholdticket')->name('admin.onholdticket');
					Route::get('/overduetickets', 'AdminDashboardController@overdueticket')->name('admin.overdueticket');
					Route::get('/categories', 'CategoriesController@index')->name('categorys.index');
					Route::post('/categories/create', 'CategoriesController@store');
					Route::get('/categories/{id}/edit', 'CategoriesController@show');
					Route::get('/categories/status{id}', 'CategoriesController@status');
					Route::get('/categoryassigned/{id}', 'CategoriesController@agentshow');
					Route::get('/category/list/{ticket_id}', 'CategoriesController@categorylist');
					Route::get('/categorylist', 'CategoriesController@categorylistshow');
					Route::post('/categoryenvatoassign', 'CategoriesController@categoryenvatoassign');
					Route::post('/category/change/', 'CategoriesController@categorychange');
					Route::post('/category/all/', 'CategoriesController@categorygetall')->name('category.admin.all');
					Route::get('/subcategories', 'CategoriesController@subcategoryindex')->name('subcategorys.index');
					Route::post('/subcategories', 'CategoriesController@subcategorystore')->name('subcategorys.store');
					Route::get('/subcategories/{id}/edit', 'CategoriesController@subcategoryshow')->name('subcategorys.show');
					Route::post('/subcategory/status/', 'CategoriesController@subcategorystatusupdate')->name('category.admin.subcategorystatusupdate');
					Route::post('/subcategory/delete/', 'CategoriesController@subcategorydelete')->name('category.admin.subcategorydelete');
					Route::get('/groupassigned/{id}', 'CategoriesController@groupshow');
					Route::post('/groupcategory/group', 'CategoriesController@categorygroupassign');
					Route::post('/assignedcategory/createagent', 'CategoriesController@agentshowcreate');
					Route::get('/categories/{id}', 'CategoriesController@destroy')->name('delete');
					Route::get('/profile', 'AdminprofileController@index');
					Route::get('/profile/edit', 'AdminprofileController@profileedit');
					Route::post('/profile', 'AdminprofileController@profilesetup');
					Route::post('/image/remove/{id}', 'AdminprofileController@imageremove');
					Route::get('/article', 'ArticlesController@index');
					Route::post('/article', 'ArticlesController@article');
					Route::get('/article/create', 'ArticlesController@create');
					Route::post('/article/create', 'ArticlesController@store');
					Route::post('/article/imageupload', 'ArticlesController@storeMedia')->name('admin.imageupload');
					Route::post('/article/featureimageupload', 'ArticlesController@featureimagestoreMedia')->name('admin.featureimageupload');
					Route::get('/article/{id}/edit', 'ArticlesController@show')->name('admin.article');
					Route::post('/article/{id}/edit', 'ArticlesController@update');
					Route::get('/article/{id}', 'ArticlesController@destroy');
					Route::get('/massarticle/delete', 'ArticlesController@articlemassdestroy');
					Route::post('/article/status{id}', 'ArticlesController@status');
					Route::post('/article/privatestatus/{id}', 'ArticlesController@privatestatus');
					Route::post('/article/featureimage/{id}', 'ArticlesController@featureimage');
					Route::get('/employee', 'AgentCreateController@index')->name('employee');
					Route::get('/employee/create', 'AgentCreateController@create');
					Route::post('/agent', 'AgentCreateController@store');
					Route::get('/agentprofile/{id}', 'AgentCreateController@show');
					Route::post('/agentprofile/{id}', 'AgentCreateController@update');
					Route::get('/userimport', 'AgentCreateController@userimportindex')->name('user.userimport');
					Route::post('/agent/{id}', 'AgentCreateController@destroy');
					Route::post('/massuser/deleteall', 'AgentCreateController@usermassdestroy');
					Route::post('/agent/status/{id}', 'AgentCreateController@status');
					Route::get('/ticket/{ticket_id}', 'AdminTicketController@destroy');
					Route::post('/priority/change/', 'AdminTicketController@changepriority');
					Route::get('/ticket/delete/tickets', 'AdminTicketController@ticketmassdestroy')->name('admin.ticket.sremove');
					Route::get('/ticket-view/{ticket_id}', 'AdminTicketController@show')->name('admin.ticketshow');
					Route::post('/ticket-comment/{ticket_id}', 'AdminTicketController@commentshow')->name('admin.ticketcomment');
					Route::post('/ticket/{ticket_id}', 'CommentsController@postComment');
					Route::post('/ticket/imageupload/{ticket_id}', 'CommentsController@storeMedia');
					Route::post('/closed/{ticket_id}', 'AdminTicketController@close');
					Route::get('/delete-ticket/{id}', 'AdminTicketController@destroy');
					Route::post('/ticket/editcomment/{id}', 'CommentsController@updateedit');
					Route::delete('/image/delete/{id}', 'CommentsController@imagedestroy');
					Route::post('/ticket/reopen/{id}', 'CommentsController@reopenticket');
					Route::get('/roleaccess', 'PermissionstatusController@index')->name('ajaxproducts.index');
					Route::get('/roleaccess/{id}/edit', 'PermissionstatusController@edit');
					Route::post('/roleaccess/{id}/edit', 'PermissionstatusController@update');
					Route::get('/faq', 'FAQController@index')->name('faq.index');
					Route::post('/faq', 'FAQController@faq');
					Route::post('/faq/create', 'FAQController@store');
					Route::get('/faq/{id}', 'FAQController@show');
					Route::delete('/faq/delete/{id}', 'FAQController@destroy');
					Route::post('/faq/deleteall', 'FAQController@allfaqdelete')->name('faq.deleteall');
					Route::post('/faq/status{id}', 'FAQController@status');
					Route::post('/faq/privatestatus/{id}', 'FAQController@privatestatus');
					Route::get('/testimonial', 'TestimonialController@index');
					Route::post('/testimonial/create', 'TestimonialController@store');
					Route::post('/testimonial', 'TestimonialController@testi');
					Route::get('/testimonial/{id}', 'TestimonialController@show');
					Route::get('/testimonial/delete/{id}', 'TestimonialController@destroy');
					Route::post('/testimonial/deleteall', 'TestimonialController@alltestimonialdelete')->name('testimonial.deleteall');
					Route::get('/call-to-action', 'CalltoactionController@index');
					Route::post('/call-to-action', 'CalltoactionController@store');
					Route::get('/feature-box', 'FeatureBoxController@index');
					Route::post('/feature-box/feature', 'FeatureBoxController@feature');
					Route::post('/feature-box/create', 'FeatureBoxController@store');
					Route::get('/feature-box/{id}', 'FeatureBoxController@show');
					Route::get('/feature-box/delete/{id}', 'FeatureBoxController@destroy');
					Route::post('/featurebox/deleteall', 'FeatureBoxController@allfeaturedelete')->name('featurebox.deleteall');
					Route::get('/general', 'ApptitleController@index');
					Route::get('/bannersetting', 'ApptitleController@bannerpage');
					Route::post('/general', 'ApptitleController@store');
					Route::post('/bannerstore', 'ApptitleController@bannerstore');
					Route::post('/footer', 'ApptitleController@footerstore');
					Route::post('/logodelete', 'ApptitleController@logodelete')->name('admin.logodelete');
					Route::get('/seo', 'SeopageController@index');
					Route::post('/seo/create', 'SeopageController@store');
					Route::post('/assigned/create', 'AdminAssignedticketsController@create');
					Route::get('/assigned/{id}', 'AdminAssignedticketsController@show');
					Route::post('/ticket-view/ticketassigneds/{id}', 'AdminAssignedticketsController@show');
					Route::get('/assigned/update/{id}', 'AdminAssignedticketsController@update');
					Route::get('/announcement', 'AdminAnnouncementController@index');
					Route::post('/announcement/create', 'AdminAnnouncementController@store');
					Route::get('/announcement/{id}', 'AdminAnnouncementController@show');
					Route::get('/announcement/delete/{id}', 'AdminAnnouncementController@destroy');
					Route::post('/massannouncedelete', 'AdminAnnouncementController@allannouncementdelete')->name('announcementall.delete');
					Route::post('/announcement/status{id}', 'AdminAnnouncementController@status');
					Route::get('/emailsetting', 'AdminSettingController@email');
					Route::post('/emailsetting', 'AdminSettingController@emailstore')->name('settings.email.store');
					Route::get('/emailtemplates', 'AdminSettingController@emailtemplates');
					Route::get('/emailtemplates/{id}', 'AdminSettingController@emailtemplatesEdit')->name('settings.email.edit');
					Route::post('/emailtemplates/{id}', 'AdminSettingController@emailtemplatesUpdate')->name('settings.email.update');
					Route::get('/captcha', 'AdminSettingController@captcha')->name('settings.captcha');
					Route::post('/captcha', 'AdminSettingController@captchastore')->name('settings.captcha.store');
					Route::post('/captchatype', 'AdminSettingController@captchatypestore');
					Route::post('/captchacontact', 'AdminSettingController@captchacontact')->name('settings.captchacontact.store');
					Route::post('/captcharegister', 'AdminSettingController@captcharegister')->name('settings.captcharegister.store');
					Route::post('/captchalogin', 'AdminSettingController@captchalogin')->name('settings.captchalogin.store');
					Route::post('/captchaguest', 'AdminSettingController@captchaguest')->name('settings.captchaguest.store');
					Route::get('/sociallogin', 'AdminSettingController@sociallogin')->name('settings.sociallogin');
					Route::post('/sociallogin', 'AdminSettingController@socialloginupdate')->name('settings.sociallogin.update');
					Route::get('/ticketsetting', 'AdminSettingController@ticketsetting')->name('settings.ticket');
					Route::post('/ticketsetting', 'AdminSettingController@ticketsettingstore')->name('settings.ticket.store');
					Route::get('/languagesetting', 'AdminSettingController@languagesetting');
					Route::post('/languagesetting', 'AdminSettingController@languagesettingstore')->name('settings.lang.store');
					Route::post('/datetimeformat', 'AdminSettingController@datetimeformatstore')->name('settings.timedateformat.store');
					Route::get('/general/dark', 'ApptitleController@check');
					Route::get('/customer', 'AdminprofileController@customers');
					Route::post('/knowledge', 'AdminSettingController@knowledge')->name('settings.knowledge.store');
					Route::post('/profileuser', 'AdminSettingController@profileuser')->name('settings.profileuser.store');
					Route::post('/profileagent', 'AdminSettingController@profileagent')->name('settings.profileagent.store');
					Route::get('/customer/create', 'AdminprofileController@customerscreate');
					Route::post('/customer/create', 'AdminprofileController@customersstore');
					Route::get('/customer/{id}', 'AdminprofileController@customersshow');
					Route::get('/usersettings', 'AdminprofileController@usersetting');
					Route::post('/customer/{id}', 'AdminprofileController@customersupdate');
					Route::get('/customer/delete/{id}', 'AdminprofileController@customersdelete');
					Route::get('/masscustomer/delete', 'AdminprofileController@customermassdestroy');
					Route::get('/general/register', 'AdminSettingController@registerpopup');
					Route::get('/googleanalytics', 'AdminSettingController@googleanalytics');
					Route::post('/googleanalytics', 'AdminSettingController@googleanalyticsStore')->name('settings.googleanalytics');
					Route::post('/filesetting', 'AdminSettingController@filesettingstore')->name('settings.file.store');
					Route::post('/sendtestmail', 'AdminSettingController@sendTestMail')->name('settings.email.sendtestmail');
					Route::post('/colorsetting', 'AdminSettingController@frontendStore')->name('settings.color.colorsetting');
					Route::post('/urlset', 'AdminSettingController@seturl')->name('settings.url.urlset');
					Route::get('/customcssjssetting', 'CustomcssjsController@index');
					Route::post('/customcssjssetting', 'CustomcssjsController@customcssjs')->name('settings.custom.cssjs');
					Route::get('/customchatsetting', 'CustomcssjsController@customchat');
					Route::post('/customchatsetting', 'CustomcssjsController@customchats')->name('settings.custom.chat');
					Route::get('/error404', 'CustomerrorpagesController@index');
					Route::post('/error404', 'CustomerrorpagesController@store');
					Route::get('/maintenancepage', 'CustomerrorpagesController@maintenancepage');
					Route::post('/maintenancepage', 'CustomerrorpagesController@maintenancepagestore');
					Route::get('/createticket', 'AdminTicketController@createticket');
					Route::post('/createticket', 'AdminTicketController@gueststore');
					Route::post('/imageupload', 'AdminTicketController@guestmedia')->name('imageuploadadmin');
					Route::get('/myticket', 'AdminTicketController@mytickets');
					Route::get('/alltickets', 'AdminTicketController@alltickets')->name('admin.alltickets');
					Route::get('role','RoleCreateController@index');
					Route::get('role/create','RoleCreateController@create');
					Route::post('role/create','RoleCreateController@store');
					Route::get('role/edit/{id}','RoleCreateController@edit');
					Route::post('role/edit/{id}','RoleCreateController@update');
					Route::get('/pages', 'GeneralPageController@index');
					Route::post('/pages/create', 'GeneralPageController@store');
					Route::get('/pages/{id}', 'GeneralPageController@show');
					Route::post('/pagesdelete/{id}', 'GeneralPageController@destroy');
					Route::get('/groups','GroupCreateController@index');
					Route::get('/groups/create','GroupCreateController@create')->name('groups.create');
					Route::post('/groups/store','GroupCreateController@store');
					Route::get('/groups/view/{id}','GroupCreateController@show');
					Route::post('/groups/update/{id}','GroupCreateController@update');
					Route::post('/note/create', 'AdminTicketController@note');
					Route::get('/products/{ticket_id}', 'AdminTicketController@noteshow');
					Route::delete('/ticketnote/delete/{id}', 'AdminTicketController@notedestroy');
					Route::post('userimport', 'AgentCreateController@usercsv')->name('customer.ucsvimport');
					Route::post('projectimport', 'ProjectsController@projetcsv')->name('project.pcsvimport');
					Route::get('projectimport', 'ProjectsController@projetimport')->name('projects.pcsvimports');
					Route::get('maintenancemode', 'MaintanancemodeController@index');
					Route::post('maintenancemode', 'MaintanancemodeController@store')->name('maintanance');
					Route::get('/projects', 'ProjectsController@index')->name('projects');
					Route::get('/notifications', 'ProjectsController@notificationpage')->name('notificationpage');
					Route::post('/projects/create', 'ProjectsController@store')->name('projects.create');
					Route::get('/projects/{id}', 'ProjectsController@show')->name('projects.view');
					Route::get('/projects/delete/{id}', 'ProjectsController@destroy');
					Route::get('massproject/delete', 'ProjectsController@projectmassdestroy');
					Route::get('/projectsassigned', 'ProjectsController@projectlist');
					Route::post('/projectsassigned', 'ProjectsController@projectassignee');
					Route::post('subcat','AdminTicketController@sublist')->name('admin.subcat');
					Route::post('refresh/{id}', 'AdminDashboardController@autorefresh');
					Route::get('reports', 'AdminReportController@index');
					Route::get('customer/adminlogin/{id}', 'AdminprofileController@adminLogin');

					Route::group(['prefix' => 'customnotification'], function(){

						Route::get('/', 'MailboxController@index')->name('mail.index');
						Route::get('/customercompose', 'MailboxController@customercompose')->name('mail.customer');
						Route::post('/customercompose', 'MailboxController@customercomposesend')->name('mail.customersend');
						Route::get('/employeecompose', 'MailboxController@employeecompose')->name('mail.employee');
						Route::post('/employeecompose', 'MailboxController@employeecomposesend')->name('mail.employeesend');
						Route::get('/sentmail', 'MailboxController@mailsent')->name('mail.sendmail');
						Route::get('/{id}', 'MailboxController@show')->name('mail.show');
						Route::delete('delete/{id}', 'MailboxController@destroy')->name('mail.delete');
						Route::post('/massdelete', 'MailboxController@allnotifydelete')->name('notifyall.delete');

					});

					Route::get('securitysetting', 'SecuritySettingController@index');
					Route::post('securitysetting', 'SecuritySettingController@store')->name('settings.security.country');
					Route::post('adminsecuritysetting/', 'SecuritySettingController@adminstore')->name('settings.security.admin.country');
					Route::post('securitysetting/ip', 'SecuritySettingController@dosstore')->name('settings.security.ip');
					Route::get('ipblocklist', 'IpblockController@index')->name('ipblocklist');
					Route::get('ipblocklist/{id}', 'IpblockController@show')->name('ipblocklist.id');
					Route::post('ipblocklist/create', 'IpblockController@store')->name('ipblocklist.store');
					Route::delete('ipblocklist/delete/{id}', 'IpblockController@destroy')->name('ipblocklist.destroy');
					Route::post('ipblocklist/reset/{id}', 'IpblockController@resetipblock')->name('ipblocklist.reset');
					Route::post('/ipblocklist/deleteall', 'IpblockController@allipblocklistdelete')->name('ipblocklist.deleteall');
					Route::get('emailtotickets', 'SecuritySettingController@emailtoticket')->name('admin.emailtoticket');
					Route::post('emailticket', 'SecuritySettingController@emailticketstore')->name('admin.emaitickets');
					Route::get('language/{locale}', 'SecuritySettingController@setLanguage')->name('admin.front.set_language');


				});

			});

		});
	
		Route::middleware(['countrylistbub', 'throttle:refresh', 'ipblockunblock'])->group(function () {
			
		
			Route::group(['namespace' => 'User', 'prefix' => 'customer'], function(){

			

				Route::group(['namespace' => 'Auth'], function(){

					Route::get('/login', 'LoginController@showLoginForm')->middleware('guest:customer')->name('auth.login');
					Route::post('/login', 'LoginController@login')->middleware('guest:customer')->name('client.do_login');
					Route::post('/ajaxlogin', 'LoginController@ajaxlogin')->middleware('guest:customer')->name('client.do_ajaxlogin');

					Route::post('/logout', 'LoginController@logout')->middleware('auth:customer')->name('client.logout');
					
					// Social Auth
					Route::get('/login/{social}', 'LoginController@socialLogin')->name('social.login');
					Route::get('/login/{social}/callback','LoginController@handleProviderCallback')->name('social.login-callback');
				
					Route::get('/register', 'RegisterController@showRegistrationForm')->middleware('guest:customer')->name('auth.register');
					Route::post('/register', 'RegisterController@register')->name('register')->middleware('guest:customer');
					Route::post('/register1', 'RegisterController@registers')->name('register1')->middleware('guest:customer');
					Route::get('/forgotpassword', 'Passwords\ForgotpasswordController@forgot')->middleware('guest:customer');
					Route::post('/forgotpassword', 'Passwords\ForgotpasswordController@Email')->middleware('guest:customer');
					Route::post('/forgotpasswordajax', 'Passwords\ForgotpasswordController@Emailajax')->name('ajax.forgot')->middleware('guest:customer');
					Route::post('/change-password', 'ChangepasswordController@changepassword')->name('change.password');
					Route::get('/{token}/reset-password', 'Passwords\ResetpasswordController@resetpassword')->middleware('guest:customer')->name('reset.password');
					Route::post('/reset-password',  'Passwords\ResetpasswordController@updatePassword')->middleware('guest:customer');
					Route::get('/user/verify/{token}','RegisterController@verifyUser')->middleware('guest:customer')->name('verify.email');
				});

				Route::middleware('auth:customer','customer.auth')->group(function () {

					Route::get('/mark-as-read', 'DashboardController@markNotification')->name('customer.markNotification');
					Route::get('/', 'DashboardController@userTickets')->name('client.dashboard');
					Route::get('/profile','Profile\UserprofileController@profile')->name('client.profile');
					Route::post('/profile','Profile\UserprofileController@profilesetup')->name('client.profilesetup');
					Route::post('/deleteaccount/{id}','Profile\UserprofileController@profiledelete')->name('client.profiledelete');
					Route::delete('/image/remove/{id}', 'Profile\UserprofileController@imageremove');
					Route::post('/custsettings', 'Profile\UserprofileController@custsetting');
					Route::get('/ticket','Ticket\TicketController@create')->name('client.ticket');
					Route::post('/ticket','Ticket\TicketController@store')->name('client.ticketcreate');
					Route::post('/imageupload','Ticket\TicketController@storeMedia')->name('imageupload');
					Route::get('/ticket/view/{ticket_id}','Ticket\TicketController@show')->name('loadmore.load_data');
					Route::post('/ticket/{ticket_id}','Ticket\CommentsController@postComment')->name('client.comment');
					Route::post('/ticket/imageupload/{ticket_id}','Ticket\CommentsController@storeMedia')->name('client.ticket.image');
					Route::get('/ticket/delete/{id}','Ticket\TicketController@destroy')->name('client.ticket.delete');
					Route::post('/ticket/delete/tickets', 'Ticket\TicketController@ticketmassdestroy')->name('ticket.massremove');
					Route::post('/ticket/editcomment/{id}','Ticket\CommentsController@updateedit')->name('client.comment.edit');
					Route::get('/activeticket','Ticket\TicketController@activeticket')->name('activeticket');
					Route::get('/closedticket','Ticket\TicketController@closedticket')->name('closedticket');
					Route::get('/onholdticket','Ticket\TicketController@onholdticket')->name('onholdticket');
					Route::post('/closed/{ticket_id}','Ticket\TicketController@close')->name('client.ticketclose');
					Route::delete('/image/delete/{id}','Ticket\CommentsController@imagedestroy')->name('client.imagedestroy');
					Route::post('subcat','Ticket\TicketController@sublist')->name('subcat');
					Route::get('/rating/{ticket_id}', 'Ticket\TicketController@rating')->name('rating')->middleware('disablepreventback');
					Route::get('/rating/star5/{id}', 'Ticket\TicketController@star5');
					Route::get('/rating/star4/{id}', 'Ticket\TicketController@star4');
					Route::get('/rating/star3/{id}', 'Ticket\TicketController@star3');
					Route::get('/rating/star2/{id}', 'Ticket\TicketController@star2');
					Route::get('/rating/star1/{id}', 'Ticket\TicketController@star1');
					Route::get('/generalsetting', 'GeneralSettingController@index')->name('client.general');
					Route::post('/general/notification', 'GeneralSettingController@NotifyOn')->name('client.generalsetting');
					Route::get('/notification', 'DashboardController@notify')->name('client.notification');
					
					Route::get('/markAsRead', function(){

						$notify = Auth::guard('customer')->user();
						$notify->unreadNotifications->markAsRead();
					
					})->name('cust.mark');
				});

			});

			Route::get('/', [HomeController::class, 'index'])->name('home');
			Route::get('language/{locale}', [HomeController::class, 'setLanguage'])->name('front.set_language');
			Route::get('/captchareload', [HomeController::class, 'captchareload'])->name('captcha.reload');
			Route::get('/article/{id}', [HomeController::class, 'knowledge'])->name('article');
			Route::get('/likes/{id}',[HomeController::class, 'like']);
			Route::get('/dislikes/{id}',[HomeController::class, 'dislike']);
			Route::get('/faq', [HomeController::class, 'faqpage']);
			Route::get('/page/{pageslug}', [HomeController::class, 'frontshow']);

			Route::get('/knowledge', [ArticleCommentController::class, 'index'])->name('knowledge');
			Route::post('/comment{id}', [ArticleCommentController::class, 'store']);
			Route::post('/replies{id}', [ArticleReplyController::class, 'store']);

			Route::get('/contact-us', [ContactController::class, 'contact']);
			Route::post('/contact-us', [ContactController::class, 'saveContact']);

			Route::get('/category/{id}', [CategorypageController::class, 'index']);

			Route::get('/guest/openticket', [GuestticketController::class, 'index'])->name('guest.ticket');
			Route::post('/guest/openticket', [GuestticketController::class, 'gueststore']);
			Route::post('envatoverify',[GuestticketController::class, 'envatoverify'])->name('guest.envatoverify');
			Route::post('/guest/storemedia', [GuestticketController::class, 'guestmedia'])->name('guest.imageupload');
			Route::get('/guest/ticketdetails/{id}', [GuestticketController::class, 'guestdetails'])->name('guest.gusetticket');
			Route::get('/guest/ticket/{ticket_id}', [GuestticketController::class, 'guestview'])->name('gusetticket');
			Route::delete('/image/delete/{id}', [GuestticketController::class, 'imagedestroy']);
			Route::post('guest/closed/{ticket_id}',[GuestticketController::class, 'close'])->name('guesttickets.ticketclose');
			Route::post('guest/ticket/{ticket_id}',[GuestticketController::class, 'postComment'])->name('guest.comment');
			Route::get('/rating/{ticket_id}', [GuestticketController::class, 'rating'])->name('guest.rating')->middleware('disablepreventback');
			Route::get('/rating/star5/{id}', [GuestticketController::class, 'star5']);
			Route::get('/rating/star4/{id}', [GuestticketController::class, 'star4']);
			Route::get('/rating/star3/{id}', [GuestticketController::class, 'star3']);
			Route::get('/rating/star2/{id}', [GuestticketController::class, 'star2']);
			Route::get('/rating/star1/{id}', [GuestticketController::class, 'star1']);
			Route::post('/guestticket/editcomment/{id}', [CommentsController::class, 'updateedit']);
			Route::post('/guest/emailsvalidate', [GuestticketController::class, 'emailsvalidateguest'])->name('guest.emailsvalidate');
		});
		Route::post('/guest/emailsvalidate', [GuestticketController::class, 'emailsvalidateguest'])->name('guest.emailsvalidate');
		Route::post('/guest/verifyotp', [GuestticketController::class, 'verifyotp'])->name('guest.verifyotp');
		Route::post('subcategorylist',[GuestticketController::class, 'subcategorylist'])->name('guest.subcategorylist');
		Route::post('/search',[HomeController::class, 'searchlist']);
		Route::post('/suggestarticle',[HomeController::class, 'suggestarticle']);
		Route::get('ipblock', [App\Http\Controllers\CaptchaipblockController::class, 'index'])->name('ipblock');
		Route::post('ipblock/update', [App\Http\Controllers\CaptchaipblockController::class, 'update'])->name('ipblock.update');
		Route::get('/captchasreload', [App\Http\Controllers\CaptchaipblockController::class, 'captchasreload'])->name('captchas.reload');
		Route::get('/apifailed', [App\Http\Controllers\ApiController::class, 'index'])->name('apifail.index');

		
	});


});
