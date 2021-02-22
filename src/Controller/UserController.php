<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserGenerator;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Normalizer\ArrayNormalizerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users_list" , methods={"GET"} )
     */
    public function getAllUserAction( UserRepository  $userRepository , SerializerInterface $serializer ): Response
    {
        
        
        // $users= $userRepository->findAll() ;
        // $json = $serializer->serialize($users, 'json');
        // $response = new JsonResponse( $json , 200 , [], true , ['groups'=>'users:read'] );
        // return $response;

        return $this->json($userRepository->findAll(), 200 , [] , ['groups'=>'users:read']);
        
        
    }

    /**
     * @Route("/users/{id}", name="users_one" , methods={"GET"} )
     */
    public function getOneUserAction(int $id): Response
    {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id);

        if (empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
            'id' => $user->getId(),
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName(),
            'address' => $user->getAddress(),
            'city' => $user->getCity(),
         ];

        return new JsonResponse([$formatted]);
    }

    /**
     * @Route("users/{id}", name="user_delete", methods={"DELETE"} )
     */
    public function deleteUserAction( User $id )
    {
        $doctrine = $this->getDoctrine()->getmanager();
        $doctrine->remove($id);
        $doctrine->flush();

        return new JsonResponse(['msg'=>'Utilisateur effacé!'], 200 );
    }


    /**
     * @Route("/users", name="users_new", methods={"POST"} )
     */
    public function saveUserAction(Request $request , UserGenerator $userGenerator ): Response
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $user=$userGenerator->createUser($data);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(
            [
                'status' => 'ok, données rentrée en BDD',
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/users/{id}", name="users_update", methods={"PUT"} )
     */
    public function updateUserAction( int $id , Request $request , SerializerInterface $serializer , UserGenerator $userGenerator,EntityManagerInterface $em )
    {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($request->get('id'));

        $data = json_decode(
            $request->getContent(),
            true
        );

        

        $user=$userGenerator->putUser($data , $user);        

        $em->persist($user);
        $em->flush();

        return $this->json($user, 201, []);
    }

    /**
     * @Route("/users/{id}", name="users_patch", methods={"PATCH"} )
     */
    public function patchUserAction( int $id , Request $request , SerializerInterface $serializer , UserGenerator $userGenerator,EntityManagerInterface $em )
    {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($request->get('id'));

        $data = json_decode(
            $request->getContent(),
            true
        );
        
        $user=$userGenerator->patchUser($data , $user);        

        $em->persist($user);
        $em->flush();

        return $this->json($user, 201, []);
    }




    
}