<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class AddressParser
{
    public function parse(Email $message, string $field): array
    {
        $headers = $message->getHeaders();

        if (! $headers->has($field)) {
            return [];
        }

        return collect($headers->get($field)->getBody())
            ->map(function (Address $address) {
                return [
                    'email' => $address->getAddress(),
                    'name'  => $address->getName(),
                ];
            })
            ->values()
            ->toArray();
    }
}
