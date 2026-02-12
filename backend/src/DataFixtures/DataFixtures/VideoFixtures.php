<?php

namespace App\DataFixtures\DataFixtures;

use App\Entity\QCM;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $videoFixtures = [
            [
                'fileName' => 'Introduction aux mathématiques',
                'file' => 'math_intro.mp4',
                'qcm' => QcmFixtures::QCM_MATH,
            ],
            [
                'fileName' => 'Bases de Symfony',
                'file' => 'symfony_basics.mp4',
                'qcm' => QcmFixtures::QCM_SYMFONY,
            ],
            [
                'fileName' => 'Comprendre PHP',
                'file' => 'php_fundamentals.mp4',
                'qcm' => QcmFixtures::QCM_PHP,
            ]
        ];

        foreach ($videoFixtures as $videoFixture)
        {
            $video = new Video();
            $video->setFileName($videoFixture["fileName"]);
            $video->setFile($videoFixture["file"]);
            $video->setQcm($this->getReference($videoFixture["qcm"], QCM::class));
            $manager->persist($video);
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
