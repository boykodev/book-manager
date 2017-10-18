<?php


namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as BookAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine entity for books
 *
 * @ORM\Entity
 * @ORM\Table(name="book")
 */
class Book
{
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->authors = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @BookAssert\Year()
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Author", inversedBy="books")
     * @ORM\JoinColumn(nullable=true)
     */
    private $authors;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @Assert\Choice(callback="getStatuses")
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get array of available choices for book status
     *
     * @return array
     */
    public static function getStatuses()
    {
        return array('free', 'reserved', 'taken');
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @param ArrayCollection $authors
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }
}
