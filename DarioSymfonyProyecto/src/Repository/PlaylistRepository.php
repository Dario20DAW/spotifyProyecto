<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Playlist>
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    //    /**
    //     * @return Playlist[] Returns an array of Playlist objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findOneByNombre($nombre): ?Playlist
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nombre = :val')
            ->setParameter('val', $nombre)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findConPropietario(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nombre = :val')
            ->andWhere('p.propietario IS NOT NULL')  // Asegúrate de que propietario no sea NULL
            ->getQuery()
            ->getResult();  // Devuelve un array con los resultados
    }



    public function getPlaylistsPorLikes(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.nombre, p.likes')
            ->orderBy('p.likes', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getPlaylistsPorReproducciones(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.nombre, p.reproducciones')
            ->orderBy('p.reproducciones', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
