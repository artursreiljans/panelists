<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Survey;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Psr\Clock\ClockInterface;

#[AsDoctrineListener(Events::prePersist)]
final readonly class SurveyListener
{
    public function __construct(
        private ClockInterface $clock,
    ) {}

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Survey) {
            return;
        }

        $entity->createdAt = $this->clock->now();
    }
}
