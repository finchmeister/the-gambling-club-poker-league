<?php

namespace AppBundle\Form;

use AppBundle\Entity\Game;
use AppBundle\Entity\Result;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('buyIn')
            ->add('host')
            ->add('isOnline')
            ->add('commission')
            ->add('fudgeFactor')
            ->add('startTime')
            ->add('location')
            ->add('spotifyPlaylistUri')
            ->add('isLeague')
            ->add('snacks')
            ->add('snacksProvider')
            ->add('results', CollectionType::class, [
                'entry_type' => ResultType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype_data' => new Result()
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Game::class
        ));
    }

}
