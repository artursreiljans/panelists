<?php

declare(strict_types=1);

namespace App\EntityTrait;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteable;

/**
 * Compared to the original Gedmo trait, this one sets the
 * \DateTimeInterface type instead of \DateTime, and adds
 * ORM mapping.
 *
 * Also, it's grammatically correctly named.
 *
 * @see SoftDeleteable
 */
trait SoftDeletableTrait
{
    #[ORM\Column(type: 'datetimetz_immutable', nullable: true)]
    private \DateTimeInterface $deletedAt;

    public function delete(\DateTimeInterface $now): void
    {
        $this->deletedAt = $now;
    }
}
