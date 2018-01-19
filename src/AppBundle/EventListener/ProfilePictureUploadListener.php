<?php


namespace AppBundle\EventListener;


use AppBundle\CloudStorage\GCPStorage;
use AppBundle\Entity\Player;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfilePictureUploadListener
{
    const FOLDER_NAME = 'profile-picture';

    private $storage;

    public function __construct(GCPStorage $storage)
    {
        $this->storage = $storage;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Player) {
            return;
        }

        // FIXME
        return;

        if ($filename = $entity->getProfilePictureFile()) {
            $tmpLocation = '/tmp/'.md5($filename);
            $this->storage->downloadObject($filename, $tmpLocation);
            $entity->setProfilePictureFile(new File($tmpLocation));
        }
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof Player) {
            return;
        }
        if (!$file = $entity->getProfilePictureFile()) {
            return;
        }

        $fileName = sprintf(
            "%s/%s.%s",
            self::FOLDER_NAME,
            md5(uniqid()),
            $file->guessExtension()
        );

        $options = ['predefinedAcl' => 'publicRead'];
        // only upload new files
        if ($file instanceof UploadedFile) {
            $object = $this->storage->uploadObject(
                $fileName,
                $file->getRealPath(),
                $options
            );
            $publicUrl = $this->storage->getPublicUrl($object->name());
            $entity->setProfilePicturePublicUrl($publicUrl);
            $entity->setProfilePictureFile($fileName);
        }
    }

}