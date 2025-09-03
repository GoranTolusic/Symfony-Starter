<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, User::class);
        $this->em = $em;
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function save(User $user, ?array $tags = null, bool $flush = true): User
    {
        //Handling relation tags for insert
        if (is_array($tags) && !empty($tags)) {
            foreach ($tags as $label) {
                $tag = new Tag();
                $tag->label = $label;
                $tag->setUser($user);
                $user->getTags()->add($tag);
            }
        }

        $this->em->persist($user);
        if ($flush) $this->em->flush();
        return $user;
    }

    public function filter(?string $term, int $limit = 20, int $page = 1): array
    {
        $offset = ($page - 1) * $limit;
        $qb = $this->createQueryBuilder('u');

        //Applying where clause if term exists in request payload
        if ($term) {
            $qb->andWhere('u.email LIKE :term OR u.first_name LIKE :term OR u.last_name LIKE :term')
                ->setParameter('term', '%' . $term . '%');
        }

        // Clone query for total count before applying pagination
        $countQb = clone $qb;
        $total = (int) $countQb
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // Apply pagination
        $users = $qb->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();

        return [
            'data' => $users,
            'total' => $total,
        ];
    }
}
