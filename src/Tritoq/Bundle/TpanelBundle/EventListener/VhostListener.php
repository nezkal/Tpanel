<?php
/**
 * @author Artur Magalhães <nezkal@gmail.com>
 */

namespace Tritoq\Bundle\TpanelBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Tritoq\Bundle\TpanelBundle\Entity\Vhost;

class VhostListener
{

    /**
     * @param Vhost $entity
     * @param       $data
     *
     * @return mixed
     */
    private function replaceVariables(Vhost $entity, $data)
    {
        $vars = array(
            'domain',
            'ip',
            'email',
            'user'
        );

        foreach ($vars as $var) {
            $getMethod = 'get' . ucfirst($var);
            $data = str_replace("{\$" . $var . "}", $entity->$getMethod(), $data);
        }

        return $data;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Vhost) {
            $vhost = $entity->getVhost();
            $nginx = $entity->getNginx();

            $entity->setVhost($this->replaceVariables($entity, $vhost));
            $entity->setNginx($this->replaceVariables($entity, $nginx));
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {

    }
} 