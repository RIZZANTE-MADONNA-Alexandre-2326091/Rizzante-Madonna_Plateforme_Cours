<?php

namespace App\Controller;
use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_TEACHER')]
class TeacherController extends AbstractController
{
    #[IsGranted('ROLE_TEACHER',
        message: "Erreur de permission: Accès refusé.\nVous n'avez pas accès à ce contenu",
        statusCode: 403,
        methods: ['GET', 'POST', 'PUT', 'DELETE']
    )]
    #[Route('/teacher', name: 'teacher')]
    public function teacher(): Response
    {
        try
        {
            $this->verifyAuthentification();
            return $this->render('teacher/teacher.html.twig');
        }
        catch (AccessDeniedException $accessDeniedException)
        {
            return $this->render('exception/accessDeniedException.html.twig');
        }


    }

    private function verifyAuthentification(): void
    {
        $this->denyAccessUnlessGranted('ROLE_TEACHER', null, 'Erreur 403 Forbidden');
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    }
}
