<?php 

namespace App\Service;

use App\Core\App;
use App\Core\Singleton;
use App\Repository\CitoyenRepository;

class CitoyenService extends Singleton{

    private CitoyenRepository $citoyenRepository;

    public function __construct(){
        $this->citoyenRepository = App::getDependency('citoyenRepo');
    }


    public function getAllCitoyens(){
        return $this->citoyenRepository->selectAll();
    }


}