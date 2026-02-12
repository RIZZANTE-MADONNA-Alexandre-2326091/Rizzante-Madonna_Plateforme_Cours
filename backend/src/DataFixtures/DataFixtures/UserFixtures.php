<?php

namespace App\DataFixtures\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const TEACHER_USER_REFERENCE = 'teacher-user';
    public const STUDENT_USER_REFERENCE = 'student-user';

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
        $admin->setPassword(hash('sha256', 'administrateur'));
        $admin->setRoles(['ROLE_ADMIN']);
        $this->addReference(self::ADMIN_USER_REFERENCE, $admin);
        return $admin;
    }

    private function createStudent(): User
    {
        $student = new User();
        $student->setEmail('test.etudiant@mail.com');
        $student->setPassword(hash('sha256', 'student'));
        $student->setRoles(['ROLE_STUDENT']);
        $this->addReference(self::STUDENT_USER_REFERENCE, $student);
        return $student;
    }

    private function createTeacher(): User
    {
        $teacher = new User();
        $teacher->setEmail('test.professeur@mail.com');
        $teacher->setPassword(hash('sha256', 'teacher'));
        $teacher->setRoles(['ROLE_TEACHER']);
        $this->addReference(self::TEACHER_USER_REFERENCE, $teacher);
        return $teacher;
    }
}
