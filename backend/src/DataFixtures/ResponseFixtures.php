<?php

namespace App\DataFixtures;

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
            ],
            [
                'libbele' => 'Racine carrée de 16 ?',
                'reponse' => '4',
                'qcm' => QCMFixtures::QCM_MATH,
            ],
            // QCM Symfony
            [
                'libbele' => 'Quel langage est utilisé par Symfony ?',
                'reponse' => 'PHP',
                'qcm' => QCMFixtures::QCM_SYMFONY,
            ],
            [
                'libbele' => 'Quel ORM est utilisé par défaut avec Symfony ?',
                'reponse' => 'Doctrine',
                'qcm' => QCMFixtures::QCM_SYMFONY,
            ],
            // QCM PHP
            [
                'libbele' => 'Que signifie PHP ?',
                'reponse' => 'PHP: Hypertext Preprocessor',
                'qcm' => QCMFixtures::QCM_PHP,
            ],
        ];
        foreach ($responseFixtures as $responseFixture)
        {
            $response = new Response();
            $response->setLibbele($responseFixture["libbele"]);
            $response->setReponse($responseFixture["reponse"]);
            $response->setQcm($this->getReference($responseFixture["qcm"], QCM::class));
            $manager->persist($response);
        }
        $manager->flush();
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QcmFixtures::class,
        ];
    }
}
