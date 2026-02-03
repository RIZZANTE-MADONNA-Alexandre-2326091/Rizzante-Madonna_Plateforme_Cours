<?php

namespace App\DataFixtures;

use App\Entity\QCM;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QcmFixtures extends Fixture
{
    public const QCM_MATH = 'qcm_math';
    public const QCM_SYMFONY = 'qcm_symfony';
    public const QCM_PHP = 'qcm_php';

    public function load(ObjectManager $manager): void
    {
        $qcmFixtures = [
            self::QCM_MATH => 'QCM Mathématiques',
            self::QCM_SYMFONY => 'QCM Symfony',
            self::QCM_PHP => 'QCM PHP',
        ];
        foreach ($qcmFixtures as $ref => $qcmFixture)
        {
            $qcm = new QCM();
            $qcm->setNom($qcmFixture);
            $this->addReference($ref, $qcm);
            $manager->persist($qcm);
        }
        $manager->flush();
    }
}
