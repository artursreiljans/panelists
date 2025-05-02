<?php

declare(strict_types=1);

namespace App\View\Element;

final readonly class LinkView
{
    public function __construct(
        public string $url,
        public string $title,
    ) {
    }
}
