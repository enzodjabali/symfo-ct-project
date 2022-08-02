<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserService;
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
    public function index(UserService $userService): Response
    {

        // $userTest = new User();
        // $userTest->setId(4);
        // dd($userTest->getId());

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('user/index.html.twig', [
            'users' => $userService->getPaginatedUsers(15),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_user_edit')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function edit(int $id, Request $request, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);
        assert($user instanceof User);

        $form = $this->createForm(UserType::class, $user);

        $formContent = $request->getContent();
        assert(is_string($formContent));

        $requestContent = json_decode($formContent, true) ?? [];
        assert(is_array($requestContent));

        $form->submit($requestContent);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            return $this->json([]);
        } else {
            return $this->json(["error" => (string) $form->getErrors(true)]);
        }
    }
}