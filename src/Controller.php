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

  public function createAction(){
        if ($this->request->hasPost()) {
          $this->database->createNote([
            'title' => $this->request->postParam('title'),
            'description' => $this->request->postParam('description')
          ]);

          header("Location: /?before=created");
          exit;
        }
    $this->view->render('createNote');
  }

  public function showAction(){
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
    $this->view->render('show', ['note' => $note]);
  }

  public function listAction(){
        $viewParams = [
          'notes' => $this->database->getNote(),
          'before' => $this->request->getParam('before'),
          'error' => $data['error'] ?? null
        ];
    $this->view->render('listNotes', $viewParams ?? []);
  }

  public function run(): void {
    $action = $this->action() . 'Action';

    if (!method_exists($this, $action)){
      $action = self::DEFAULT_ACTION . 'Action';
    }
    $this->$action();
    // switch ($this->action()) {     
    //   case 'create':
    //     $this->create();
    //     break;
    //   case 'show':
    //     $this->show();
    //     break;
    //   default:
    //     $this->list();
    //     break;
    // }
  }

  private function action(): string {
    $action = $this->request->getParam('action', self::DEFAULT_ACTION);
    return $action;
  }
}