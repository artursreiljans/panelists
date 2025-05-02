<?php

declare(strict_types=1);

namespace App\Controller\Survey;

use App\Entity\Survey;
use App\View\Element\LinkView;
use App\ViewFactory\Entity\CreateSurveyView;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/surveys',
    name: self::class,
    methods: ['GET'],
)]
#[Template('layouts/surveys.html.twig')]
final class SurveyIndexController extends AbstractController
{
    public function __construct(
        private readonly CreateSurveyView $createSurveyView,
        private readonly EntityManagerInterface $entityManager,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function __invoke(): array
    {
        $surveys = \array_map(
            $this->createSurveyView->call(...),
            $this->entityManager->getRepository(Survey::class)->findAll(),
        );

        return [
            'surveys' => $surveys,
            'creationLink' => new LinkView(
                $this->urlGenerator->generate(
                    SurveyCreateController::class,
                    [],
                    UrlGeneratorInterface::ABSOLUTE_URL,
                ),
                $this->translator->trans('survey.add_new'),
            )
        ];
    }
}
