<?php

declare(strict_types=1);

namespace App\View\Element;

final readonly class StatusView
{
    public function __construct(
        public string $title,
    ) {
    }
}
