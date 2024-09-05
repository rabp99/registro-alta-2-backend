<?php

/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/api', function (RouteBuilder $builder) {
    $builder->setExtensions(['json']);
    $builder->resources('areas');
    $builder->resources('entradas');
    $builder->resources('salidas');
    $builder->resources('users', [
        'map' => [
            'login' => [
                'action' => 'login',
                'method' => 'POST'
            ],
            'changePassword' => [
                'action' => 'changePassword',
                'method' => 'POST'
            ],
            'get_by_username/:username' => [
                'action' => 'getByUsername',
                'method' => 'GET'
            ],
            'change_password_admin' => [
                'action' => 'changePasswordAdmin',
                'method' => 'POST'
            ],
            'add_user_farmacia' => [
                'action' => 'addUserFarmacia',
                'method' => 'POST'
            ]
        ]
    ]);
    $builder->resources('trabajadores');
    $builder->resources('registros');
    $builder->resources('programaciones', [
        'map' => [
            'load' => [
                'action' => 'load',
                'method' => 'POST'
            ],
            'load_from_json' => [
                'action' => 'loadFromJson',
                'method' => 'POST'
            ],
            'find_availables/:dni_medico' => [
                'action' => 'findAvailables',
                'method' => 'GET'
            ],
            'find_to_trabajador/:dni_medico' => [
                'action' => 'findToTrabajador',
                'method' => 'GET'
            ],
            'find_solicitudes/:dni_medico' => [
                'action' => 'findSolicitudes',
                'method' => 'GET'
            ],
            'find_entregados/:dni_medico' => [
                'action' => 'findEntregados',
                'method' => 'GET'
            ],
            'find_entregados_only_entrada/:dni_medico' => [
                'action' => 'findEntregadosOnlyEntrada',
                'method' => 'GET'
            ],
            'solicitar' => [
                'action' => 'solicitar',
                'method' => 'POST'
            ],
            'register_entrada' => [
                'action' => 'registerEntrada',
                'method' => 'POST'
            ],
            'register_salida' => [
                'action' => 'registerSalida',
                'method' => 'POST'
            ],
            'register_break_start' => [
                'action' => 'registerBreakStart',
                'method' => 'POST'
            ],
            'register_break_final' => [
                'action' => 'registerBreakFinal',
                'method' => 'POST'
            ],
            'report' => [
                'action' => 'report',
                'method' => 'GET'
            ],
            'exportExcel' => [
                'action' => 'exportExcel',
                'method' => 'POST'
            ]
        ]
    ]);
    $builder->resources('solicitudes', [
        'map' => [
            'find_solicitudes/:dni_medico' => [
                'action' => 'findSolicitudes',
                'method' => 'GET'
            ],
            'entregar' => [
                'action' => 'entregar',
                'method' => 'POST'
            ],
            'save_entrega' => [
                'action' => 'saveEntrega',
                'method' => 'POST'
            ],
            'find_last_entregas/:dni_medico/:numeros' => [
                'action' => 'findLastEntregas',
                'method' => 'GET'
            ],
            'report' => [
                'action' => 'report',
                'method' => 'GET'
            ],
            'exportExcel' => [
                'action' => 'exportExcel',
                'method' => 'POST'
            ],
            'reportAnexo3' => [
                'action' => 'reportAnexo3',
                'method' => 'POST'
            ],
            'reportAnexo4' => [
                'action' => 'reportAnexo4',
                'method' => 'POST'
            ],
            'reportCuadroResumen' => [
                'action' => 'reportCuadroResumen',
                'method' => 'POST'
            ],
            'reportCuadroResumenCsv' => [
                'action' => 'reportCuadroResumenCsv',
                'method' => 'POST'
            ],
            'reportCuadroResumenDiario' => [
                'action' => 'reportCuadroResumenDiario',
                'method' => 'POST'
            ],
            'reportCuadroResumenDiarioCsv' => [
                'action' => 'reportCuadroResumenDiarioCsv',
                'method' => 'POST'
            ],
            'reportReporteSemanal' => [
                'action' => 'reportReporteSemanal',
                'method' => 'POST'
            ],
            'reportReporteSemanalCsv' => [
                'action' => 'reportReporteSemanalCsv',
                'method' => 'POST'
            ],
            'exportCsv' => [
                'action' => 'exportCsv',
                'method' => 'POST'
            ],
            'remove' => [
                'action' => 'remove',
                'method' => 'POST'
            ],
            'remove_bd' => [
                'action' => 'removeBd',
                'method' => 'POST'
            ]
        ]
    ]);
    $builder->resources('tipos', [
        'map' => [
            'get_enabled' => [
                'action' => 'getEnabled',
                'method' => 'GET'
            ]
        ]
    ]);
    $builder->resources('reutilizables', [
        'map' => [
            'prueba' => [
                'action' => 'prueba',
                'method' => 'GET'
            ],
            'report' => [
                'action' => 'report',
                'method' => 'GET'
            ],
            'exportExcel' => [
                'action' => 'exportExcel',
                'method' => 'POST'
            ],
            'reportHistorial' => [
                'action' => 'reportHistorial',
                'method' => 'POST'
            ],
            'liberar' => [
                'action' => 'liberar',
                'method' => 'POST'
            ],
            'lavanderia_regularizar' => [
                'action' => 'lavanderiaRegularizar',
                'method' => 'POST'
            ],
            'find_en_vestidores' => [
                'action' => 'findEnVestidores',
                'method' => 'GET'
            ],
            'registrar_en_lavanderia' => [
                'action' => 'registrarEnLavanderia',
                'method' => 'POST'
            ],
            'find_en_lavanderia' => [
                'action' => 'findEnLavanderia',
                'method' => 'GET'
            ],
            'registrar_devolucion' => [
                'action' => 'registrarDevolucion',
                'method' => 'POST'
            ]
        ]
    ]);
    $builder->resources('ReutilizablesSolicitudesDetalles', [
        'map' => [
            'find_entregados/:dni_medico' => [
                'action' => 'findEntregados',
                'method' => 'GET'
            ],
            'find_entregados_salida/:dni_medico' => [
                'action' => 'findEntregadosSalida',
                'method' => 'GET'
            ],
            'find_en_vestidores' => [
                'action' => 'findEnVestidores',
                'method' => 'GET'
            ],
            'find_en_lavanderia' => [
                'action' => 'findEnLavanderia',
                'method' => 'GET'
            ],
            'devolver' => [
                'action' => 'devolver',
                'method' => 'POST'
            ],
            'devolver_en_salida' => [
                'action' => 'devolverEnSalida',
                'method' => 'POST'
            ],
            'registrar_en_vestidores' => [
                'action' => 'registrarEnVestidores',
                'method' => 'POST'
            ],
            'registrar_en_lavanderia' => [
                'action' => 'registrarEnLavanderia',
                'method' => 'POST'
            ],
            'registrar_devolucion' => [
                'action' => 'registrarDevolucion',
                'method' => 'POST'
            ],
            'find_entregados_vestidores/:dni_medico' => [
                'action' => 'findEntregadosVestidores',
                'method' => 'GET'
            ]
        ]
    ]);
    $builder->resources('Grupos', [
        'map' => [
            'get_cuestionario' => [
                'action' => 'getCuestionario',
                'method' => 'GET'
            ]
        ]
    ]);
    $builder->resources('Supervisores', [
        'map' => [
            'find_by_dni' => [
                'action' => 'findByDni',
                'method' => 'GET'
            ],
            'get_enabled' => [
                'action' => 'getEnabled',
                'method' => 'GET'
            ]
        ]
    ]);
    $builder->resources('Colaboradores', [
        'map' => [
            'find_by_dni/:dni' => [
                'action' => 'findByDni',
                'method' => 'GET'
            ],
            'get_colaboradores' => [
                'action' => 'getColaboradores',
                'method' => 'GET'
            ],
            'check-colaborador-programado-hoy/:dni_medico' => [
                'action' => 'checkColaboradorProgramadoHoy',
                'method' => 'GET'
            ]
        ]
    ]);
    $builder->resources('entregas', [
        'map' => [
            'find_entregas/:dni' => [
                'action' => 'findEntregas',
                'method' => 'GET'
            ]
        ]
    ]);
    $builder->resources('consumibles', [
        'map' => [
            'get_enabled' => [
                'action' => 'getEnabled',
                'method' => 'GET'
            ],
            'report' => [
                'action' => 'report',
                'method' => 'POST'
            ],
            'save_stock' => [
                'action' => 'saveStock',
                'method' => 'POST'
            ]
        ]
    ]);
    $builder->resources('GruposOcupacionales', [
        'map' => [
            'get_allow_show' => [
                'action' => 'getAllowShow',
                'method' => 'GET'
            ]
        ]
    ]);
    $builder->resources('entregas');



    $builder->resources('workers', [
        'map' => [
            'find-by-document/:document_type/:document_number' => [
                'action' => 'findByDocument',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('worker-occupational-groups', [
        'map' => [
            'get-list' => [
                'action' => 'getList',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('worker-conditions', [
        'map' => [
            'get-list' => [
                'action' => 'getList',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('worker-medical-specialities', [
        'map' => [
            'get-list' => [
                'action' => 'getList',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('workplaces', [
        'map' => [
            'get-list-by-worker-type/:worker_type' => [
                'action' => 'getListByWorkerType',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('work-areas', [
        'map' => [
            'get-list-by-workplace-and-worker-type/:workplace_id/:worker_type' => [
                'action' => 'getListByWorkplaceAndWorkerType',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('work-area-details', [
        'map' => [
            'get-by-work-area/:worker_area_id' => [
                'action' => 'getByWorkArea',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('kits-work-area-details', [
        'map' => [
            'get-kits-by-work-area-detail/:work_area_detail_id' => [
                'action' => 'getKitsByWorkAreaDetail',
                'method' => 'GET'
            ]
        ]
    ]);

    $builder->resources('product-requests', [
        'map' => [
            'get-active-by-worker/:document_type/:document_number' => [
                'action' => 'getActiveByWorker',
                'method' => 'GET'
            ],
            'attend' => [
                'action' => 'attend',
                'method' => 'POST'
            ]
        ]
    ]);

    $builder->resources('reports', [
        'map' => [
            'get-product-request-records-data/:worker_document_type/:worker_document_number/:start_date/:end_date' => [
                'action' => 'getProductRequestRecordsData',
                'method' => 'GET'
            ],
            'get-product-request-records-file/:worker_document_type/:worker_document_number/:start_date/:end_date' => [
                'action' => 'getProductRequestRecordsFile',
                'method' => 'GET'
            ],
        ]
    ]);

    $builder->resources('parameters', [
        'map' => [
            'get-by-keys/:keys' => [
                'action' => 'getByKeys',
                'method' => 'GET'
            ],
            'save-configuration' => [
                'action' => 'saveConfiguration',
                'method' => 'POST'
            ],
        ]
    ]);
});
