<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticleService
{
    public function __construct(
        private RequestStack $requestStack,
        private ArticleRepository $articleRepository,
        private PaginatorInterface $paginator
    )
    {}

    public function getPaginatedArticles(int $limit): PaginationInterface
    {
        $request = $this->requestStack->getMainRequest();
        assert($request instanceof Request);
        
        $page = $request->query->getInt('page', 1);
        $articlesQuery = $this->articleRepository->findArticlesForPagination();

        return $this->paginator->paginate($articlesQuery, $page, $limit);
    }
}