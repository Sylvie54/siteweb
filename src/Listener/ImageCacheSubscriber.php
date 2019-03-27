<?php
namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;


class ImageCacheSubscriber implements EventSubscriber {

/**
 * @var CacheManager
 */

 private $cacheManager;

/**
 * @var UploaderHelper 
 */ 
private $uploaderHelper;


    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
        
    }
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        // si ce n'est pas une instance de Property, on ne fait rien
        if (!$entity instanceof Property)
        {
            return;
        }
        
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile')); 

    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        // si ce n'est pas une instance de Property, on ne fait rien
        if (!$entity instanceof Property)
        {
            return;
        }

       if ($entity->getImageFile() instanceof uploadedFile) 
       {
           $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile')); 

       }
    }

}