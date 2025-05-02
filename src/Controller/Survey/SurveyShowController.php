<?php

declare(strict_types=1);

namespace App\Controller\Survey;

use App\Entity\Survey;
use App\ViewFactory\Entity\CreateSurveyView;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/surveys/{id}',
    name: self::class,
    requirements: ['id' => '\d+'],
    methods: ['GET'],
)]
#[Template('layouts/survey.html.twig')]
final class SurveyShowController extends AbstractController
{
    public function __construct(
        private readonly CreateSurveyView $createSurveyView,
    ) {
    }

    public function __invoke(
        Request $request,
        Survey $survey,
    ): RedirectResponse|array {
        return [
            'survey' => $this->createSurveyView->call($survey),
        ];
    }
}
