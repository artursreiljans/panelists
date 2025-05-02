<?php

declare(strict_types=1);

namespace App\Controller\Survey;

use App\Entity\Survey;
use App\Form\SurveyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/surveys/{id}/edit',
    name: self::class,
    requirements: ['id' => '\d+'],
    methods: ['GET', 'POST'],
)]
#[Template('layouts/form.html.twig')]
final class SurveyUpdateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(
        Request $request,
        Survey $survey,
    ): RedirectResponse|array {
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute(SurveyIndexController::class);
        }

        return [
            'title' => $survey->name,
            'form' => $form->createView(),
        ];
    }
}
