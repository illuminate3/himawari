<?php

namespace App\Modules\Himawari\Events;

use App\Modules\Himawari\Events\Event;
use Illuminate\Queue\SerializesModels;


class ContentWasCreated extends Event {

	use SerializesModels;

	public $data;

	public function __construct($data)
	{
//dd($data);
//dd($data->id);

		$this->id				= $data->id;
//		$this->email			= $data->email;

	}


}
