<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Controllers;

use Illuminate\Routing\Controller;
use MasterRO\MailViewer\Models\MailLog;

class MailController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$mails = MailLog::latest('date')->paginate(config('mail-viewer.emails_per_page', 20));

		if (request()->expectsJson()) {
			return response()->json(['success' => true, 'data' => $mails]);
		}

		return view('mail-viewer::mails.index', compact('mails'));
	}


	/**
	 * @param MailLog $mailLog
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show(MailLog $mailLog)
	{
		return view('mail-viewer::mails.view', compact('mailLog'));
	}

}
