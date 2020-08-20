<?php

namespace Grr\GrrBundle\Area\Form;

use Grr\GrrBundle\Entity\Area;
use Grr\GrrBundle\Entity\TypeEntry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssocTypeForAreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'typesEntry',
                EntityType::class,
                [
                    'class' => TypeEntry::class,
                    'multiple' => true,
                    'expanded' => true,
                    'label' => 'label.area.entryTypes',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Area::class,
            ]
        );
    }
}
