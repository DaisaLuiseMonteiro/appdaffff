<?php

namespace App\Config\Translate\Fr;

enum ErreurMessage: string{
    case REQUIRED = "Ce champ est obligatoire";
    case MIN_LENGTH = "Ce champ doit contenir au moins 3 caractères";
    case MAX_LENGTH = "Ce champ doit contenir au plus 10 caractères";
    case IS_MAIL = "Ce champ doit être une adresse email valide";
    case IS_PASSWORD = "Mot de pass invalide !";

    case IS_SENEGAL_PHONE = "Numéro de téléphone invalide";
    case IS_CNI = "Numéro de CNI invalide";



}