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
    public function index()
    {
        return view('mail-viewer::mails.index');
    }

    public function emails()
    {
        $mails = MailLog::latest('date')->paginate(config('mail-viewer.emails_per_page', 20));

        return response()->json(['success' => true, 'data' => $mails]);
    }

    public function show(MailLog $mailLog)
    {
        return view('mail-viewer::mails.view', compact('mailLog'));
    }
}
