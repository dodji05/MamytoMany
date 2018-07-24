<?php

namespace App\Repository;

use App\Entity\Genus;
use App\Entity\GenusNote;
use Doctrine\ORM\EntityRepository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GenusNoteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GenusNote::class);
    }
    /**
     * @param Genus $genus
     * @return GenusNote[]
     */
    public function findAllRecentNotesForGenus(Genus $genus)
    {
        return $this->createQueryBuilder('genus_note')
            ->andWhere('genus_note.genus = :genus')
            ->setParameter('genus', $genus)
            ->andWhere('genus_note.createdAt > :recentDate')
            ->setParameter('recentDate', new \DateTime('-3 months'))
            ->orderBy('genus_note.createdAt', 'DESC')
            ->getQuery()
            ->execute();
    }
}
