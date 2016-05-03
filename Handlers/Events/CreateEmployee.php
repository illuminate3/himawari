<?php

namespace App\Modules\Himawari\Handlers\Events;

use App\Modules\Himawari\Events\EmployeeWasCreated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Modules\Himawari\Http\Models\Employee;
use App\Modules\Himawari\Http\Repositories\EmployeeRepository;

use App\Modules\Kagi\Http\Models\User;
use App\Modules\Kagi\Http\Repositories\UserRepository;

use App\Modules\Yubin\Http\Models\MailCanned;
use App\Modules\Yubin\Http\Repositories\MailCannedRepository;
use App\Modules\Yubin\Http\Models\MailGroup;
use App\Modules\Yubin\Http\Repositories\MailGroupRepository;

use Auth;
use Cache;
use Config;
use Mail;
use Setting;


class CreateEmployee {


	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct(
			MailCannedRepository $mail_canned_repo,
			MailGroupRepository $mail_group_repo,
			EmployeeRepository $employee_repo,
			User $user,
			UserRepository $user_repo
		)
	{
		$this->mail_canned_repo = $mail_canned_repo;
		$this->mail_group_repo = $mail_group_repo;
		$this->employee_repo = $employee_repo;
		$this->user = $user;
		$this->user_repo = $user_repo;
	}


	/**
	 * Handle the event.
	 *
	 * @param  EmployeeWasCreated  $email
	 * @return void
	 */
	public function handle(EmployeeWasCreated $data)
	{
		if ($data != null) {

			$new_user = $this->user_repo->getUserInfo($data->email);
//dd($new_user);
			$new_user = $this->user->find($new_user->id);

			$this->sendNewUserEmail($new_user->id, $new_user);
			$this->employee_repo->CreateEmployee($new_user);
		}
	}


	public function sendNewUserEmail($user_id, $new_user)
	{

		$from_email = Setting::get('hr_mailer_slug', Config::get('yubin.hr_mailer_slug'));
		$mail_group_id = $this->mail_group_repo->getMailerIDbySlug($mailer_slug);
		$users = MailGroup::find($mail_group_id)->groups;

		$slug = Config::get('yubin.hr_canned_slug');
		$canned_id = $this->mail_canned_repo->getCannedIDbySlug($slug);
		$mail_canned = MailCanned::find($canned_id);

		$from_email = Setting::get('from_email', Config::get('yubin.from_email'));
		$from_email = Setting::get('from_name', Config::get('yubin.from_name'));

		$subject = $mail_canned->subject;
		$message = $mail_canned->message . 'Name: ' . $new_user->name . ' Email: ' . $new_user->email;

		$template = Setting::get('hr_template', Config::get('yubin.hr_template'));
		$theme_layout = 'emails.layouts.html';
		$template_name = $template;
		$template_view = 'emails.templates.' . $template_name;

		foreach ($users as $user )
		{

			$data = array(
				'employee_id'		=> $user_id,
				'from_email'		=> $from_email,
				'from_name'			=> $from_name,
//				'to_email'			=> $to_email,
				'to_email'			=> $user->email,
				'subject'			=> $subject,
				'canned'			=> $message,
//				'theme'				=> $theme,
				'theme_layout'		=> $theme_layout
			);

		Mail::send($template_view, $data, function ($message) use ($data)
		{
			$message->from($data['from_email'], $data['from_name']);
			$message->to($data['to_email']);
			$message->subject($data['subject']);
			});
		}

		return;
	}


}
