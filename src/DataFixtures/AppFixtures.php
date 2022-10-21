<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\VinylMix;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $genres = ['pop', 'rock'];
        $titles = [
            'Nirvana - "Smells Like Teen Spirit" (1991, #6 US)',
            'U2 - "One" (1991, #10 US)',
            'Backstreet Boys - "I Want It That Way" (1999, #6 US)',
            'Whitney Houston - "I Will Always Love You" (1992, #1 US)',
            'Madonna - "Vogue" (1990, #1 US)',
            'Sir Mix-A-Lot - "Baby Got Back" (1992, #1 US)',
            'Britney Spears - "Baby One More Time" (1999, #1 US)',
            'TLC - "Waterfalls" (1994, #1 US)',
            'R.E.M. - "Losing My Religion" (1991, #4 US)',
            'Sinéad OConnor - "Nothing Compares 2 U" (1990, #1 US)'
        ];
        
        $mix = new VinylMix();
        $mix->setTitle($titles[array_rand($titles)]);
        $mix->setDescription('A pure mix of drummers turned singers!');
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $manager->persist($mix);
        $manager->flush();
    }
}
