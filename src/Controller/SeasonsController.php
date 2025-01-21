<?php

namespace App\Controller;

use App\Entity\Series;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SeasonsController extends AbstractController
{
    public function __construct(private CacheInterface $cache) {}

    #[Route('/seasons', name: 'app_seasons')]
    public function index(Series $series): Response
    {
        $seasons = $this->cache->get('seasons_list', function (ItemInterface $item) use ($series) {
            $item->expiresAfter(new \DateInterval('PT10S'));

            return $series->getSeasons()->initialize();
        });

        return $this->render('seasons/index.html.twig', compact('seasons'));
    }
}
