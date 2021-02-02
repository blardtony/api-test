<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function getarticle(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json($articleRepository->findAll(), 200, [], ['groups' => 'get']);
    }


    /**
     * @Route("/article", name="postarticle", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function postarticle(Request $request,SerializerInterface $serializer): JsonResponse
    {
       $json = $request->getContent();
       $article = $serializer->deserialize($json,Article::class,"json");
       dd($article);
    }
}
