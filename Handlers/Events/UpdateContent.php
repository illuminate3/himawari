<?php

namespace App\Modules\Himawari\Handlers\Events;

use App\Modules\Himawari\Events\ContentWasUpdated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Modules\Himawari\Http\Models\Content;
use App\Modules\Himawari\Http\Repositories\ContentRepository;

use App\Modules\Yubin\Http\Models\MailCanned;
use App\Modules\Yubin\Http\Repositories\MailCannedRepository;
use App\Modules\Yubin\Http\Models\MailGroup;
use App\Modules\Yubin\Http\Repositories\MailGroupRepository;

use App\Modules\Yubin\Library\YubinMailer;

use Config;
use Mail;
use Setting;


class UpdateContent {


	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct(
			MailCannedRepository $mail_canned_repo,
			MailGroupRepository $mail_group_repo,
			ContentRepository $content_repo,
			YubinMailer $yubin_mailer
		)
	{
		$this->mail_canned_repo = $mail_canned_repo;
		$this->mail_group_repo = $mail_group_repo;
		$this->content_repo = $content_repo;
		$this->yubin_mailer = $yubin_mailer;
	}


	/**
	 * Handle the event.
	 *
	 * @param  ContentWasCreated  $email
	 * @return void
	 */
	public function handle(ContentWasUpdated $data)
	{
		if ($data != null) {

			$content = Content::find($data->id);
			$this->sendEmail($content);

		}
	}


	public function sendEmail($content)
	{

		$group_slug = Config::get('himawari.mailer.group_slug');
		$mail_group_id = $this->mail_group_repo->getMailerIDbySlug($group_slug);
		$recipients = MailGroup::find($mail_group_id)->groups;

		$slug = Config::get('himawari.mailer.update_canned_slug');
		$canned_id = $this->mail_canned_repo->getCannedIDbySlug($slug);
		$mail_canned = MailCanned::find($canned_id);

		$from_email = Setting::get('cms_from_email', Config::get('himawari.mailer.from_email'));
		$from_name = Setting::get('cms_from_name', Config::get('himawari.mailer.from_name'));

		$subject = $mail_canned->subject;

		$message = '<h1>' . $mail_canned->message . '</h1>';
		$message .= '<br>' . trans('kotoba::general.title') . ': ' . $content->title;
		$message .= '<br>' . trans('kotoba::cms.summary') . ': ' . $content->summary;

		$template = Setting::get('cms_template', Config::get('himawari.mailer.template'));
		$theme_layout = 'emails.layouts.html';
		$template_view = 'emails.templates.' . $template;

		foreach ($recipients as $recipient )
		{

			$data = array(
				'content_id'		=> $content->id,
				'from_email'		=> $from_email,
				'from_name'			=> $from_name,
//				'to_email'			=> $to_email,
				'to_email'			=> $recipient->email,
				'subject'			=> $subject,
				'canned'			=> $message,
//				'theme'				=> $theme,
				'theme_layout'		=> $theme_layout
			);

			$this->yubin_mailer->sendMail($template_view, $data, $message);
		}

		return;
	}


}
