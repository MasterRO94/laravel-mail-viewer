<?php

declare(strict_types=1);

namespace MasterRO\MailViewer\Services;

class AddressParser
{
    public function parse(string $input): array
    {
        $emails = [];

        // First, split the input string by commas to separate each address
        $addressList = explode(',', $input);

        // Regex to capture "Name <email@example.com>" OR just "email@example.com"
        $emailPattern = '/^\s*(?:"?([^"]*?)"?\s*)?<([^<>]+)>|\s*([^<>\s]+@[^\s]+)\s*$/';

        foreach ($addressList as $address) {
            if (!preg_match($emailPattern, trim($address), $match)) {
                continue;
            }

            $name = isset($match[1]) && trim($match[1]) !== '' ? trim($match[1]) : null;
            $email = !empty($match[2]) ? $match[2] : $match[3];

            $emails[] = (object) [
                'name' => $name,
                'email' => trim($email),
            ];
        }

        return $emails;
    }
}
