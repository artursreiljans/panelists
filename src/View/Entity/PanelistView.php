<?php

declare(strict_types=1);

namespace App\View\Entity;

use App\View\Element\CountryView;
use App\View\Element\LinksView;
use App\View\Element\StatusView;

final readonly class PanelistView
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $fullName,
        public string $email,
        public string $phone,
        public \DateTimeInterface $createdAt,
        public StatusView $isSubscribed,
        public CountryView $country,
        public LinksView $links,
    ) {
    }
}
