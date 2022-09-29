<?php namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VinylMixRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\VinylMix;

class MixController extends AbstractController
{
    #[Route('/mix/new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
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

        $entityManager->persist($mix);
        $entityManager->flush();

        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80\'s heaven',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }

    #[Route('/mix/{slug}', name: 'app_mix_show')]
    public function show(VinylMix $mix): Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
        ]);
    }

    #[Route('/mix/{slug}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request,EntityManagerInterface $entityManager): Response
    {
        $direction = $request->request->get('direction', 'up');
        
        if ($direction === 'up') {
            $mix->upVote();
        } else {
            $mix->downVote();
        }

        $entityManager->flush();
        $this->addFlash('success', 'Vote counted!');

        return $this->redirectToRoute('app_mix_show', [
            'slug' => $mix->getSlug(),
        ]);
    }
}