<?php
declare(strict_types=1);

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    // API do Sistema Pedagógico de Agendamento
    $routes->scope('/api', function (RouteBuilder $builder): void {
        $builder->setExtensions(['json']);

        $builder->resources('Users');
        $builder->resources('Cursos');
        $builder->resources('Turmas');
        $builder->resources('Alunos');
        $builder->resources('Coordenadores');
        $builder->resources('Disponibilidades');
        $builder->resources('Agendamentos');
        $builder->resources('HistoricoAgendamentos');
    });

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/pages/*', 'Pages::display');
        $builder->fallbacks();
    });
};
