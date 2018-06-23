<?php

namespace App\Repository;

use App\Entity\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function getSubscription(): array
    {
        $qb = $this->createQueryBuilder('subscription')
            ->getQuery();

        return $qb->execute();
    }

    public function getSubscriptionByUser($userId): array
    {
        $qb = $this->getRepository()
        ->createQueryBuilder()
        	->andWhere('user_id = '.$user_id)
        	->andWhere('user_id = {$user_id}')
            ->getQuery();

        return $qb->execute();
    }
}
