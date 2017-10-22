<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Book;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        Fixtures::load(
            __DIR__.'/fixtures.yml',
            $manager,
            [
                'providers' => [$this]
            ]
        );
    }

    /**
     * Provides random book status for Alice
     */
    public function status() : string
    {
        $statuses = Book::getStatuses();

        $key = array_rand($statuses);

        return $statuses[$key];
    }
}