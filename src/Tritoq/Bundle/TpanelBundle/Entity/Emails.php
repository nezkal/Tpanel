<?php

namespace Tritoq\Bundle\TpanelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Table(name="tpanel_email")
 */
class Emails
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="dominio", type="string", length=255)
     */
    private $dominio;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var integer
     *
     * @ORM\Column(name="postmaster", type="integer", length=1)
     */
    private $postmaster;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Email
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set dominio
     *
     * @param string $dominio
     * @return Email
     */
    public function setDominio($dominio)
    {
        $this->dominio = $dominio;

        return $this;
    }

    /**
     * Get dominio
     *
     * @return string
     */
    public function getDominio()
    {
        return $this->dominio;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Email
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set postmaster
     *
     * @param integer $postmaster
     * @return Email
     */
    public function setPostmaster($postmaster)
    {
        $this->postmaster = $postmaster;

        return $this;
    }

    /**
     * Get postmaster
     *
     * @return integer
     */
    public function getPostmaster()
    {
        return $this->postmaster;
    }
}
