<?php

namespace App\Model;

/**
 * Ce modèle contient tous les paramètres de recherche/filtrage pour les biens.
 */
class SearchData
{
    /**  Recherche textuelle */
    public ?string $q = null;

    /**  Numéro de page pour la pagination */
    public int $page = 1;

    /**  Types de biens (plusieurs possibles) */
    public ?string $type = null;

    /**  Type d’activité (vente, location, etc.) */
    public ?string $activite = null;

    /**  Pays (plusieurs possibles) */
    public ?string $pays = null;

    /**  Villes (plusieurs possibles) */
    public ?string $ville = null;

    /**  Nombre minimal de chambres */
    public ?int $chambres = null;

    /**  Prix maximal */
    public ?float $prixMax = null;

    /**  Surface maximale */
    public ?float $surfaceMax = null;

    /**  Conforts sélectionnés (TV, Internet, etc.) */
    public array $conforts = [];
}
