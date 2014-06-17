<?php
/**
 * @author Artur Magalhães <nezkal@gmail.com>
 */

namespace Tritoq\Bundle\TpanelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Ip;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 *
 * Descrição da Classe aqui
 *
 *
 * Class Vhost
 *
 * @category  Library
 * @copyright Artur Magalhães <nezkal@gmail.com>
 * @package   Tritoq\Bundle\TpanelBundle\Entity
 * @license   GPL-3.0+
 *
 * @ORM\Table(name="tpanel_vhosts")
 * @ORM\Entity(repositoryClass="Tritoq\Bundle\TpanelBundle\Entity\VhostRepository")
 */
class Vhost
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @NotBlank()
     */
    private $user;


    /**
     * @var string
     * @ORM\Column(type="string")
     * @NotBlank()
     */
    private $password;


    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     * @NotBlank()
     * @Ip()
     */
    private $ip;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     * @NotBlank()
     */
    private $domain;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Email()
     */
    private $adminEmail;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $vhost;


    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $nginx;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    function __construct()
    {
        $this->dateCreated = new \DateTime('now');
    }

    /**
     * @param string $nginx
     *
     * @return $this
     */
    public function setNginx($nginx)
    {
        $this->nginx = $nginx;
        return $this;
    }

    /**
     * @return string
     */
    public function getNginx()
    {
        return $this->nginx;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }



    /**
     * @param \DateTime $dateCreated
     *
     * @return $this
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }


    /**
     * @param string $ip
     *
     * @return $this
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }


    /**
     * @param string $adminEmail
     *
     * @return $this
     */
    public function setAdminEmail($adminEmail)
    {
        $this->adminEmail = $adminEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminEmail()
    {
        return $this->adminEmail;
    }

    /**
     * @param string $domain
     *
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $vhost
     *
     * @return $this
     */
    public function setVhost($vhost)
    {
        $this->vhost = $vhost;
        return $this;
    }

    /**
     * @return string
     */
    public function getVhost()
    {
        return $this->vhost;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getAdminEmail();
    }

    public function getTeste()
    {
        return 'ok';
    }
}
