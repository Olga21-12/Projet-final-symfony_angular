<?php

namespace App\Model;

/**
 * Ce modèle contient tous les paramètres de recherche/filtrage pour les biens.
 */
class SearchData
{
    /** Recherche textuelle */
    public string $q = '';

    /** Numéro de page pour la pagination */
    public int $page = 1;

    /** Type de bien (chambre, appartement, maison, etc.) */
    public ?string $type = null;

    /** Type d’activité (location_courte, location_longue, vente, etc.) */
    public ?string $activite = null;

    /** Pays */
    public ?string $pays = null;

    /** Ville */
    public ?string $ville = null;

    /** Nombre minimal de chambres */
    public int $chambres = 0;

    /** Prix minimal */
    public ?float $prixMin = null;

    /** Prix maximal */
    public ?float $prixMax = null;

    /** Surface minimale */
    public ?float $surfaceMin = null;

    /** Surface maximale */
    public ?float $surfaceMax = null;

    /** Liste des conforts sélectionnés (TV, Internet, etc.) */
    public array $conforts = [];
}