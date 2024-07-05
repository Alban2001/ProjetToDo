<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur par défaut (anonyme)
        $userAnonyme = new User();
        $userAnonyme->setNom("Anonyme");
        $userAnonyme->setPrenom("Anonyme");
        $userAnonyme->setEmail("anonyme@mail.fr");
        $userAnonyme->setPassword("no password");
        $userAnonyme->setRoles(["ROLE_USER"]);
        $manager->persist($userAnonyme);

        // Création d'un utilisateur de type administrateur
        $admin = new User();
        $admin->setNom("Admin");
        $admin->setPrenom("Admin");
        $admin->setEmail("admin@mail.fr");
        $admin->setPassword('$2y$10$EL0QLLEPVL6UT8ramWWrMe63sVv5/nhQha/wD3MwbKWkFBGjZaCly'); // Admin93498?!
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        // Création d'un utilisateur de type user
        $user = new User();
        $user->setNom("Alban");
        $user->setPrenom("VOIRIOT");
        $user->setEmail("alban.voiriot@gmail.com");
        $user->setPassword('$2y$10$2xnQlqwwebeVeElvu3TLre1e1lA0A6TuG.Jk8DwpXVTLB7x2YDFnS'); // Alban93498?!
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);

        // Création de 5 tâches ratachées à des utilisateurs anonymes
        for ($i = 1; $i <= 5; $i++) {
            $task = new Task();
            $task->setTitle("Task N°" . $i);
            $task->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum");
            $task->setCreatedAt(new \DateTime());
            $tasksDone = [true, false];
            $task->setDone(array_rand($tasksDone));
            $task->setOneUser($userAnonyme);
            $manager->persist($task);
        }
        $manager->flush();
    }
}
