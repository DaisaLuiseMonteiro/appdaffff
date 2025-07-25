<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Migration
{
    private static ?\PDO $pdo = null;
    
    private static function connect()
    {
        if (self::$pdo === null) {
            try {
                // Utilisation du DSN PostgreSQL de Render
                $dsn = $_ENV['DSN'];
                
                self::$pdo = new \PDO(
                    $dsn,
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
                
                echo "Connexion à la base de données réussie.\n";
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage() . "\n";
                throw $e;
            }
        }
    }
    
    private static function getQueries(): array 
    {
        $driver = self::$pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        
        if ($driver === 'mysql') {
            return [
                "CREATE TABLE IF NOT EXISTS citoyen (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    nom VARCHAR(100) NOT NULL,
                    prenom VARCHAR(100) NOT NULL,
                    numerocni VARCHAR(20) UNIQUE,
                    photoidentite TEXT,
                    lieuNaiss VARCHAR(100),
                    dateNaiss DATE
                )",
                "CREATE TABLE IF NOT EXISTS journalisation (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    heure TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    localisation TEXT,
                    ipadress VARCHAR(50),
                    status BOOLEAN DEFAULT false,
                    citoyenId INT UNSIGNED NOT NULL,
                    FOREIGN KEY (citoyenId) REFERENCES citoyen(id) ON DELETE CASCADE
                )"
            ];
        } else {
            // PostgreSQL
            return [
                "CREATE TABLE IF NOT EXISTS citoyen (
                    id SERIAL PRIMARY KEY,
                    nom VARCHAR(100) NOT NULL,
                    prenom VARCHAR(100) NOT NULL,
                    numerocni VARCHAR(20) UNIQUE,
                    photoidentite TEXT,
                    lieuNaiss VARCHAR(100),
                    dateNaiss DATE
                )",
                "CREATE TABLE IF NOT EXISTS journalisation (
                    id SERIAL PRIMARY KEY,
                    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    heure TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    localisation TEXT,
                    ipadress VARCHAR(50),
                    status BOOLEAN DEFAULT false,
                    citoyenId INTEGER REFERENCES citoyen(id) ON DELETE CASCADE
                )"
            ];
        }
    }
    
    public static function up()
    {
        try {
            self::connect();
            $queries = self::getQueries();
            
            foreach ($queries as $sql) {
                try {
                    self::$pdo->exec($sql);
                    echo "Table créée avec succès.\n";
                } catch (PDOException $e) {
                    echo "Erreur lors de l'exécution de la requête: " . $e->getMessage() . "\n";
                    throw $e;
                }
            }
            
            echo "Migration terminée avec succès.\n";
            
        } catch (Exception $e) {
            echo "Erreur durant la migration : " . $e->getMessage() . "\n";
            exit(1);
        }
    }
}

// existance des variables d'environnement  
$required_vars = ['DSN', 'DB_USER', 'DB_PASSWORD'];
foreach ($required_vars as $var) {
    if (!isset($_ENV[$var])) {
        echo "Variable d'environnement manquante : $var\n";
        exit(1);
    }
}

Migration::up();