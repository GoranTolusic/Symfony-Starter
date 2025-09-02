<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class TagRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Tag::class);
        $this->em = $em;
    }

    public function saveTags(User $user, array $tags): void
    {
        foreach ($tags as $tag) {
            $tagEntity = new Tag();
            $tagEntity->setUser($user);
            $tagEntity->label = $tag;
            $this->em->persist($tagEntity);
        }
        $this->em->flush();
    }
}
