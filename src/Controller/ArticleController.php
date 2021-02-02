<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/articles", name="articles", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getarticles(ArticleRepository $articleRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($articleRepository->findAll(), 'json', ['groups' => 'get']),
            200,
            [],
            true
        );

    }

    /**
     * @Route("/api/user/articles", name="postarticles", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function postarticles(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UserRepository $userRepository): JsonResponse
    {
        $auteur = $this->getUser();

        $article = $serializer->deserialize($request->getContent(), Article::class, 'json');
        $article->setDate(new \DateTime());
        $article->setAuteur($auteur);
        //dd($article);
        $entityManager->persist($article);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($article, "json", ['groups' => 'get']),
            201,
            [],
            true
        );
    }


    /**
     * @Route("/article", name="postarticle", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function postarticle(Request $request,SerializerInterface $serializer, EntityManagerInterface $em, UserRepository $userRepository): JsonResponse
    {
       $json = $request->getContent();
       $data = json_decode($json, true);
       //dd($data["auteur"]["id"]);

       $article = new Article();

       $article->setTitre($data["titre"]);
       $article->setDescription($data["description"]);
       $article->setDate(new \DateTime());

       $auteur = $userRepository->find($data["auteur"]["id"]);
       $article->setAuteur($auteur);

       //dd($article);
       $em->persist($article);
       $em->flush();

        return $this->json([
            'success' => true,
            'idUser' => $article->getId()
        ]);


    }
}
