<?php
/**
 * @author Artur Magalhães <nezkal@gmail.com>
 */

namespace Tritoq\Bundle\TpanelBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tritoq\Bundle\TpanelBundle\Entity\User;

class UserListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof User) {
            if (!$entity->getId()) {
                $entity->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
                $encoder = $this->container->get('security.encoder_factory');
                $entity->setPassword(
                    $encoder->getEncoder(get_class($entity))->encodePassword($entity->getPassword(), $entity->getSalt())
                );
            }

        }
    }

} 