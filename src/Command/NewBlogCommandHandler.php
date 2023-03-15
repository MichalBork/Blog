<?php

namespace App\Command;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NewBlogCommandHandler
{

        private BlogRepository $blogRepository;
        private TokenRepository $tokenRepository;
    public function __construct(BlogRepository $blogRepository, TokenRepository $tokenRepository)
        {
            $this->blogRepository = $blogRepository;
            $this->tokenRepository = $tokenRepository;
        }

        public function __invoke(NewBlogCommand $command): void
        {
            try {
                $user = $this->tokenRepository->findOneBy(['id' => $command->getUserToken()])->getUser();
            } catch (\Throwable $e) {
                dd($e->getMessage());
                throw new \Exception('User not found invalid token');
            }

           $blog = new Blog($command->getText(), $user);

            $this->blogRepository->save($blog);
        }

}