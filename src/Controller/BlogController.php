<?php

namespace App\Controller;

use App\Command\AuthorizationCommand;
use App\Command\BlogListCommand;
use App\Command\DeleteBlogCommand;
use App\Command\NewBlogCommand;
use App\Repository\BlogRepository;
use App\Service\BlogService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    use HandleTrait;

    private MessageBusInterface $commandBus;
    private BlogService $blogService;

    public function __construct(
        MessageBusInterface $commandBus,
        MessageBusInterface $messageBus,
        BlogService $blogService
    ) {
        $this->commandBus = $commandBus;
        $this->messageBus = $messageBus;
        $this->blogService = $blogService;
    }


    #[Route('/blog', name: 'blog', methods: ['GET'])]
    public function listOfBlog(Request $request): Response
    {
        try {
            $this->checkAuthorization($request);
        } catch (HandlerFailedException $e) {
            return new Response($e->getPrevious()->getMessage(), 401);
        }
        $blogContent = $this->blogService->getListOfPosts();
        if (empty($blogContent)) {
            return new Response("", 204);
        }
        return new Response(json_encode($blogContent), 200);
    }


    #[Route('/blog/delete', name: 'blog_delete', methods: ['DELETE'])]
    public function deleteBlog(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->checkAuthorization($request);
        } catch (HandlerFailedException $e) {
            return new Response($e->getPrevious()->getMessage(), 401);
        }
        $this->commandBus->dispatch(new DeleteBlogCommand($data['id']));
        return new Response("Blog deleted successfully", 200);
    }


    #[Route('/blog/add', name: 'blog_add', methods: ['POST'])]
    public function addBlog(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->checkAuthorization($request);
        } catch (HandlerFailedException $e) {
            return new Response($e->getPrevious()->getMessage(), 401);
        }
        $this->commandBus->dispatch(new NewBlogCommand($data['text'],$request->headers->get('Authorization')));
        return new Response("Blog added successfully", 200);
    }


    private function checkAuthorization(Request $request, ?string $permission = null): void
    {
        $this->commandBus->dispatch(new AuthorizationCommand($request->headers->get('Authorization'), $permission));
    }
}