<?php

declare(strict_types=1);

namespace App;

require_once("src/Exeption/ConfigurationException.php");

use App\Request;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

require_once("src/Utils/Request.php");
require_once("src/Database.php");
require_once("src/View.php");

class Controller {
  private const DEFAULT_ACTION = 'list';

  private static array $configuration = [];

  private Database $database;
  private Request $request;
  private View $view;

  public static function initConfiguration(array $configuration): void {
    self::$configuration = $configuration;
  }

  public function __construct(Request $request) {

    if (empty(self::$configuration['db'])){
      throw new ConfigurationException('Configuration Error!');
    }
    $this->database = new Database(self::$configuration['db']);

    $this->request = $request;
    $this->view = new View();
  }

  public function run(): void {
    switch ($this->action()) {
//create      
      case 'create':
        $page = 'createNote';
        $created = false;

        if ($this->request->hasPost()) {
          $created = true;

          $this->database->createNote([
            'title' => $this->request->postParam('title'),
            'description' => $this->request->postParam('description')
          ]);

          header("Location: /?before=created");
          exit;
        }
//show
        $viewParams['created'] = $created;
        break;
      case 'show':
        $page = 'show';

        $noteId = (int) $this->request->getParam('id');
        
        if (!$noteId){
          header('Location: /?error=missingNote');
          exit;
        }

        try{
          $note = $this->database->getOneNote($noteId);
        } catch (NotFoundException $e){
          header('Location: /?error=noteNotFound');
          exit;
        }

        $viewParams = [
          'note' => $note
        ];
        break;
//list
      default:
        $page = 'listNotes';

        $viewParams = [
          'notes' => $this->database->getNote(),
          'before' => $this->request->getParam('before'),
          'error' => $data['error'] ?? null
        ];
        break;
    }

    $this->view->render($page, $viewParams ?? []);
  }

  private function action(): string {
    $action = $this->request->getParam('action', self::DEFAULT_ACTION);
    return $action;
  }
}