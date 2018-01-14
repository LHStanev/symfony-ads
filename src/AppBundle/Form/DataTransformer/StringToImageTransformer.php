<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class StringToImageTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (file) to a string (number).
     *
     * @param  FileType|null $file
     * @return string
     */
    public function transform($file)
    {
       return null;
    }

    /**
     * Transforms a string (name) to an object (file).
     *
     * @param  string $issueNumber
     * @return FileType|null
     * @throws TransformationFailedException if object (file) is not found.
     */
    public function reverseTransform($fileName)
    {
        return $fileName;
    }
}