<?php

declare(strict_types=1);

namespace App\Entity;

use App\EntityTrait\SoftDeletableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\SoftDeleteable;

#[ORM\Entity]
#[SoftDeleteable]
class Survey
{
    use SoftDeletableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public int $id;

    #[ORM\Column]
    public string $name;

    #[ORM\Column]
    public bool $isActive;

    #[ORM\Column(type: 'datetimetz_immutable')]
    public \DateTimeInterface $createdAt;
}
