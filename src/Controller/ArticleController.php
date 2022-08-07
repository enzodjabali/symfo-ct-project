<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Service\ArticleService;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles')]
class ArticleController extends AbstractController
{
    #[Route('', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleService $articleService): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleService->getPaginatedArticles(6),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setUser($this->getUser());
            $article->setPublicationDate(new \DateTime('now'));

            $articleRepository->add($article, true);

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(Article $article): Response
    {
        $commentForm = $this->createForm(CommentType::class, null, [
            'action' => $this->generateUrl('app_article_comment', ['id' => $article->getId()]),
            'method' => Request::METHOD_POST,
        ]);

        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm,
        ]);
    }

    #[Route('/{id}/comment', name: 'app_article_comment', requirements: ['id'=>'\d+'], methods: ['POST'])]
    public function comment(Request $request, Article $article, CommentRepository $commentRepository): RedirectResponse
    {
        $comment = new Comment;

        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setArticle($article);
            $comment->setUser($this->getUser());

            $parentId = $commentForm->get('parent_id')->getData();

            if (!is_null($parentId)) {
                $parent = $commentRepository->find($parentId);
                $comment->setParent($parent);
            }

            $commentRepository->add($comment, true);

            $this->addFlash(
                'success',
                'Your comment has been successfully added!'
            );
        }

        return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{article_id}/comment/{comment_id}', name: 'app_comment_delete', methods: ['POST'])]
    #[ParamConverter('article_id', options: ['mapping' => ['id' => 'article']])]
    #[ParamConverter('comment_id', options: ['mapping' => ['id' => 'comment']])]
    #[Entity('article', expr: 'repository.find(article_id)')]
    #[Entity('comment', expr: 'repository.find(comment_id)')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteComment(Request $request, Article $article, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->isCsrfTokenValid($comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);
        }

        $this->addFlash(
            'success',
            'The comment has been successfully deleted!'
        );

        return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', requirements: ['id'=>'\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedDate(new \DateTime('now'));

            $articleRepository->add($article, true);
            
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', requirements: ['id'=>'\d+'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
