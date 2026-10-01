<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

class DisponibilidadesController extends AppController
{
    public function index()
    {
        $table = $this->fetchTable('Disponibilidades');
        $query = $table->find()->where(['Disponibilidades.deleted IS' => null]);
        $query->contain(['Coordenadores.Usuarios','Coordenadores.Cursos']);
        $result = $query->all()->toArray();

        return $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($result));
    }

    public function view($id = null)
    {
        $table = $this->fetchTable('Disponibilidades');
        try {
            $result = $table->get((int)$id, ['contain' => ['Coordenadores.Usuarios','Coordenadores.Cursos']]);
            if ($result->get('deleted') !== null) {
                throw new RecordNotFoundException();
            }
            $statusCode = 200;
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Registro não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function add()
    {
        $table = $this->fetchTable('Disponibilidades');
        $entity = $table->newEmptyEntity();
        $entity = $table->patchEntity($entity, $this->request->getData());

        if ($table->save($entity)) {
            $result = $entity;
            $statusCode = 201;
        } else {
            $result = ['mensagem' => 'Não foi possível cadastrar.', 'erros' => $entity->getErrors()];
            $statusCode = 400;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('Disponibilidades');
        try {
            $entity = $table->get((int)$id);
            if ($entity->get('deleted') !== null) {
                throw new RecordNotFoundException();
            }

            $entity = $table->patchEntity($entity, $this->request->getData());
            if ($table->save($entity)) {
                $result = $entity;
                $statusCode = 200;
            } else {
                $result = ['mensagem' => 'Não foi possível alterar.', 'erros' => $entity->getErrors()];
                $statusCode = 400;
            }
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Registro não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function delete($id = null)
    {
        $table = $this->fetchTable('Disponibilidades');
        try {
            $entity = $table->get((int)$id);
            $entity->set('deleted', date('Y-m-d H:i:s'));

            if ($table->save($entity)) {
                $result = ['mensagem' => 'Registro removido com sucesso.'];
                $statusCode = 200;
            } else {
                $result = ['mensagem' => 'Não foi possível remover o registro.'];
                $statusCode = 400;
            }
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Registro não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }
}
