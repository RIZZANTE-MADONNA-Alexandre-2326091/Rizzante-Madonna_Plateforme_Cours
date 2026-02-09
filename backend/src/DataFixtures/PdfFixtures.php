<?php

namespace App\DataFixtures;

use App\Entity\QCM;
use App\Entity\PDF;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PdfFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $pdfFixtures = [
            [
                'fileName' => 'Introduction aux mathématiques',
                'file' => 'math_intro.pdf',
                'qcm' => QcmFixtures::QCM_MATH,
            ],
            [
                'fileName' => 'Bases de Symfony',
                'file' => 'symfony_basics.pdf',
                'qcm' => QcmFixtures::QCM_SYMFONY,
            ],
            [
                'fileName' => 'Comprendre PHP',
                'file' => 'php_fundamentals.pdf',
                'qcm' => QcmFixtures::QCM_PHP,
            ]
        ];

        foreach ($pdfFixtures as $pdfFixture)
        {
            $pdf = new PDF();
            $pdf->setFileName($pdfFixture["fileName"]);
            $pdf->setFile($pdfFixture["file"]);
            $pdf->setQcm($this->getReference($pdfFixture["qcm"], QCM::class));
            $manager->persist($pdf);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QcmFixtures::class,
        ];
    }
}
