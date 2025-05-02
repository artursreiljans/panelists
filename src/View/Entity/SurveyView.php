<?php

declare(strict_types=1);

namespace App\View\Entity;

use App\View\Element\LinksView;
use App\View\Element\StatusView;

final readonly class SurveyView
{
    public function __construct(
        public string $name,
        public \DateTimeInterface $createdAt,
        public StatusView $status,
        public LinksView $links,
    ) {
    }
}
