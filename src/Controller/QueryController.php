<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\UndefinedRepository;
use App\Repository\QueryRepository;
use App\Repository\ResponseRepository;

class QueryController extends AbstractController
{
    private UndefinedRepository $undefinedRepo;
    private QueryRepository $queryRepo;
    private ResponseRepository $responseRepo;

    public function __construct(
        UndefinedRepository $undefinedRepo,
        QueryRepository $queryRepo,
        ResponseRepository $responseRepo

    )
    {
        $this->undefinedRepo = $undefinedRepo;
        $this->queryRepo = $queryRepo;
        $this->responseRepo = $responseRepo;
    }

    #[Route('/query', name: 'query', methods: "GET")]
    public function query(Request $request): Response
    {
        $response = new Response();

        $word = $request->query->get('string');
        /*
        $words = explode(' ', $word);
        $response->setContent(json_encode([
            'word' => $word,
            'type' => 'test',
            'data' => $words
        ]));
        return $response;
        */


        # check if this word is already searched;
        //$query = $this->queryRepo->findOneBy(['term' => $word]);
        $query = $this->queryRepo->findByTitleLike( $word );
        
        if ($query)
        {
            # Yes, this word is already used for search, get it's responses and return random one;
            $responses = $this->responseRepo->findBy(['id_Query_FK' => $query[0]->getId()]);
            $intResponseCount = count($responses) - 1;
            $randIndex = rand( 0, $intResponseCount );
            $objResponse = $responses[ $randIndex ];

            $response->setContent(json_encode([
                'word' => $word,
                'type' => 'query',
                'data' => [
                    'title' => $objResponse->getTitle(),
                    'url' => $objResponse->getUrl(),
                    'description' => $objResponse->getDescription(),
                    'logo' => $objResponse->getLogo()
                ]
            ]));
        }
        else
        {
            $rows = $this->undefinedRepo->findAll( $word );
            $intRowsCount = count($rows) - 1;
            $randIndex = rand( 0, $intRowsCount );
            $objRow = $rows[ $randIndex ];

            $response->setContent(json_encode([
                'word' => $word,
                'type' => 'undefined',
                'data' => [
                    'title' => $objRow->getTitle(),
                    'url' => $objRow->getUrl(),
                    'description' => $objRow->getDescription(),
                    'logo' => $objRow->getLogo()
                ]
            ]));
        }

        // Add CORS headers
        $response->headers->set('Access-Control-Allow-Origin', '*');
        //$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        //$response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        //$response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;

    }

    #[Route('/queryv2', name: 'queryv2', methods: "GET")]
    public function queryv2(Request $request): JsonResponse
    {
        $word = $request->query->get('string');

        # check if this word is already searched;
        //$query = $this->queryRepo->findOneBy(['term' => $word]);
        $query = $this->queryRepo->findByTitleLike( $word );
        
        if ($query)
        {
            # Yes, this word is already used for search, get it's responses and return random one;
            $responses = $this->responseRepo->findBy(['id_Query_FK' => $query[0]->getId()]);
            $intResponseCount = count($responses) - 1;
            $randIndex = rand( 0, $intResponseCount );
            $objResponse = $responses[ $randIndex ];

            return new JsonResponse([
                'word' => $word,
                'type' => 'query',
                'data' => [
                    'title' => $objResponse->getTitle(),
                    'url' => $objResponse->getUrl(),
                    'description' => $objResponse->getDescription(),
                    'logo' => $objResponse->getLogo()
                ]
            ], 200);

        }

        $rows = $this->undefinedRepo->findAll( $word );
        $intRowsCount = count($rows) - 1;
        $randIndex = rand( 0, $intRowsCount );
        $objRow = $rows[ $randIndex ];

        return new JsonResponse([
            'word' => $word,
            'type' => 'undefined',
            'data' => [
                'title' => $objRow->getTitle(),
                'url' => $objRow->getUrl(),
                'description' => $objRow->getDescription(),
                'logo' => $objRow->getLogo()
            ]
        ], 200);

    }
}
