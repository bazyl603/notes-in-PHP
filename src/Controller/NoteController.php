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
    $this->view->render(
      'listNotes',
      [
        'notes' => $this->database->getNotes(),
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

    try {
      $note = $this->database->getNote($noteId);
    } catch (NotFoundException $e) {
      $this->redirect('/', ['error' => 'noteNotFound']);
    }

    return $note;
  }
}