<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Article;
use Symfony\Component\Serializer\SerializerInterface;


class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article", methods={"GET"})
     */
    public function getarticle(SerializerInterface $serializer): JsonResponse
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        dump($articles);
        //dump($serializer->serialize($articles, "json", ["groups" => "get"]));
        return new JsonResponse($serializer->serialize($articles, "json", ["groups" => "get"]));


    }
}
