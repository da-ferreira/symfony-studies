<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeriesController extends AbstractController
{
    public function __construct(private SeriesRepository $seriesRepository) {}

    #[Route('/series', name: 'app_series_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $seriesList = $this->seriesRepository->findAll();

        $seriesData = array_map(
            fn($series) => [
                'id' => $series->getId(),
                'name' => $series->getName()
            ],
            $seriesList
        );

        return new JsonResponse($seriesData);
    }

    #[Route('/series', name: 'app_series_add', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $name = $request->request->get('name');
        $series = new Series($name);

        $this->seriesRepository->add($series, flush: true);

        return new Response('Series created successfully', Response::HTTP_CREATED);
    }
}
