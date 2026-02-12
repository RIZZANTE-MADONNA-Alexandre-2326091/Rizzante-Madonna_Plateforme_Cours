<?php

namespace App\DataFixtures;

use App\Entity\QCM;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QcmFixtures extends Fixture implements DependentFixtureInterface
{
    public const QCM_MATH = 'qcm_math';
    public const QCM_SYMFONY = 'qcm_symfony';
    public const QCM_PHP = 'qcm_php';
    public const QCM_LANGAGES = 'qcm_langages';

    public function load(ObjectManager $manager): void
    {
        $qcmFixtures = [
            self::QCM_MATH => 'QCM Mathématiques',
            self::QCM_SYMFONY => 'QCM Symfony',
            self::QCM_LANGAGES => 'QCM Langages du Web',
            self::QCM_PHP => 'QCM PHP',
        ];
        $student = $this->getReference(UserFixtures::STUDENT_USER_REFERENCE, User::class);
        foreach ($qcmFixtures as $ref => $qcmFixture)
        {
            $qcm = new QCM();
            $qcm->setNom($qcmFixture);
            $qcm->setProfile($student);
            $this->addReference($ref, $qcm);
            $manager->persist($qcm);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
