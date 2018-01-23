<?php

namespace AppBundle\Form;

use AppBundle\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PlayerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('location')
            ->add('leaguePlayer')
            ->add('bio', TextareaType::class, [
                'attr' => ['rows' => 5],
                'empty_data' => ''
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Player::class
        ));
    }

}
