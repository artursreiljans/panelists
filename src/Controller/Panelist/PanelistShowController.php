<?php

declare(strict_types=1);

namespace App\Controller\Panelist;

use App\Entity\Panelist;
use App\Form\PanelistAssignSurveyType;
use App\ViewFactory\Entity\CreatePanelistView;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/panelists/{id}',
    name: self::class,
    requirements: ['id' => '\d+'],
    methods: ['GET', 'POST'],
)]
#[Template('layouts/panelist.html.twig')]
final class PanelistShowController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CreatePanelistView $createPanelistView,
    ) {
    }

    public function __invoke(
        Request $request,
        Panelist $panelist,
    ): RedirectResponse|array {
        $form = $this->createForm(
            PanelistAssignSurveyType::class,
            [
                'surveys' => $panelist->getSurveys()->toArray(),
            ],
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedSurveys = $form->get('surveys')->getData();
            $panelist->getSurveys()->clear();
            $panelist->addSurveys(...$selectedSurveys);
            $this->entityManager->flush();

            return $this->redirectToRoute(self::class, ['id' => $panelist->id]);
        }

        return [
            'panelist' => $this->createPanelistView->call($panelist),
            'form' => $form->createView(),
        ];
    }
}
