<?php

declare(strict_types=1);

namespace App\View\Element;

/**
 * @author Artūrs Reiljans <ernt@ernt.lv>
 */
final readonly class LinksView
{
    public function __construct(
        public LinkView $view,
        public LinkView $edit,
        public LinkView $delete,
    ) {
    }
}
