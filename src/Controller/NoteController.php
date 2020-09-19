<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use ErrorException;

class NoteController extends AbstractController{

  public function createAction(): void{
    if ($this->request->hasPost()) {
      $noteData = [
        'title' => $this->request->postParam('title'),
        'description' => $this->request->postParam('description')
      ];
      $this->database->createNote($noteData);
      $this->redirect('/', ['before' => 'created']);
    }

    $this->view->render('createNote');
  }

  public function showAction(): void{
    $noteId = (int) $this->request->getParam('id');

    $note = $this->getNote();

    $this->view->render('show',['note' => $note]);
  }

  public function listAction(): void{
    $phrase = $this->request->getParam('phrase');

    $pageNumber = (int) $this->request->getParam('page', 1);
    $pageSize = (int) $this->request->getParam('pagesize', 10);

    $sortBy = $this->request->getParam('sortby', 'title');
    $sortOrder = $this->request->getParam('sortorder', 'desc');

    if (!in_array($pageSize, [1, 5, 10, 25])){
      $pageSize = 10;
    }

    if ($phrase){
      $noteList = $this->database->searchNotes($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
      $notes = $this->database->getSearchCount($phrase);
    }else {
      $noteList = $this->database->getNotes($pageNumber, $pageSize, $sortBy, $sortOrder);
      $notes = $this->database->getCount();
    }  

    $this->view->render(
      'listNotes',
      [
        'page' => [
          'number' => $pageNumber,
          'size' => $pageSize,
          'pages' => (int) ceil($notes / $pageSize)
        ],
        'phrase' => $phrase,
        'sort' => [
          'by' => $sortBy,
          'order' => $sortOrder 
        ],
        'notes' => $noteList,
        'before' => $this->request->getParam('before'),
        'error' => $this->request->getParam('error')
      ]
    );
  }

  public function editAction(): void{
    if ($this->request->isPost()) {
      $noteId = (int) $this->request->postParam('id');
      $noteData = [
        'title' => $this->request->postParam('title'),
        'description' => $this->request->postParam('description')
      ];
      $this->database->editNote($noteId, $noteData);
      $this->redirect('/', ['before' => 'edited']);
    }

    $note = $this->getNote();

    $this->view->render('editNote', ['note' => $note]);
  }

  public function deleteAction(): void{
    if ($this->request->isPost()){
      $id = (int) $this->request->postParam('id');
      $this->database->deleteNote($id);
      $this->redirect('/', ['before' => 'deleted']);
    }

    $note = $this->getNote();

    $this->view->render('delete', ['note' => $note]);
  }


  final private function getNote(): array{
    $noteId = (int) $this->request->getParam('id');
    if (!$noteId) {
      $this->redirect('/', ['error' => 'missingNoteId']);
    }

    $note = $this->database->getNote($noteId);

    return $note;
  }
}