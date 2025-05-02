<?php

declare(strict_types=1);

namespace App\Controller\Survey;

use App\Entity\Survey;
use App\Form\DeleteType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Clock\ClockInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(
    path: '/surveys/{id}/delete',
    name: self::class,
    requirements: ['id' => '\d+'],
    methods: ['GET', 'POST'],
)]
#[Template('layouts/form.html.twig')]
final class SurveyDeleteController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
        private readonly ClockInterface $clock,
    ) {
    }

    public function __invoke(
        Survey $survey,
        Request $request,
    ): RedirectResponse|array {
        $form = $this->createForm(DeleteType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $survey->delete($this->clock->now());
            $this->entityManager->flush();

            return $this->redirectToRoute(SurveyIndexController::class);
        }

        return [
            'title' => $this->translator->trans('actions.delete'),
            'form' => $form->createView(),
        ];
    }
}
