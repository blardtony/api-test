<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @Route("/api/user/me", name="article", methods={"GET"})
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getInfos(SerializerInterface $serializer): JsonResponse
    {
        //dd($this->getUser());
        return new JsonResponse(
            $serializer->serialize($this->getUser(), 'json', ['groups' => 'get']),
            200,
            [],
            true
        );
    }

}
