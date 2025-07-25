<?php 
namespace App\Repository;

use App\Repository\ICitoyenRepository;
use \PDOException;

use App\Core\Abstract\AbstractRepository;

class CitoyenRepository extends AbstractRepository implements ICitoyenRepository{

    private string $table = 'citoyen';
    
    public function __construct(){
        parent::__construct();
    }
   public function selectAll():array{
     try{
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
     
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
     }catch (\Exception $e) {
        throw new PDOException($e->getMessage());
     }
    }
     public function insert($citoyen){        
     }

     public function selectByCni(string $cni){}

     public function selectById($id){}



    

      

   

    

}