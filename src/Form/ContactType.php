<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'Email',
                'attr' => ['class' => 'test'],
                'label_attr' => [
                    'class' => 'test-label'
                ]
            ])

            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => false,
            ])

            ->add('message', TextareaType::class, [
                'required' => false
            ])

            ->add('service', ChoiceType::class, [
                'choices' => [
                    'directeur' => 'directeur@company.com',
                    'comptabilite' => 'comptabilite@company.com',
                    'support' => 'support@company.com'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
