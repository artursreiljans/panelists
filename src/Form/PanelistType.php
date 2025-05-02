<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Panelist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final class PanelistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                ['constraints' => [new NotBlank(), new Length(max: 255)]],
            )
            ->add(
                'lastName',
                TextType::class,
                ['constraints' => [new NotBlank(), new Length(max: 255)]],
            )
            ->add(
                'email',
                EmailType::class,
                ['constraints' => [new NotBlank(), new Length(max: 255)]],
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(max: 20),
                        new Type('digit'),
                    ],
                ],
            )
            ->add(
                'country',
                CountryType::class,
                ['constraints' => [new NotBlank()]],
            )
            ->add(
                'isSubscribed',
                CheckboxType::class,
                ['required' => false],
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
                'data_class' => Panelist::class,
                'method' => 'POST'
            ],
        );
    }
}
