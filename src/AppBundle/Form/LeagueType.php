<?php

namespace AppBundle\Form;

use AppBundle\Entity\League;
use AppBundle\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeagueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('buyIn')
            ->add('players', EntityType::class, [
                'class' => Player::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('firstPrize')
            ->add('secondPrize')
            ->add('thirdPrize')
            ->add('firstPlace')
            ->add('secondPlace')
            ->add('thirdPlace')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => League::class
        ));
    }

}
