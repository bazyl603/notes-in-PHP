<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use PDOException;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;

abstract class AbstractModel {
    protected PDO $con;

  public function __construct(array $config){
    try {
      $this->validateConfig($config);
      $this->createConnection($config);
    } catch (PDOException $e) {
      throw new StorageException('Connection error');
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