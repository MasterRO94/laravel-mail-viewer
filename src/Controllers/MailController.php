<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use MasterRO\MailViewer\Models\MailLog;
use MasterRO\MailViewer\Services\Resource;
use Opcodes\MailParser\Message;
use Opcodes\MailParser\MessagePart;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MailController extends Controller
{
    public function __construct(
        protected Resource $mails,
    ) {}

    public function index(): View
    {
        return view('mail-viewer::mails.index', [
            'devMode' => request()->has('devMode'),
        ]);
    }

    public function rawPayload(MailLog $mailLog): View
    {
        return view('mail-viewer::mails.payload', [
            'mailLog' => $mailLog,
            'devMode' => request()->has('devMode'),
        ]);
    }

    public function emails(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->mails->fetch($request),
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'data' => $this->mails->stats(),
        ]);
    }

    public function payload(MailLog $mailLog): JsonResponse
    {
        return response()->json([
            'data' => $mailLog->payload,
        ]);
    }

    public function downloadAttachment(MailLog $mailLog, string $fileName): StreamedResponse
    {
        /** @var MessagePart $attachment */
        $attachment = collect(Message::fromString($mailLog->payload)->getAttachments())->first(
            static fn(MessagePart $attachment) => $attachment->getFilename() === $fileName,
        );

        if (!$attachment) {
            abort(404);
        }

        return response()->streamDownload(function () use ($attachment) {
            echo $attachment->getContent();
        }, $fileName);
    }

    public function attachments(MailLog $mailLog): JsonResponse
    {
        $parsed = collect(Message::fromString($mailLog->payload)->getAttachments());

        $attachments = collect($mailLog->attachments)->map(function (array $attachment) use ($parsed) {
            /** @var MessagePart $parsedAttachment */
            $parsedAttachment = $parsed->first(
                static fn(MessagePart $parsedAttachment): bool => $parsedAttachment->getFilename() === $attachment['filename'],
            );

            return [
                ...Arr::except($parsedAttachment->toArray(), ['content']),
                ...$attachment,
                'content' => $parsedAttachment->isImage()
                    ? base64_encode($parsedAttachment->getContent())
                    : null,
            ];
        });

        return response()->json([
            'data' => $attachments,
        ]);
    }
}
