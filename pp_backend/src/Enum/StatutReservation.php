<?php

namespace App\Enum;

enum StatutReservation: string
{
    case EN_ATTENTE = 'en_attente';
    case ACCEPTE = 'accepte';
    case REFUSE = 'refuse';
}
