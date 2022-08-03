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
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[Route('/users')]
#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController
{
    #[Route('', name: 'app_user_index')]
    public function index(UserService $userService): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('user/index.html.twig', [
            'users' => $userService->getPaginatedUsers(15),
            'auth_user_role' => $this->getUser()->getRoles()[0],
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'app_user_edit', requirements: ['id'=>'\d+'])]
    public function edit(int $id, Request $request, UserRepository $userRepository, AuthorizationCheckerInterface $authorizationChecker): JsonResponse
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

            if ($user->getRoles()[0] != 'ROLE_SUPER_ADMIN' || ($user->getRoles()[0] == 'ROLE_SUPER_ADMIN' && $authorizationChecker->isGranted('ROLE_SUPER_ADMIN'))) {
                $userRepository->add($user, true);
                return $this->json([]);
            } else {
                return $this->json(["error" => "You're not allowed to perform this action"], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return $this->json(["error" => (string) $form->getErrors(true)], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}