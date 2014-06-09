<?php
/**
 * @author Artur Magalhães <nezkal@gmail.com>
 */

namespace Tritoq\Bundle\TpanelBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tritoq\Bundle\TpanelBundle\Entity\Vhost;

class ShellListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     *
     * @return $this
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }



    private function make(Vhost $vhost)
    {
        $apache = $this->container->getParameter('tpanel.apachedir');
        $kernel = $this->container->get('kernel');

        // Step1 copy the vhosts for de apache conf
        $apacheDir = $apache . '/sites-avaiable/';
        $backupsDir = $kernel->getRootDir() . '/backup/';
        $domain = $vhost->getDomain();

        $vhostFile = $apacheDir . $domain . '.conf';

        if (is_file($vhostFile)) {
            copy($vhostFile, $backupsDir . $domain . time() . '.conf');
        }

        # Set the vhosts in apache
        file_put_contents($vhostFile, $vhost->getVhost());


        # Criar o usuário

        $user_name = $vhost->getUser();
        $user_pass = $vhost->getPassword();

        $ret_useradd = 0;
        $ret_passwd = 0;

        shell_exec('sudo useradd -m ' . $user_name);

        shell_exec('sudo echo "' . $user_name . ':' . $user_pass . '" | chpasswd');

        if ($ret_passwd) {
            echo exec('sudo userdel ' . $user_name);
            throw new \Exception("Something wrong with chpasswd, code: " . $ret_useradd);
        } else {
            $group = $this->container->getParameter('tpanel.webgroup');
            shell_exec('sudo usermod -a -G ' . $group . ' ' . $user_name);
        }


        $logger = $this->container->get('logger');

        $apacheReload = 0;
        passthru('sudo service apache2 reload', $apacheReload);

        $logger->addInfo($logger);
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Vhost) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'UBU') {
                $this->make($entity);
            }
        }
    }


} 