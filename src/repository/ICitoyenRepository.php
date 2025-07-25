<?php

namespace App\Repository;
interface ICitoyenRepository{
    public function selectByCni(string $cni);
    public function insert($citoyen);
    public function selectById($id);
}