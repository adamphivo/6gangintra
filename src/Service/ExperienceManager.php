<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\ExperienceEvent;
use Doctrine\ORM\EntityManagerInterface;

class ExperienceManager
{
    private $em;
    
    private const SHIFTS = [
        "comment" => 20,
        "post" => 50,
    ];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createExperienceEvent(User $user, Post $post, string $eventType) : ExperienceEvent
    {
        $expEvent = new ExperienceEvent();

        $experienceShift = $this->getExperienceShift($eventType);

        $expEvent->setUser($user);
        $expEvent->setPost($post);
        $expEvent->setEventType($eventType);
        $expEvent->setExperienceShift($experienceShift);

        $this->updateUserExperience($user, $experienceShift);

        $this->em->persist($expEvent);
        $this->em->flush();

        return $expEvent;
    }

    public function getExperienceShift(string $eventType) : int
    {
        $experienceShift = ExperienceManager::SHIFTS[$eventType];
        return $experienceShift;
    }

    public function updateUserExperience(User $user, int $experienceShift) : User
    {
        $user->setExperience($user->getExperience() + $experienceShift);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}