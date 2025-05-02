<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Survey;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PanelistAssignSurveyType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add(
                'surveys',
                EntityType::class,
                [
                    'class' => Survey::class,
                    'choice_label' => 'name',
                    'choice_filter' => fn(Survey $s): bool => $s->isActive,
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'panelist.assign_surveys',
                ],
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'actions.save',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => null,
            ],
        );
    }
}
