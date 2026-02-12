<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\MistralService;

final class QcmController extends AbstractController
{
    #[Route('/qcm', name: 'app_qcm', methods: ['GET', 'POST'])]
    public function index(Request $request, MistralService $mistralService): Response
    {
        $qcmData = null;
        $error = null;

        if ($request->isMethod('POST')) {
            $text = $request->request->get('content');
            $nbQuestions = $request->request->get('nombreQuestions', '10'); // 'vrai_faux' ou 'multiple'

            if (!empty($text)) {
                try {
                    $qcmData = $mistralService->generateQcm($text, $nbQuestions);
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        return $this->render('qcm/index.html.twig', [
            'qcm' => $qcmData,
            'error' => $error
        ]);
    }
}
