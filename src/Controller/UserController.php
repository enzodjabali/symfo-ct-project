<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('', name: 'app_user_index')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function index(UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_user_edit')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function edit(int $id, Request $request, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);

        $requestContent = json_decode($request->getContent(), true) ?? [];
        $form->submit($requestContent);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            return $this->json([]);
        } else {
            return $this->json(["error" => (string) $form->getErrors(true)]);
        }
    }
}