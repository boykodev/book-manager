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
    const STATUS_FREE = 'free';
    const STATUS_RESERVED = 'reserved';
    const STATUS_TAKEN = 'taken';

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
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\Choice({"free", "reserved", "taken"})
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Author", inversedBy="books")
     * @ORM\JoinColumn(nullable=true)
     */
    private $authors;

    public function getId() : int
    {
        return $this->id;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getYear() : int
    {
        return $this->year;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @Assert\Choice(callback="getStatuses")
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Get array of available choices for book status
     */
    public static function getStatuses() : array
    {
        return [
            self::STATUS_FREE,
            self::STATUS_RESERVED,
            self::STATUS_TAKEN
        ];
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setYear(int $year)
    {
        $this->year = $year;
    }

    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }
}
