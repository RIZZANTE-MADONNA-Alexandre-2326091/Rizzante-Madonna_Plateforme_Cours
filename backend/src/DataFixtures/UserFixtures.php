<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user = $this->createAdmin();
        $manager->persist($user);


        $user = $this->createStudent();
        $manager->persist($user);

        $user = $this->createTeacher();
        $manager->persist($user);

        $manager->flush();
    }

    private function createAdmin(): User
    {
        $admin = new User();
        $admin->setEmail('test.admin@mail.com');
        $admin->setPassword(hash('crc32c', 'administrateur'));
        $admin->setRoles(['ROLE_ADMIN']);
        return $admin;
    }

    private function createStudent(): User
    {
        $student = new User();
        $student->setEmail('test.etudiant@mail.com');
        $student->setPassword(hash('crc32c', 'student'));
        $student->setRoles(['ROLE_STUDENT']);
        return $student;
    }

    private function createTeacher(): User
    {
        $teacher = new User();
        $teacher->setEmail('test.professeur@mail.com');
        $teacher->setPassword(hash('crc32c', 'teacher'));
        $teacher->setRoles(['ROLE_TEACHER']);
        return $teacher;
    }
}
