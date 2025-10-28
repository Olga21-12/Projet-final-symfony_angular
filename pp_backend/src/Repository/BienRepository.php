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
      //  ->leftJoin('b.confort', 'c')->addSelect('c')
        ->orderBy('b.createdAt', 'DESC');

    // Recherche par mot-clé
    if (!empty($data->q)) {
        $qb->andWhere('b.adresse LIKE :q OR b.description LIKE :q')
           ->setParameter('q', '%' . $data->q . '%');
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

    // Type de bien
    if (!empty($data->type)) {
        $qb->andWhere('t.type_de_bien = :type')
        ->setParameter('type', $data->type);
    }

    //  Type d’activité
    if (!empty($data->activite)) {
        $qb->andWhere('a.type_activite = :activite')
           ->setParameter('activite', $data->activite);
    }

    //  Prix maximum
    if (!empty($data->prixMax)) {
        $qb->andWhere('b.prix <= :prixMax')
           ->setParameter('prixMax', (float)$data->prixMax);
    }

    //  Surface maximum
    if (!empty($data->surfaceMax)) {
        $qb->andWhere('b.surface <= :surfaceMax')
           ->setParameter('surfaceMax', (float)$data->surfaceMax);
    }

    //  Chambres
    if (!empty($data->chambres)) {
        $qb->andWhere('b.nombre_de_chambres >= :chambres')
           ->setParameter('chambres', (int)$data->chambres);
    }
/*
    //  Conforts (TV, Wi-Fi, etc.)
    if (!empty($data->conforts)) {
        $qb->andWhere('c.name IN (:conforts)')
           ->setParameter('conforts', $data->conforts, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
    }*/

    return $qb->getQuery();
    }
}
