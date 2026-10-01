<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

class HistoricoAgendamentosController extends AppController
{
    public function index()
    {
        $table = $this->fetchTable('HistoricoAgendamentos');
        $result = $table->find()
            ->contain(['Agendamentos'])
            ->orderBy(['HistoricoAgendamentos.id' => 'DESC'])
            ->all()
            ->toArray();

        return $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($result));
    }

    public function view($id = null)
    {
        $table = $this->fetchTable('HistoricoAgendamentos');
        try {
            $result = $table->get((int)$id, ['contain' => ['Agendamentos']]);
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
}
