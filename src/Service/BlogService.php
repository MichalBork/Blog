<?php

namespace App\Service;

use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Response;

class BlogService
{

    private BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }


    public function getListOfPosts(): array
    {
        $blogContent = [];
        $listOfBlog = $this->blogRepository->findAll();

        foreach ($listOfBlog as $blog) {
            $blogContent[] = $blog->getText();
        }

        return $blogContent;
    }

}