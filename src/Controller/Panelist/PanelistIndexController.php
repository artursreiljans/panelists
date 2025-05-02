<?php

declare(strict_types=1);

namespace App\Controller\Panelist;

use App\Entity\Panelist;
use App\Form\PanelistType;
use App\ViewFactory\Entity\CreatePanelistView;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/',
    name: self::class,
    methods: ['GET', 'POST'],
)]
#[Template('layouts/panelists.html.twig')]
final class PanelistIndexController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CreatePanelistView $createPanelistView,
    ) {
    }

    public function __invoke(Request $request): RedirectResponse|array
    {
        $form = $this->createForm(PanelistType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $panelist = $form->getData();
            $this->entityManager->persist($panelist);
            $this->entityManager->flush();

            return $this->redirectToRoute(PanelistIndexController::class);
        }

        $panelists = \array_map(
            $this->createPanelistView->call(...),
            $this->entityManager->getRepository(Panelist::class)->findAll(),
        );

        return [
            'panelists' => $panelists,
            'form' => $form->createView(),
        ];
    }
}
