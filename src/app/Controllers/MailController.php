<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Services\Resource;

class MailController extends Controller
{
    public function __construct(
        protected Resource $mails,
    ) {}

    public function index(): View
    {
        return view('mail-viewer::mails.index');
    }

    public function emails(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->mails->fetch($request),
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->mails->stats(),
        ]);
    }

    public function payload(MailLog $mailLog): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $mailLog->payload,
        ]);
    }
}
