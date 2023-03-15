<?php

namespace App\Controller;

use App\Command\LoginCommand;
use App\Command\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    use HandleTrait;
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus, MessageBusInterface $messageBus)
    {
        $this->commandBus = $commandBus;
        $this->messageBus = $messageBus;
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        try {
            $this->commandBus->dispatch(
                new RegisterUserCommand(
                    $data['username'],
                    $data['password'],
                    $data['permission'],
                    $data['readonly']
                )
            );
            return new Response('User registered successfully', 201);
        } catch (HandlerFailedException $e) {
            return new Response($e->getPrevious()->getMessage(), 400);
        }
    }


    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        try {
         $token = $this->handle(new LoginCommand($data['username'], $data['password']));
            return new Response(json_encode(['token'=>$token]), Response::HTTP_OK);
        } catch (HandlerFailedException $e) {
            return new Response($e->getPrevious()->getMessage(), 400);
        }
    }


}