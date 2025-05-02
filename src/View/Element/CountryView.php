<?php

declare(strict_types=1);

namespace App\View\Element;

/**
 * @author Artūrs Reiljans <ernt@ernt.lv>
 */
final readonly class CountryView
{
    public function __construct(
        public string $title,
    ) {
    }
}
