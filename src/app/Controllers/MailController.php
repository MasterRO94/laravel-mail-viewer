<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Services\Resource;

class MailController extends Controller
{
    public function __construct(protected Resource $mails)
    {
    }

    public function index()
    {
        return view('mail-viewer::mails.index');
    }

    public function emails(Request $request)
    {sleep(2);
        return response()->json([
            'success' => true,
            'data'    => $this->mails->fetch($request),
        ]);
    }

    public function show(MailLog $mailLog)
    {
        return view('mail-viewer::mails.view', compact('mailLog'));
    }
}
