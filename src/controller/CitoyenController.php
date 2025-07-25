<?php

namespace App\Controller;

use App\Core\App;
use App\Service\CitoyenService;
use App\Core\Abstract\AbstractController;

class CitoyenController  extends AbstractController
{
    private CitoyenService $citoyenService;

    public function __construct()
    {
        $this->citoyenService = App::getDependency('citoyenServ');
    }

    /**
     * Récupère tous les citoyens
     * GET /api/citoyens
     */
    public function index()
    {
        try {
            $citoyens = $this->citoyenService->getAllCitoyens();
            
            $response = [
                'success' => true,
                'message' => 'Citoyens récupérés avec succès',
                'data' => $citoyens,
                'count' => count($citoyens)
            ];
            
            $this->renderJson($response, 200);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Erreur lors de la récupération des citoyens',
                'error' => $e->getMessage()
            ];
            
            $this->renderJson($response, httpCode: 500);
        }
    }

    /**
     * Récupère un citoyen par son ID
     * GET /api/citoyens/{id}
     */
    // public function show($params = [])
    // {
    //     try {
    //         $id = $params['id'] ?? null;
            
    //         if (!$id) {
    //             $response = [
    //                 'success' => false,
    //                 'message' => 'ID du citoyen requis'
    //             ];
    //             $this->renderJson($response, 400);
    //             return;
    //         }

    //         $citoyen = $this->citoyenService->getCitoyenById($id);
            
    //         if (!$citoyen) {
    //             $response = [
    //                 'success' => false,
    //                 'message' => 'Citoyen non trouvé'
    //             ];
    //             $this->renderJson($response, 404);
    //             return;
    //         }

    //         $response = [
    //             'success' => true,
    //             'message' => 'Citoyen récupéré avec succès',
    //             'data' => $citoyen
    //         ];
            
    //         $this->renderJson($response, 200);
            
    //     } catch (\Exception $e) {
    //         $response = [
    //             'success' => false,
    //             'message' => 'Erreur lors de la récupération du citoyen',
    //             'error' => $e->getMessage()
    //         ];
            
    //         $this->renderJson($response, 500);
    //     }
    // }

    // /**
    //  * Créer un nouveau citoyen
    //  * POST /api/citoyens
    //  */
    // public function store()
    // {
    //     try {
    //         $input = json_decode(file_get_contents('php://input'), true);
            
    //         if (!$input) {
    //             $response = [
    //                 'success' => false,
    //                 'message' => 'Données JSON invalides'
    //             ];
    //             $this->renderJson($response, 400);
    //             return;
    //         }

    //         // Validation des champs requis
    //         $requiredFields = ['nom', 'prenom', 'cni'];
    //         $errors = [];
            
    //         foreach ($requiredFields as $field) {
    //             if (!isset($input[$field]) || empty($input[$field])) {
    //                 $errors[] = "Le champ '$field' est requis";
    //             }
    //         }
            
    //         if (!empty($errors)) {
    //             $response = [
    //                 'success' => false,
    //                 'message' => 'Données de validation échouées',
    //                 'errors' => $errors
    //             ];
    //             $this->renderJson($response, 422);
    //             return;
    //         }

    //         $citoyen = $this->citoyenService->createCitoyen($input);
            
    //         $response = [
    //             'success' => true,
    //             'message' => 'Citoyen créé avec succès',
    //             'data' => $citoyen
    //         ];
            
    //         $this->renderJson($response, 201);
            
    //     } catch (\Exception $e) {
    //         $response = [
    //             'success' => false,
    //             'message' => 'Erreur lors de la création du citoyen',
    //             'error' => $e->getMessage()
    //         ];
            
    //         $this->renderJson($response, 500);
    //     }
    // }

    // /**
    //  * Rechercher des citoyens
    //  * GET /api/citoyens/search?q=terme
    //  */
    // public function search()
    // {
    //     try {
    //         $searchTerm = $_GET['q'] ?? '';
            
    //         if (empty($searchTerm)) {
    //             $response = [
    //                 'success' => false,
    //                 'message' => 'Terme de recherche requis (paramètre q)'
    //             ];
    //             $this->renderJson($response, 400);
    //             return;
    //         }

    //         $citoyens = $this->citoyenService->searchCitoyens($searchTerm);
            
    //         $response = [
    //             'success' => true,
    //             'message' => 'Recherche effectuée avec succès',
    //             'data' => $citoyens,
    //             'count' => count($citoyens),
    //             'search_term' => $searchTerm
    //         ];
            
    //         $this->renderJson($response, 200);
            
    //     } catch (\Exception $e) {
    //         $response = [
    //             'success' => false,
    //             'message' => 'Erreur lors de la recherche',
    //             'error' => $e->getMessage()
    //         ];
            
    //         $this->renderJson($response, 500);
    //     }
    // }

}