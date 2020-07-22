<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Controllers;

use Illuminate\Routing\Controller;
use MasterRO\MailViewer\Models\MailLog;

/**
 * Class MailController
 *
 * @package MasterRO\MailViewer\Controllers
 */
class MailController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('mail-viewer::mails.index');
    }

    /**
     * Emails
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function emails()
    {
        $mails = MailLog::latest('date')->paginate(config('mail-viewer.emails_per_page', 20));

        return response()->json(['success' => true, 'data' => $mails]);
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
