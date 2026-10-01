<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

class UsersController extends AppController
{
    public function index()
    {
        $table = $this->fetchTable('Users');
        $result = $table->find()
            ->where(['Users.deleted IS' => null])
            ->contain(['Alunos.Turmas.Cursos', 'Coordenadores.Cursos'])
            ->orderBy(['Users.id' => 'DESC'])
            ->all()
            ->toArray();

        return $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($result));
    }

    public function view($id = null)
    {
        $table = $this->fetchTable('Users');

        try {
            $result = $table->get((int)$id, [
                'contain' => ['Alunos.Turmas.Cursos', 'Coordenadores.Cursos'],
            ]);

            if ($result->deleted !== null) {
                throw new RecordNotFoundException();
            }

            $statusCode = 200;
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Usuário não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function add()
    {
        $table = $this->fetchTable('Users');
        $usuario = $table->newEmptyEntity();
        $usuario = $table->patchEntity($usuario, $this->request->getData());

        if ($table->save($usuario)) {
            $result = $usuario;
            $statusCode = 201;
        } else {
            $result = [
                'mensagem' => 'Não foi possível cadastrar o usuário.',
                'erros' => $usuario->getErrors(),
            ];
            $statusCode = 400;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('Users');

        try {
            $usuario = $table->get((int)$id);

            if ($usuario->deleted !== null) {
                throw new RecordNotFoundException();
            }

            $usuario = $table->patchEntity($usuario, $this->request->getData());

            if ($table->save($usuario)) {
                $result = $usuario;
                $statusCode = 200;
            } else {
                $result = [
                    'mensagem' => 'Não foi possível alterar o usuário.',
                    'erros' => $usuario->getErrors(),
                ];
                $statusCode = 400;
            }
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Usuário não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function delete($id = null)
    {
        $table = $this->fetchTable('Users');

        try {
            $usuario = $table->get((int)$id);
            $usuario->deleted = date('Y-m-d H:i:s');

            if ($table->save($usuario)) {
                $result = ['mensagem' => 'Usuário desativado com sucesso.'];
                $statusCode = 200;
            } else {
                $result = ['mensagem' => 'Não foi possível desativar o usuário.'];
                $statusCode = 400;
            }
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Usuário não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }
}
