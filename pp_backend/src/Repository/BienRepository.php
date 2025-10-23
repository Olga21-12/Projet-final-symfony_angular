<?php

namespace App\Repository;

use App\Entity\Bien;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Bien>
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }

    /**
     * Retourne une requête filtrée selon les paramètres donnés (pour la pagination)
     */
    public function searchBiensQuery(SearchData $data): Query
    {
        $qb = $this->createQueryBuilder('b')
            ->leftJoin('b.emplacement', 'e')->addSelect('e')
            ->leftJoin('b.type', 't')->addSelect('t')
            ->leftJoin('b.typeActivite', 'a')->addSelect('a')
            ->leftJoin('b.confort', 'c')->addSelect('c')
            ->leftJoin('b.photos', 'p')->addSelect('p')
            ->leftJoin('b.user', 'u')->addSelect('u')
            ->orderBy('b.createdAt', 'DESC');

        // Recherche textuelle (adresse ou description)
        if (!empty($data->q)) {
            $qb->andWhere('b.adresse LIKE :q OR b.description LIKE :q')
               ->setParameter('q', '%' . $data->q . '%');
        }

        // Type (appartement, maison, etc.)
        if (!empty($data->type)) {
            $qb->andWhere('t.typeDeBien = :type')
               ->setParameter('type', $data->type);
        }

        // Activité (location_courte, vente, etc.)
        if (!empty($data->activite)) {
            $qb->andWhere('a.typeActivite = :activite')
               ->setParameter('activite', $data->activite);
        }

        // Pays
        if (!empty($data->pays)) {
            $qb->andWhere('e.pays = :pays')
               ->setParameter('pays', $data->pays);
        }

        // Ville
        if (!empty($data->ville)) {
            $qb->andWhere('e.ville = :ville')
               ->setParameter('ville', $data->ville);
        }

        // Chambres
        if ($data->chambres > 0) {
            $qb->andWhere('b.nombreDeChambres >= :chambres')
               ->setParameter('chambres', $data->chambres);
        }

        // Prix
        if (!empty($data->prixMin)) {
            $qb->andWhere('b.prix >= :prixMin')
               ->setParameter('prixMin', $data->prixMin);
        }
        if (!empty($data->prixMax)) {
            $qb->andWhere('b.prix <= :prixMax')
               ->setParameter('prixMax', $data->prixMax);
        }

        // Surface
        if (!empty($data->surfaceMin)) {
            $qb->andWhere('b.surface >= :surfaceMin')
               ->setParameter('surfaceMin', $data->surfaceMin);
        }
        if (!empty($data->surfaceMax)) {
            $qb->andWhere('b.surface <= :surfaceMax')
               ->setParameter('surfaceMax', $data->surfaceMax);
        }

        // Conforts (TV, Internet, etc.)
        if (!empty($data->conforts)) {
            $qb->andWhere('c.name IN (:conforts)')
                ->setParameter('conforts', $data->conforts);
        }

        return $qb->getQuery();
    }
}