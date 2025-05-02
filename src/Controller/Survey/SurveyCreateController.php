<?php

declare(strict_types=1);

namespace App\Controller\Survey;

use App\Form\SurveyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/surveys/new',
    name: self::class,
    methods: ['GET', 'POST'],
)]
#[Template('layouts/form.html.twig')]
final class SurveyCreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function __invoke(Request $request): RedirectResponse|array
    {
        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $survey = $form->getData();
            $this->entityManager->persist($survey);
            $this->entityManager->flush();

            return $this->redirectToRoute(SurveyIndexController::class);
        }

        return [
            'title' => $this->translator->trans('survey.add_new'),
            'form' => $form->createView(),
        ];
    }
}
