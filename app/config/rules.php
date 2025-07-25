<?php 

use App\Config\Translate\Fr\ErreurMessage;

$rules = [
    'login' => [
        ['required',ErreurMessage::REQUIRED->value],
        ['minLength', 4, ErreurMessage::MIN_LENGTH->value],
        ['isMail', ErreurMessage::IS_MAIL->value]
    ],
    'password' => [
        ['required',ErreurMessage::REQUIRED->value],
        ['minLength', 4, ErreurMessage::MIN_LENGTH->value]
    ],
    'nom' => [
        ['required',ErreurMessage::REQUIRED->value],
        ['minLength', 3, ErreurMessage::MIN_LENGTH->value]
    ],
    'prenom' => [
        ['required',ErreurMessage::REQUIRED->value],
        ['minLength',3, ErreurMessage::MIN_LENGTH->value]
    ],
    'adresse' => [
        ['required',ErreurMessage::REQUIRED->value],
        ['minLength',3, ErreurMessage::MIN_LENGTH->value]
    ],
    'telephone' => [
        ['required',ErreurMessage::REQUIRED->value],
        ['isSenegalPhone', ErreurMessage::IS_SENEGAL_PHONE->value],
    ],
    'numeroCNI' => [
        ['required',ErreurMessage::REQUIRED->value],
        ['isCNI', ErreurMessage::IS_CNI->value],
    ]

];