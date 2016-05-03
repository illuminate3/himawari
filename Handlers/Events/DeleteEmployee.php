<?php

namespace App\Modules\Himawari\Handlers\Events;

use App\Modules\Himawari\Events\EmployeeWasDeleted;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Modules\Himawari\Http\Models\Employee;
use App\Modules\Himawari\Http\Repositories\EmployeeRepository;


class DeleteEmployee {


	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct(
			EmployeeRepository $employee_repo
		)
	{
		$this->employee_repo = $employee_repo;
	}


	/**
	 * Handle the event.
	 *
	 * @param  EmployeeWasCreated  $email
	 * @return void
	 */
	public function handle(EmployeeWasDeleted $data)
	{
		if ($data != null) {
			$this->employee_repo->DeleteEmployee($data);
		}
	}


}
