<?php
/**
 * @author Artur Magalhães <nezkal@gmail.com>
 */

namespace Tritoq\Bundle\TpanelBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tritoq\Bundle\TpanelBundle\Entity\User;

class UserAddCommand extends ContainerAwareCommand
{


    protected function configure()
    {
        $this
            ->setName('tpanel:user:add')
            ->setDescription('Adiciona um usuário');

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');
        $table = $this->getHelperSet()->get('table');

        $nome = $dialog->ask($output, '<question>Nome do novo usuário?</question> ', false);
        $nome = strtolower($nome);


        $username = $dialog->ask($output, '<question>Username?</question> ', false);
        $username = strtolower($username);

        $password = $dialog->askHiddenResponse($output, '<question>Password?</question> ', false);


        $table->setHeaders(array('Nome', 'Username', 'Password'));
        $table->setRows(
            array(
                array($nome, $username, str_repeat("*", strlen($password)))
            )
        );

        $table->render($output);

        if ($dialog->askConfirmation($output, '<question>Confirmar criação do usuário? (y/n)</question> ', false)) {

            $user = new User();
            $user->setNome($nome)
                ->setUsername($username)
                ->setPassword($password);

            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();

            $output->writeln('<info>Usuário criado</info>');
        } else {
            $output->writeln('<error>Ação cancelada</error>');
        }


    }

} 