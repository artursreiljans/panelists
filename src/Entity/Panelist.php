<?php

declare(strict_types=1);

namespace App\Entity;

use App\EntityTrait\SoftDeletableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[UniqueEntity('email')]
#[SoftDeleteable]
class Panelist
{
    use SoftDeletableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public int $id;

    #[ORM\Column]
    public string $firstName;

    #[ORM\Column]
    public string $lastName;

    #[ORM\Column]
    public string $email;

    #[ORM\Column(length: 20)]
    public string $phone;

    #[ORM\Column(length: 2)]
    public string $country;

    #[ORM\Column]
    public bool $isSubscribed;

    #[ORM\Column(type: 'datetimetz_immutable')]
    public \DateTimeInterface $createdAt;

    #[ORM\ManyToMany(targetEntity: Survey::class)]
    private Collection $surveys;

    public function __construct()
    {
        $this->surveys = new ArrayCollection();
    }

    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurveys(Survey ...$surveys): void
    {
        foreach ($surveys as $survey) {
            if (!$this->surveys->contains($survey)) {
                $this->surveys[] = $survey;
            }
        }
    }
}
