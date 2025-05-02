<?php

declare(strict_types=1);

namespace App\Controller\Panelist;

use App\Entity\Panelist;
use App\Form\PanelistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/panelists/{id}/edit',
    name: self::class,
    requirements: ['id' => '\d+'],
    methods: ['GET', 'POST'],
)]
#[Template('layouts/form.html.twig')]
final class PanelistUpdateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function __invoke(
        Request $request,
        Panelist $panelist,
    ): RedirectResponse|array {
        $form = $this->createForm(PanelistType::class, $panelist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute(PanelistIndexController::class);
        }

        return [
            'title' => $this->translator->trans('panelist.edit'),
            'form' => $form->createView(),
        ];
    }
}
