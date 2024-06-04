<?php

namespace App\Repository;

use App\DTO\CountFilter;
use App\Entity\Log;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Log>
 *
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository implements LogRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function save(Log ...$logs): void
    {
        foreach ($logs as $log) {
            $this->_em->persist($log);
        }

        $this->_em->flush();
        $this->_em->clear();
    }

    public function getCountByFilter(CountFilter $countFilter): int
    {
        $qb = $this->createQueryBuilder('l')->select('count(l.id)');

        if (isset($countFilter->serviceNames)) {
            $qb->andWhere(
                $qb->expr()->in('l.serviceName', ':serviceNames')
            )
                ->setParameter('serviceNames', $countFilter->serviceNames);
        }

        if (isset($countFilter->statusCode)) {
            $qb->andWhere('l.statusCode = :statusCode')
                ->setParameter('statusCode', $countFilter->statusCode);
        }

        if (isset($countFilter->startDate)) {
            $qb->andWhere(
                $qb->expr()->gte('l.dateTime', ':startDate'),
            )
                ->setParameter('startDate', $countFilter->startDate);
        }

        if (isset($countFilter->endDate)) {
            $qb->andWhere(
                $qb->expr()->lte('l.dateTime', ':endDate'),
            )
                ->setParameter('endDate', $countFilter->endDate);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function truncate(): void
    {
        $this->createQueryBuilder('l')
            ->delete()
            ->getQuery()
            ->getSingleScalarResult();
    }
}
