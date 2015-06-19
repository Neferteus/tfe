<?php
/**
 * Created by PhpStorm.
 * User: Ludovic
 * Date: 22-04-15
 * Time: 00:15
 */

namespace TFE\LibrairieBundle\Form\DataTransformer;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use TFE\LibrairieBundle\Entity\Format;

class FormatToStringTransformer implements DataTransformerInterface
{
    private $om;

    function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function transform($format)
    {
        if ($format === null)
        {
            return '';
        }

        return $format->getnomFormat();
    }

    public function reverseTransform($nomFormat)
    {
        if (!$nomFormat)
        {
            return null;
        }

        $format = $this->om
            ->getRepository('TFELibrairieBundle:Format')
            ->findOneBy(array('nomFormat' => $nomFormat))
        ;

        if ($format === null)
        {
            // Si l'objet n'existe pas, on le crée
            $ajoutFormat = new Format();
            $ajoutFormat->setNomFormat($nomFormat);

            $this->om->persist($ajoutFormat);
            $this->om->flush();

            return $ajoutFormat;
        }

        return $format;
    }

} 