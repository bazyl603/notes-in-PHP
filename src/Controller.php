<?php

declare(strict_types=1);

namespace App;

require_once("src/Exeption/ConfigurationException.php");
use App\Exception\ConfigurationException;

require_once("src/Database.php");
require_once("src/View.php");

class Controller {
  private const DEFAULT_ACTION = 'list';

  private static array $configuration = [];

  private Database $database;
  private array $request;
  private View $view;

  public static function initConfiguration(array $configuration): void {
    self::$configuration = $configuration;
  }

  public function __construct(array $request) {

    if (empty(self::$configuration['db'])){
      throw new ConfigurationException('Configuration Error!');
    }
    $this->database = new Database(self::$configuration['db']);

    $this->request = $request;
    $this->view = new View();
  }

  public function run(): void {
    $viewParams = [];

    switch ($this->action()) {
      case 'create':
        $page = 'createNote';
        $created = false;

        $data = $this->getRequestPost();
        if (!empty($data)) {
          $created = true;

          $this->database->createNote([
            'title' => $data['title'],
            'description' => $data['description']
          ]);

          header("Location: /?before=created");
        }

        $viewParams['created'] = $created;
        break;
      case 'show':
        $viewParams = [
          'title' => 'Moja notatka',
          'description' => 'Opis'
        ];
        break;
      default:
        $page = 'listNotes';

        $data = $this->getRequestGet();

        $viewParams['before'] = $data['before'] ?? null;
        break;
    }

    $this->view->render($page, $viewParams);
  }

  private function action(): string {
    $data = $this->getRequestGet();
    return $data['action'] ?? self::DEFAULT_ACTION;
  }

  private function getRequestGet(): array {
    return $this->request['get'] ?? [];
  }

  private function getRequestPost(): array {
    return $this->request['post'] ?? [];
  }
}