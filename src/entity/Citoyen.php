<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;

class Citoyen extends AbstractEntity{
    private int $id ;
    private string $nom;
    private string $prenom;
    private string $numerocni;
    private string $photoIdentite;
    private string $lieuNaiss;
    private string $dateNaiss;

    public function __construct($id = 0, $nom = '', $prenom = '', $numerocni= '', $photoIdentite = '', $lieuNaiss = '', $dateNaiss = ''){
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numerocni = $numerocni;
        $this->photoIdentite = $photoIdentite;
        $this->lieuNaiss = $lieuNaiss;
        $this->dateNaiss = $dateNaiss;
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of numerocni
     */ 
    public function getNumerocni()
    {
        return $this->numerocni;
    }

    /**
     * Set the value of numerocni
     *
     * @return  self
     */ 
    public function setNumerocni($numerocni)
    {
        $this->numerocni = $numerocni;

        return $this;
    }

    /**
     * Get the value of photoIdentite
     */ 
    public function getPhotoIdentite()
    {
        return $this->photoIdentite;
    }

    /**
     * Set the value of photoIdentite
     *
     * @return  self
     */ 
    public function setPhotoIdentite($photoIdentite)
    {
        $this->photoIdentite = $photoIdentite;

        return $this;
    }

    /**
     * Get the value of lieuNaiss
     */ 
    public function getLieuNaiss()
    {
        return $this->lieuNaiss;
    }

    /**
     * Set the value of lieuNaiss
     *
     * @return  self
     */ 
    public function setLieuNaiss($lieuNaiss)
    {
        $this->lieuNaiss = $lieuNaiss;

        return $this;
    }

    /**
     * Get the value of dateNaiss
     */ 
    public function getDateNaiss()
    {
        return $this->dateNaiss;
    }

    /**
     * Set the value of dateNaiss
     *
     * @return  self
     */ 
    public function setDateNaiss($dateNaiss)
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public static function toObject($data):static{
        return  new static(
            $data['id'],
            $data['nom'],
            $data['prenom'],
            $data['numerocni'],
            $data['photoidentite'],
            $data['lieunaiss'],
            $data['datenaiss']
        );
    }

    public function toArray():array{
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'numerocni' => $this->numerocni,
            'photoidentite' => $this->photoIdentite,
            'lieunaiss' => $this->lieuNaiss,
            'datenaiss' => $this->dateNaiss
        ];
    }
}