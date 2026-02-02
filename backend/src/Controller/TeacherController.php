<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class TeacherController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN',
        message: "Erreur de permission: Accès refusé.\nVous n'avez pas accès à ce contenu",
        statusCode: 403,
        methods: ['GET', 'POST', 'PUT', 'DELETE']
    )]
    public function adminDashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Erreur 403 Forbidden');
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    }
}
