<?php

// Fixtures - Populate the database with fake data using faker package.
// php bin/console doctrine:fixtures:load -> Update database with fake data.

// USING FAKE
// $faker = Faker\Factory::create();
// generate data by accessing properties
// echo $faker->name;
// 'Lucy Cechtelar';
// echo $faker->address;
// "426 Jordy Lodge
// Cartwrightshire, SC 88120-6700"
// echo $faker->text;

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;
use Faker;
use Indenter;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $posts[$i] = new Product();
        // $manager->persist($posts[$i]);
        // Creating the factory
        $faker = Faker\Factory::create('fr_FR');
        $indenter = new \Gajus\Dindent\Indenter();

        $users = Array();
        // Users
        for($i = 0; $i < 50; $i++){
            $users[$i] = new User();
            $users[$i]->setExperience($faker->numberBetween($min = 0, $max = 1000));
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPortraitUrl("https://picsum.photos/120/120/?blur");
            $users[$i]->setUserName($faker->userName);
            $users[$i]->setPassword($faker->password);

            $manager->persist($users[$i]);
        }

        $posts = Array();
        // Posts
        for($i = 0; $i < 500; $i++){
            $posts[$i] = new Post();
            $posts[$i]->setTitle($faker->catchPhrase);
            $posts[$i]->setCodeContent($indenter->indent($faker->randomHtml(2,3)));
            $posts[$i]->setDateAdded($faker->dateTimeThisYear());
            $posts[$i]->setTextContent($faker->realText);
            $posts[$i]->setUser($users[rand(1, count($users)) - 1]);

            $manager->persist($posts[$i]);
        }


        // Make changes
        $manager->flush();
    }
}
