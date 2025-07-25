<?php

namespace App\Core;

class App 
{
    private static array $dependencies = [];
    private static string $servicesPath = __DIR__ . '/../config/services.yml';

    public static function init(): void
    {

        if (file_exists(self::$servicesPath)) {
            $yamlContent = file_get_contents(self::$servicesPath);
            
            
            self::$dependencies = self::parseYaml($yamlContent);
            
            
        } else {
            throw new \Exception("Le fichier services.yml est introuvable dans : " . self::$servicesPath);
        }
    }

    private static function parseYaml(string $yamlContent): array
    {
        $lines = explode("\n", $yamlContent);
        $result = [];
        $currentCategory = null;

        foreach ($lines as $lineNumber => $line) {
            $originalLine = $line;
            $line = trim($line);
            
            
            
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            if (strpos($line, ':') !== false && strpos($originalLine, '  ') !== 0) {
                $currentCategory = trim(str_replace(':', '', $line));
                $result[$currentCategory] = [];
            }
            elseif (strpos($originalLine, '  ') === 0 && strpos($line, ':') !== false) {
                $parts = explode(':', $line, 2);
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                
                if ($currentCategory) {
                    $result[$currentCategory][$key] = $value;
                }
            } else {
            }
        }

        return $result;
    }

    public static function getDependency(string $key): object
    {
        if (empty(self::$dependencies)) {
            self::init();
        }

        

        foreach (self::$dependencies as $categoryKey => $dependencies) {
            if (is_array($dependencies) && isset($dependencies[$key])) {
                $className = $dependencies[$key];
                
                if (!class_exists($className)) {
                    throw new \Exception("La classe {$className} n'existe pas");
                }
                
                if (method_exists($className, 'getInstance')) {
                    return $className::getInstance();
                }
                
                return new $className();
            }
        }

        throw new \Exception("La dépendance '{$key}' est introuvable");
    }

    public static function getDependenciesByCategory(string $category): array
    {
        if (empty(self::$dependencies)) {
            self::init();
        }

        if (!isset(self::$dependencies[$category])) {
            throw new \Exception("La catégorie '{$category}' n'existe pas");
        }

        return self::$dependencies[$category];
    }

    public static function reload(): void
    {
        self::$dependencies = [];
        self::init();
    }
}