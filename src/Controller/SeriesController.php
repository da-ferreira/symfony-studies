<?php

namespace App\Controller;

use App\Entity\Series;
use App\Message\SeriesWasCreated;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class SeriesController extends AbstractController
{
    public function __construct(
        private SeriesRepository $seriesRepository,
        private MessageBusInterface $bus
    ) {}

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
        $content = json_decode($request->getContent());

        $series = new Series($content->name);

        $this->seriesRepository->add($series, flush: true);

        $this->bus->dispatch(new SeriesWasCreated($series));

        return new Response('Series created successfully', Response::HTTP_CREATED);
    }

    #[Route('/series/delete/{id}', name: 'app_series_delete', methods: ['DELETE'], requirements: ['id' => '[0-9]+'])]
    public function delete(int $id)
    {
        $this->seriesRepository->removeById($id);

        return new Response('Series deleted successfully', Response::HTTP_OK);
    }
}
