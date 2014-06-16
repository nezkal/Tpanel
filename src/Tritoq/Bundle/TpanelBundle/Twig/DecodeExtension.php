<?php
/**
 * @author Anderson Barberini <anderson.aeb@gmail.com>
 *
 */


namespace Tritoq\Bundle\TpanelBundle\Twig;


class DecodeExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(new \Twig_SimpleFilter('url_decode', array($this, 'decodeUrl')));
    }

    public function decodeUrl($url)
    {
        return urldecode($url);
    }

    public function getName()
    {
        return 'decode_extension';
    }
} 