<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class Seeder
{
    private static ?PDO $pdo = null;
    
    private static function connect()
    {
        if (self::$pdo === null) {
            try {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
                $dotenv->load();
                
                self::$pdo = new PDO(
                    $_ENV['DSN'],  // Utiliser DSN en majuscules comme dans votre .env
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD']
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connexion à la base de données réussie.\n";
                
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage() . "\n";
                throw $e;
            }
        }
    }
    
    public static function run()
    {
        try {
            // Configuration Cloudinary
            $cloud = require __DIR__ . '/../app/config/cloudinary.php';
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => $cloud['cloud_name'],
                    'api_key' => $cloud['api_key'],
                    'api_secret' => $cloud['api_secret'],
                ],
                'url' => ['secure' => true]
            ]);
            $cloudinary = new Cloudinary(Configuration::instance());
            
            // Données des citoyens
            $citoyens = [
                [
                    'nom' => 'Diop',
                    'prenom' => 'Sidi',
                    'numerocni' => '1234567890100',
                    'photoIdentite' => 'photo_identite1.png',
                    'lieuNaiss' => 'Dakar',
                    'dateNaiss' => '1980-01-01',
                ],
                [
                    'nom' => 'Fall',
                    'prenom' => 'Ami',
                    'numerocni' => '1237567890101',
                    'photoIdentite' => 'photo_identite2.png',
                    'lieuNaiss' => 'Saint-Louis',
                    'dateNaiss' => '1986-05-15',
                ],
                [
                    'nom' => 'Ndiaye',
                    'prenom' => 'fatou',
                    'numerocni' => '1234567890104',
                    'photoIdentite' => 'photo_identite3.png',
                    'lieuNaiss' => 'fatick',
                    'dateNaiss' => '1994-12-20',
                ]
            ];
            
            self::connect();
            
            foreach ($citoyens as $citoyen) {
                try {
                    $imagePathIdentite = __DIR__ . '/images/' . $citoyen['photoIdentite'];
                    
                    // Vérifier si le fichier image existe
                    if (!file_exists($imagePathIdentite)) {
                        echo "Image non trouvée : " . $imagePathIdentite . "\n";
                        // Utiliser une URL par défaut ou continuer sans upload
                        $urlIdentite = 'https://via.placeholder.com/300x400?text=Photo+CNI';
                    } else {
                        // Upload vers Cloudinary
                        $uploadIdentite = $cloudinary->uploadApi()->upload($imagePathIdentite, [
                            'folder' => 'cni/recto'
                        ]);
                        $urlIdentite = $uploadIdentite['secure_url'];
                        echo "Image uploadée : " . $urlIdentite . "\n";
                    }
                    
                    // Insérer en base
                    $stmt = self::$pdo->prepare("
                        INSERT INTO citoyen (nom, prenom, numerocni, photoidentite, lieunaiss, datenaiss)
                        VALUES (:nom, :prenom, :numerocni, :photoidentite, :lieunaiss, :datenaiss)
                    ");
                    
                    $stmt->execute([
                        'nom' => $citoyen['nom'],
                        'prenom' => $citoyen['prenom'],
                        'numerocni' => $citoyen['numerocni'],
                        'photoidentite' => $urlIdentite,
                        'lieunaiss' => $citoyen['lieuNaiss'],
                        'datenaiss' => $citoyen['dateNaiss'],
                    ]);
                    
                    echo "Citoyen ajouté : " . $citoyen['prenom'] . " " . $citoyen['nom'] . "\n";
                    
                } catch (Exception $e) {
                    echo "Erreur lors de l'insertion de " . $citoyen['prenom'] . " " . $citoyen['nom'] . " : " . $e->getMessage() . "\n";
                }
            }
            
            echo "Seeding terminé avec succès.\n";
            
        } catch (Exception $e) {
            echo "Erreur durant le seeding : " . $e->getMessage() . "\n";
            exit(1);
        }
    }
}

// Vérifier les variables d'environnement
$required_vars = ['DSN', 'DB_USER', 'DB_PASSWORD'];
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

foreach ($required_vars as $var) {
    if (!isset($_ENV[$var])) {
        echo "Variable d'environnement manquante : $var\n";
        exit(1);
    }
}

// Créer le dossier images s'il n'existe pas
$imagesDir = __DIR__ . '/images';
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
    echo "Dossier images créé : $imagesDir\n";
}

Seeder::run();