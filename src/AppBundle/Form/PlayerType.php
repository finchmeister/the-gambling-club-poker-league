<?php

namespace AppBundle\Form;

use AppBundle\CloudStorage\GCPStorageHelper;
use AppBundle\Entity\Player;
use League\Flysystem\Filesystem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    /**
     * @var Filesystem
     */
    private $storage;
    /**
     * @var GCPStorageHelper
     */
    private $storageHelper;

    public function __construct(
        Filesystem $storage,
        GCPStorageHelper $storageHelper
    ) {
        $this->storage = $storage;
        $this->storageHelper = $storageHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('location')
            ->add('hidePlayer')
            ->add('bio', TextareaType::class, [
                'attr' => ['rows' => 5],
                'empty_data' => ''
            ])
            ->add('profilePicture', FileType::class, [
                'required' => false,
            ])
        ;

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /** @var Player $summary */
                $player = $event->getData();
                if ($fileName = $player->getProfilePicture()) {
                    $player->setProfilePicture(new File($fileName, false));
                }
            });

        $builder
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                if (!$event->getForm()->isValid()) {
                    return;
                }
                /** @var Player $summary */
                $player = $event->getData();
                /** @var UploadedFile $file */
                if ($player->getProfilePicture() instanceof UploadedFile) {
                    $profilePicture = $player->getProfilePicture();
                    $imagePath = $player->getProfilePicturePath();
                    $this->storage->put($imagePath, file_get_contents($profilePicture->getPathname()), []);
                    $player->setProfilePicturePublicUrl($this->storageHelper->getPublicUrl($imagePath));
                }
            });
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
