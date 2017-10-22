<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine entity for book authors
 *
 * @ORM\Entity
 * @ORM\Table(name="author")
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Book", mappedBy="authors")
     */
    private $books;

    public function getName() : string
    {
        return $this->name;
    }

    public function getBooks() : ArrayCollection
    {
        return $this->books;
    }

    public function __toString() : string
    {
        return $this->getName();
    }
}
