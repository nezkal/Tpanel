<?php

namespace Tritoq\Bundle\TpanelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tritoq\Bundle\TpanelBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface {



    private $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
        $this->container = $container;
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param Doctrine\Common\Persistence\ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.

        $user = new User();

        $user->setNome('Administrador')
            ->setUsername('admin')
            ->setPassword('12345');

        $manager->persist($user);
        $manager->flush();
    }

}