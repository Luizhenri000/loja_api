<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

class AgendamentosController extends AppController
{
    private array $contain = [
        'Responsaveis',
        'Alunos.Turmas.Cursos',
        'Coordenadores.Usuarios',
        'Coordenadores.Cursos',
        'HistoricoAgendamentos',
    ];

    public function index()
    {
        $table = $this->fetchTable('Agendamentos');
        $result = $table->find()
            ->where(['Agendamentos.deleted IS' => null])
            ->contain($this->contain)
            ->orderBy(['Agendamentos.data' => 'ASC', 'Agendamentos.hora_inicio' => 'ASC'])
            ->all()
            ->toArray();

        return $this->response
            ->withType('application/json')
            ->withStatus(200)
            ->withStringBody(json_encode($result));
    }

    public function view($id = null)
    {
        $table = $this->fetchTable('Agendamentos');

        try {
            $result = $table->get((int)$id, ['contain' => $this->contain]);
            if ($result->deleted !== null) {
                throw new RecordNotFoundException();
            }
            $statusCode = 200;
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Agendamento não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function add()
    {
        $table = $this->fetchTable('Agendamentos');
        $historicoTable = $this->fetchTable('HistoricoAgendamentos');

        $agendamento = $table->newEmptyEntity();
        $agendamento = $table->patchEntity($agendamento, $this->request->getData());

        if ($table->save($agendamento)) {
            $historico = $historicoTable->newEntity([
                'agendamento_id' => $agendamento->id,
                'acao' => 'criado',
                'data_nova' => $agendamento->data,
                'hora_nova' => $agendamento->hora_inicio,
                'observacao' => 'Agendamento criado.',
                'created' => date('Y-m-d H:i:s'),
            ]);
            $historicoTable->save($historico);

            $result = $agendamento;
            $statusCode = 201;
        } else {
            $result = ['mensagem' => 'Não foi possível criar o agendamento.', 'erros' => $agendamento->getErrors()];
            $statusCode = 400;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function edit($id = null)
    {
        $table = $this->fetchTable('Agendamentos');
        $historicoTable = $this->fetchTable('HistoricoAgendamentos');

        try {
            $agendamento = $table->get((int)$id);
            if ($agendamento->deleted !== null) {
                throw new RecordNotFoundException();
            }

            $dataAnterior = $agendamento->data;
            $horaAnterior = $agendamento->hora_inicio;
            $statusAnterior = $agendamento->status;

            $agendamento = $table->patchEntity($agendamento, $this->request->getData());

            if ($table->save($agendamento)) {
                $acao = 'alterado';
                if ((string)$dataAnterior !== (string)$agendamento->data ||
                    (string)$horaAnterior !== (string)$agendamento->hora_inicio) {
                    $acao = 'reagendado';
                } elseif ($statusAnterior !== $agendamento->status) {
                    $acao = 'status_alterado';
                }

                $historico = $historicoTable->newEntity([
                    'agendamento_id' => $agendamento->id,
                    'acao' => $acao,
                    'data_anterior' => $dataAnterior,
                    'hora_anterior' => $horaAnterior,
                    'data_nova' => $agendamento->data,
                    'hora_nova' => $agendamento->hora_inicio,
                    'observacao' => 'Agendamento atualizado.',
                    'created' => date('Y-m-d H:i:s'),
                ]);
                $historicoTable->save($historico);

                $result = $agendamento;
                $statusCode = 200;
            } else {
                $result = ['mensagem' => 'Não foi possível alterar o agendamento.', 'erros' => $agendamento->getErrors()];
                $statusCode = 400;
            }
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Agendamento não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }

    public function delete($id = null)
    {
        $table = $this->fetchTable('Agendamentos');
        $historicoTable = $this->fetchTable('HistoricoAgendamentos');

        try {
            $agendamento = $table->get((int)$id);
            if ($agendamento->deleted !== null) {
                throw new RecordNotFoundException();
            }

            $agendamento->status = 'cancelada';

            if ($table->save($agendamento)) {
                $historico = $historicoTable->newEntity([
                    'agendamento_id' => $agendamento->id,
                    'acao' => 'cancelado',
                    'data_anterior' => $agendamento->data,
                    'hora_anterior' => $agendamento->hora_inicio,
                    'observacao' => 'Agendamento cancelado.',
                    'created' => date('Y-m-d H:i:s'),
                ]);
                $historicoTable->save($historico);

                $result = ['mensagem' => 'Agendamento cancelado com sucesso.', 'agendamento' => $agendamento];
                $statusCode = 200;
            } else {
                $result = ['mensagem' => 'Não foi possível cancelar o agendamento.'];
                $statusCode = 400;
            }
        } catch (RecordNotFoundException $e) {
            $result = ['mensagem' => 'Agendamento não encontrado.'];
            $statusCode = 404;
        }

        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($result));
    }
}
