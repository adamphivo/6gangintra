<?php

// Fixtures - Populate the database with fake data using faker package.
// php bin/console doctrine:fixtures:load -> Update database with fake data.

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Category;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\CategoryRepository;
use Faker;
use Indenter;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Creating the factory
        $faker = Faker\Factory::create('fr_FR');
        $indenter = new \Gajus\Dindent\Indenter();

        $categories = [
            "PHP" => "anything related to PHP",
            "JS" => "anythingre lated to JS",
            "Symfony" => "anything related to Symfony",
            "Drupal" => "anything related to Drupal",
            "CSS" => "anything related to CSS",
            "HTML" => "anything related to HTML",
            "Git" => "anything related to Git",
        ];

        $categoriesArray = Array();
        foreach($categories as $name => $description)
        {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);
            $categoriesArray[] = $category;
            $manager->persist($category);
        }

        // Populate users
        $users = Array();
        for($i = 0; $i < 50; $i++){
            $users[$i] = new User();
            $users[$i]->setExperience($faker->biasedNumberBetween($min = 1000, $max = 0, $function = 'sqrt'));
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPortraitUrl("https://picsum.photos/60/60/");
            $users[$i]->setUserName($faker->userName);
            $users[$i]->setPassword($this->encoder->encodePassword($users[$i],$faker->password));

            $manager->persist($users[$i]);
        }

        // Populate posts
        $posts = Array();
        for($i = 0; $i < 200; $i++){
            $posts[$i] = new Post();

            // Categories
            for($y = 0; $y < 5; $y++)
            {
                $posts[$i]->addCategory($categoriesArray[rand(1,count($categoriesArray) - 1)]);
            }

            //  Body
            $posts[$i]->setTitle($faker->catchPhrase);
            $posts[$i]->setCodeContent($indenter->indent($faker->randomHtml(2,3)));
            $posts[$i]->setDateAdded($faker->dateTimeThisYear());
            $posts[$i]->setTextContent($faker->realText);
            $posts[$i]->setGithubLink($faker->url);
            $posts[$i]->setYoutubeLink($faker->url);
            $posts[$i]->setMainTextContent($faker->realText);
            $posts[$i]->setUser($users[rand(0, count($users) - 1)]);
            $posts[$i]->getUser()->addPost($posts[$i]);

            $manager->persist($posts[$i]);
        }

        // Populate comments
        $comments = Array();
        for($i = 0; $i < 400; $i++){
            $comments[$i] = new Comment();
            $comments[$i]->setUser($users[rand(0, count($users) - 1)]);
            $comments[$i]->setPost($posts[rand(0, count($posts) - 1)]);
            $comments[$i]->setTextContent($faker->realText);
            $comments[$i]->setDateAdded($faker->dateTimeThisYear());

            $manager->persist($comments[$i]);
        }

        // // Make changes
        $manager->flush();
    }
}
