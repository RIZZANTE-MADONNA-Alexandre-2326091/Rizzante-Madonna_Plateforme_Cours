<?php

namespace App\Controller;

use App\Entity\PDF;
use App\Entity\Video;
use App\Entity\QCM;
use App\Entity\Response as QcmResponse;
use App\Service\MistralService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_TEACHER')]
class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'teacher_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('teacher/index.html.twig', [
            'pdfs' => $em->getRepository(PDF::class)->findAll(),
            'videos' => $em->getRepository(Video::class)->findAll(),
            'qcms' => $em->getRepository(QCM::class)->findAll(),
        ]);
    }

    #[Route('/teacher/upload', name: 'teacher_upload', methods: ['POST'])]
    public function upload(Request $request, EntityManagerInterface $em): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('attachment');
        $type = $request->request->get('file_type'); // 'pdf' ou 'video'

        if (!$file) {
            $this->addFlash('error', 'Aucun fichier sélectionné.');
            return $this->redirectToRoute('teacher_dashboard');
        }

        // Lecture du contenu binaire pour le champ BLOB
        $fileContent = file_get_contents($file->getPathname());

        if ($type === 'pdf') {
            $resource = new PDF();
        } else {
            $resource = new Video();
        }

        $resource->setFileName($file->getClientOriginalName());
        $resource->setFile($fileContent);

        $em->persist($resource);
        $em->flush();

        $this->addFlash('success', 'Fichier uploadé avec succès !');
        return $this->redirectToRoute('teacher_dashboard');
    }

    #[Route('/teacher/generate-qcm', name: 'teacher_generate_qcm', methods: ['POST'])]
    public function generate(Request $request, MistralService $mistralService, EntityManagerInterface $em): Response
    {
        $text = $request->request->get('context_text');
        $name = $request->request->get('qcm_name');
        $typeQcm = $request->request->get('type');

        // Optionnel : lier à une ressource existante
        $pdfId = $request->request->get('pdf_id');

        try {
            $questions = $mistralService->generateQcm($text, $typeQcm);

            $qcm = new QCM();
            $qcm->setNom($name);

            foreach ($questions as $qData) {
                $resp = new QcmResponse();
                $resp->setLibbele($qData['question']);
                $resp->setReponse($qData['reponse']);
                $resp->setQcm($qcm);
                $em->persist($resp);
            }

            if ($pdfId) {
                $pdf = $em->getRepository(PDF::class)->find($pdfId);
                if ($pdf) $pdf->setQcm($qcm);
            }

            $em->persist($qcm);
            $em->flush();

            $this->addFlash('success', 'QCM généré et lié !');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur : ' . $e->getMessage());
        }

        return $this->redirectToRoute('teacher_dashboard');
    }

    #[Route('/teacher/delete/{type}/{id}', name: 'teacher_delete_resource', methods: ['POST', 'DELETE'])]
    public function deleteResource(string $type, int $id, EntityManagerInterface $em): Response
    {
        // On détermine quelle entité chercher selon le type passé dans l'URL
        $entity = match ($type) {
            'pdf' => $em->getRepository(PDF::class)->find($id),
            'video' => $em->getRepository(Video::class)->find($id),
            'qcm' => $em->getRepository(QCM::class)->find($id),
            default => null,
        };

        if (!$entity) {
            $this->addFlash('error', 'Ressource introuvable.');
            return $this->redirectToRoute('teacher_dashboard');
        }

        try {
            $em->remove($entity);
            $em->flush();
            $this->addFlash('success', 'La ressource a été supprimée avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }

        return $this->redirectToRoute('teacher_dashboard');
    }
}
