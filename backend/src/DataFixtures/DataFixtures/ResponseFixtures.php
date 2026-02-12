<?php

namespace App\DataFixtures\DataFixtures;

use App\Entity\QCM;
use App\Entity\Response;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ResponseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $responseFixtures = [
            // QCM Math
            [
                'libbele' => 'Combien font 2 + 2 ?',
                'reponse' => '4',
                'qcm' => QCMFixtures::QCM_MATH,
                'type' => 'Unique'
            ],
            [
                'libbele' => 'Racine carrée de 16 ?',
                'reponse' => '4',
                'qcm' => QCMFixtures::QCM_MATH,
                'type' => 'Unique'
            ],
            // QCM Symfony
            [
                'libbele' => 'Citez des langages Web.',
                'reponse' => 'PHP,JS',
                'qcm' => QCMFixtures::QCM_LANGAGES,
                'type' => 'Multiple'
            ],
            [
                'libbele' => 'Quel ORM est utilisé par défaut avec Symfony ?',
                'reponse' => 'Doctrine',
                'qcm' => QCMFixtures::QCM_SYMFONY,
                'type' => 'Unique'
            ],
            // QCM PHP
            [
                'libbele' => 'Que signifie PHP ?',
                'reponse' => 'PHP: Hypertext Preprocessor',
                'qcm' => QCMFixtures::QCM_PHP,
                'type' => 'Unique'
            ],
        ];
        foreach ($responseFixtures as $responseFixture)
        {
            $response = new Response();
            $response->setLibbele($responseFixture["libbele"]);
            $response->setReponse($responseFixture["reponse"]);
            $response->setQcm($this->getReference($responseFixture["qcm"], QCM::class));
            $response->setType($responseFixture["type"]);
            $manager->persist($response);
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
