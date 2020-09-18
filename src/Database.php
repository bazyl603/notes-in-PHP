<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;

class Database
{
  private PDO $con;

  public function __construct(array $config){
    try {
      $this->validateConfig($config);
      $this->createConnection($config);
    } catch (PDOException $e) {
      throw new StorageException('Connection error');
    }
  }

  public function getNote(int $id): array{
    try {
      $query = "SELECT * FROM notes WHERE id = $id";
      $result = $this->con->query($query);
      $note = $result->fetch(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
      throw new StorageException('We don\'t get note', 400, $e);
    }

    if (!$note) {
      throw new NotFoundException("note not exist");
    }

    return $note;
  }

  public function getNotes(int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array{
    try {
      $limit = $pageSize;
      $offset = ($pageNumber - 1) * $pageSize;

      if (!in_array($sortBy, ['created', 'title'])){
        $sortBy ='title';
      }

      if (!in_array($sortOrder, ['asc', 'desc'])){
        $sortOrder ='desc';
      }

      $query = "SELECT id, title, created FROM notes ORDER BY $sortBy $sortOrder LIMIT $offset, $limit";
      $result = $this->con->query($query);
      return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
      throw new StorageException('We don\'t get note', 400, $e);
    }
  }

  //number notes
  public function getCount(): int{
    try {
      $query = "SELECT count(*) AS cn FROM notes";
      $result = $this->con->query($query);
      $result = $result->fetch(PDO::FETCH_ASSOC);

      if ($result === false){
        throw new StorageException('We don\'t get number of note', 400);
      }

      return (int) $result['cn'];
    } catch (Throwable $e) {
      throw new StorageException('We don\'t get number of note', 400, $e);
    }
  }

  public function createNote(array $data): void{
    try {
      $title = $this->con->quote($data['title']);
      $description = $this->con->quote($data['description']);
      $created = $this->con->quote(date('Y-m-d H:i:s'));

      $query = "
        INSERT INTO notes(title, description, created)
        VALUES($title, $description, $created)
      ";

      $this->con->exec($query);
    } catch (Throwable $e) {
      throw new StorageException('not create note', 400, $e);
    }
  }

  public function editNote(int $id, array $data): void{
    try {
      $title = $this->con->quote($data['title']);
      $description = $this->con->quote($data['description']);

      $query = "
        UPDATE notes
        SET title = $title, description = $description
        WHERE id = $id
      ";

      $this->con->exec($query);
    } catch (Throwable $e) {
      throw new StorageException('not edit note', 400, $e);
    }
  }

  public function deleteNote(int $id): void{
    try {
      $query = "
        DELETE FROM notes WHERE id = $id LIMIT 1
      ";

      $this->con->exec($query);
    } catch (Throwable $e) {
      throw new StorageException('not delete note', 400, $e);
    }
  }

  private function createConnection(array $config): void{
    $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
    $this->con = new PDO(
      $dsn,
      $config['user'],
      $config['password'],
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
  }

  private function validateConfig(array $config): void{
    if (
      empty($config['database']) || empty($config['host']) || empty($config['user']) || empty($config['password'])){
      throw new ConfigurationException('Storage configuration error');
    }
  }
}