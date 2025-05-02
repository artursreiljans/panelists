<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Survey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class SurveyType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [new NotBlank(), new Length(max: 255)]
                ],
            )
            ->add(
                'isActive',
                CheckboxType::class,
                [
                    'required' => false,
                ],
            );

        $builder->add(
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
                'data_class' => Survey::class,
                'method' => 'POST',
            ],
        );
    }
}
