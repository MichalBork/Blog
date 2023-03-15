<?php

namespace App\Command;

use App\Repository\BlogRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteBlogCommandHandler
{

    private BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function __invoke(DeleteBlogCommand $command): void
    {

        $blog = $this->blogRepository->findOneBy(['id' => $command->getId()]);
        $this->blogRepository->remove($blog);


    }
}