<?php

namespace App\Service;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    public function __construct(
        private RequestStack $requestStack,
        private UserRepository $userRepository,
        private PaginatorInterface $paginator
    )
    {}

    public function getPaginatedUsers(int $limit): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        assert($request instanceof Request);
        
        $page = $request->query->getInt('page', 1);
        $usersQuery = $this->userRepository->findUsersForPagination();

        return $this->paginator->paginate($usersQuery, $page, $limit);
    }
}