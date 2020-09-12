<?php

declare(strict_types=1);

namespace App;

require_once("src/Exeption/StorageException.php");
require_once("src/Exeption/ConfigurationException.php");
require_once("src/Exeption/NotFoundExceprion.php");

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;

class Database{

    private PDO $con;

    public function __construct(array $config){
        
        try{
            $this->validateConfig($config);
            $this->createConfig($config);
        }catch (PDOException $e){
            throw new StorageException('Database is dead!');
        }
    }

    public function getNote(): array{
        try{
            $note = [];

            $query = "SELECT id, title, created FROM notes";
            $result = $this->con->query($query);
            $note = $result->fetchAll(PDO::FETCH_ASSOC);
            
            return $note;
        } catch (Throwable $e){
            throw new StorageException('We have problem with get notes!', 400);
        }
    }

    public function getOneNote(int $id): array{
        try{
            $note =[];

            $query = "SELECT id, title, description, created FROM notes WHERE id = $id";
            $result = $this->con->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);

        } catch (Throwable $e) {
            throw new StorageException('We have problem with get this note. Try again!', 400);
        }

        if (!$note){
            throw new NotFoundException('Note not exist');
        }else {
            return $note;
        }    
    }

    public function createNote(array $data): void{
        try{
            $title = $this->con->quote($data['title']);
            $description = $this->con->quote($data['description']);
            $created = $this->con->quote(date('Y-m-d H:i:s'));

            $query = "INSERT INTO notes(title, description, created) VALUES($title, $description, $created)";
            $this->con->exec($query);
        } catch (Throwable $e){
            throw new StorageException('No create note!', 400);
        }
    }

    private function validateConfig(array $config): void{
        if (empty($config['database']) || empty($config['host']) || empty($config['user']) || empty($config['password'])){
            throw new ConfigurationException('DB configuration is wrong!');
        }
    }

    private function createConfig(array $config): void{
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->con = new PDO($dsn, $config['user'], $config['password']);
    }
}