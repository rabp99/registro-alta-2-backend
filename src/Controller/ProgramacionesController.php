<?php

declare(strict_types=1);

namespace App\Controller;

use League\Csv\Reader;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Cake\Http\CallbackStream;
use Cake\Log\Log;

/**
 * Programaciones Controller
 *
 * @property \App\Model\Table\ProgramacionesTable $Programaciones
 * @method \App\Model\Entity\Programacione[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProgramacionesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['findAvailables', 'findEntregados', 'findEntregadosOnlyEntrada', 'solicitar', 'registerEntrada', 'registerSalida', 'registerBreakStart', 'registerBreakFinal', 'loadFromJson']);
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Random');
    }

    /**
     * Load method
     *
     * @return \Cake\Http\Response|null|void Renders load
     */
    public function load()
    {
        $this->request->allowMethod('post');
        /** @var \Laminas\Diactoros\UploadedFile $file **/
        $file = $this->getRequest()->getData('file');
        $pathDst = TMP . DS;
        $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

        $filename = $pathDst . 'programaciones-' . $this->Random->randomString() . '.' . $ext;

        try {
            $file->moveTo($filename);
            // load the CSV document from a stream
            $csv = Reader::createFromPath($filename, 'r');
            $csv->setDelimiter('|');
            $csv->setHeaderOffset(0);

            $countBefore = $this->Programaciones->find()->count();
            $programaciones = [];
            foreach ($csv as $record) {
                $fecha = FrozenDate::createFromFormat('d/m/Y', $record["FECHA_PROGRAMACION"]);
                $programacionExists = $this->Programaciones->find()
                    ->where([
                        'centro' => $record["CENTRO"],
                        'dni_medico' => $record["DNI_MEDICO"],
                        'fecha_programacion' => $fecha,
                        'turno' => $record["TURNO"],
                    ])->first() !== null;
                if (!$programacionExists) {
                    $programacion = $this->Programaciones->newEmptyEntity();
                    if (
                        $record['ESTADO_PROGRAMACION'] === 'APROBADA' &&
                        $record['SUBACTIVIDAD'] !== 'LICENCIA' &&
                        $record['SUBACTIVIDAD'] !== 'TELECONSULTAS' &&
                        $record['SUBACTIVIDAD'] !== 'TELEMONITOREO' &&
                        $record['SUBACTIVIDAD'] !== 'TELEORIENTACION' &&
                        $record['SUBACTIVIDAD'] !== 'VACACIONES'
                    ) {
                        $programacion->centro = $record["CENTRO"];
                        $programacion->periodo = $record["PERIODO"];
                        $programacion->area = $record["AREA"];
                        $programacion->servicio = $record["SERVICIO"];
                        $programacion->actividad = $record["ACTIVIDAD"];
                        $programacion->subactividad = $record["SUBACTIVIDAD"];
                        $programacion->consultorio = $record["CONSULTORIO"];
                        $programacion->ubicacionconsult = $record["UBICACIONCONSULT"];

                        // $programacion->dni_medico = $record['DNI_MEDICO'], 8, '0', STR_PAD_LEFT);
                        $programacion->dni_medico = $record['DNI_MEDICO'];
                        $programacion->profesional = $record["PROFESIONAL"];
                        $programacion->grupo_ocupacional = $record["GRUPO_OCUPACIONAL"];
                        $programacion->tip_programacion = $record["TIP_PROGRAMACION"];

                        $fecha = FrozenDate::createFromFormat('d/m/Y', $record["FECHA_PROGRAMACION"]);
                        $programacion->fecha_programacion = $fecha;
                        $programacion->hor_inicio = $record["HOR_INICIO"];
                        $programacion->hor_fin = $record["HOR_FIN"];
                        $programacion->estado_programacion = $record["ESTADO_PROGRAMACION"];
                        $programacion->motivo_suspension = $record["MOTIVO_SUSPENSION"];
                        $programacion->cod_planilla = $record["COD_PLANILLA"];
                        $programacion->turno = $record["TURNO"];
                        $programacion->condtrabajador = $record["CONDTRABAJADOR"];
                        $programacion->pertenece_otro_cas = $record["PERTENECE_OTRO_CAS"];
                        $programacion->flag_interno = 1;
                        $programacion->estado_id = 1;

                        $programaciones[] = $programacion;
                    }
                }
            }
            $this->Programaciones->saveManyOrFail($programaciones);
            $countAfter = $this->Programaciones->find()->count();

            $this->setResponse($this->response->withStatus(200));
            $count = $countAfter - $countBefore;
            $message = 'Las programaciones fueron cargadas correctamente, ' . $count . ' programaciones cargadas';
            Log::info("Un total de $count de Programaciones cargadas el " . date('d/m/Y H:i:s'), 'info');
        } catch (UploadedFileErrorException $ex) {
            $this->setResponse($this->response->withStatus(500));
            $message = "Las programaciones no fueron cargadas correctamente";
        } finally {
            $this->set(compact("message", "filename"));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    public function loadFromJson()
    {
        $this->request->allowMethod('post');
        $programaciones = $this->getRequest()->getData();

        try {
            $countBefore = sizeof($this->Programaciones->find()->toArray());
            foreach ($programaciones as $record) {
                $fecha = FrozenDate::createFromFormat('d/m/Y', $record["FECHA_PROGRAMACION"]);
                $programacionExists = $this->Programaciones->find()
                    ->where([
                        'centro' => $record["CENTRO"],
                        'dni_medico' => $record["DNI_MEDICO"],
                        'fecha_programacion' => $fecha,
                        'turno' => $record["TURNO"],
                    ])->first() !== null;
                if (!$programacionExists) {
                    $programacion = $this->Programaciones->newEmptyEntity();
                    if (
                        $record['ESTADO_PROGRAMACION'] === 'APROBADA' &&
                        $record['SUBACTIVIDAD'] !== 'LICENCIA' &&
                        $record['SUBACTIVIDAD'] !== 'TELECONSULTAS' &&
                        $record['SUBACTIVIDAD'] !== 'TELEMONITOREO' &&
                        $record['SUBACTIVIDAD'] !== 'TELEORIENTACION' &&
                        $record['SUBACTIVIDAD'] !== 'VACACIONES'
                    ) {
                        $programacion->centro = $record["CENTRO"];
                        $programacion->periodo = $record["PERIODO"];
                        $programacion->area = $record["AREA"];
                        $programacion->servicio = $record["SERVICIO"];
                        $programacion->actividad = $record["ACTIVIDAD"];
                        $programacion->subactividad = $record["SUBACTIVIDAD"];
                        $programacion->consultorio = $record["CONSULTORIO"];
                        $programacion->ubicacionconsult = $record["UBICACIONCONSULT"];

                        // $programacion->dni_medico = $record['DNI_MEDICO'], 8, '0', STR_PAD_LEFT);
                        $programacion->dni_medico = $record['DNI_MEDICO'];
                        $programacion->profesional = $record["PROFESIONAL"];
                        $programacion->grupo_ocupacional = $record["GRUPO_OCUPACIONAL"];
                        $programacion->tip_programacion = $record["TIP_PROGRAMACION"];

                        $fecha = FrozenDate::createFromFormat('d/m/Y', $record["FECHA_PROGRAMACION"]);
                        $programacion->fecha_programacion = $fecha;
                        $programacion->hor_inicio = $record["HOR_INICIO"];
                        $programacion->hor_fin = $record["HOR_FIN"];
                        $programacion->estado_programacion = $record["ESTADO_PROGRAMACION"];
                        $programacion->motivo_suspension = $record["MOTIVO_SUSPENSION"];
                        $programacion->cod_planilla = $record["COD_PLANILLA"];
                        $programacion->turno = $record["TURNO"];
                        $programacion->condtrabajador = $record["CONDTRABAJADOR"];
                        $programacion->pertenece_otro_cas = $record["PERTENECE_OTRO_CAS"];
                        $programacion->flag_interno = 1;
                        $programacion->estado_id = 1;

                        $programaciones[] = $programacion;
                    }
                }
            }
            $this->Programaciones->saveManyOrFail($programaciones);
            $countAfter = sizeof($this->Programaciones->find()->toArray());

            $this->setResponse($this->response->withStatus(200));
            $message = 'Las programaciones fueron cargadas correctamente, ' . ($countAfter - $countBefore) . ' programaciones cargadas';
        } catch (UploadedFileErrorException $ex) {
            $this->setResponse($this->response->withStatus(500));
            $message = "Las programaciones no fueron cargadas correctamente";
        } finally {
            $this->set(compact("message", "filename"));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    public function findAvailables()
    {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $programaciones = $this->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico,
            'Programaciones.fecha_programacion' => date('Y-m-d'),
            'Programaciones.estado_id' => 1
        ])->toArray();

        $message = '';
        if (sizeof($programaciones) === 0) {
            $message = 'No se encontraron programaciones disponibles';
            /*
            $programaciones = $this->Programaciones->find()->where([
                'Programaciones.dni_medico' => $dni_medico,
                'Programaciones.fecha_programacion' => date('Y-m-d'),
                'Programaciones.estado_id IN' => 
            ])->toArray();
            */
        } else {
            $message = 'Se encontraron programaciones';
        }

        $this->set(compact('programaciones', 'message'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function findToTrabajador()
    {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $programacion = $this->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico
        ])->first();

        $this->set(compact('programacion'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function findEntregados()
    {
        $dni_medico = $this->getRequest()->getParam('dni_medico');

        $horaMin = new FrozenTime('3 hours ago');
        $horaMax = new FrozenTime('+3 hours');

        $dateYesterday = new FrozenDate('1 days ago');

        $programaciones = $this->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico,
            'Programaciones.fecha_programacion IN' => [date('Y-m-d'), $dateYesterday->format('Y-m-d')],
            'OR' => [
                [
                    'Programaciones.estado_id IN' => [5, 11],
                ], [
                    'Programaciones.estado_id IN' => [5],
                    'Programaciones.turno IN' => ['Externo', 'Emergencia'],
                ]
            ]
        ])->toArray();

        $message = '';
        if (sizeof($programaciones) === 0) {
            $message = 'No se encontraron registros';
        } else {
            $message = 'Se encontraron registros';
        }

        $this->set(compact('programaciones', 'message', 'horaMin', 'horaMax'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function findEntregadosOnlyEntrada()
    {
        $dni_medico = $this->getRequest()->getParam('dni_medico');

        $horaMin = new FrozenTime('3 hours ago');
        $horaMax = new FrozenTime('+3 hours');

        $dateYesterday = new FrozenDate('1 days ago');

        $programaciones = $this->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico,
            'OR' => [
                [
                    'Programaciones.fecha_programacion' => date('Y-m-d'),
                    'Programaciones.estado_id' => 4,
                    "CONCAT(Programaciones.fecha_programacion, ' ' , Programaciones.hor_inicio) >=" => $horaMin->format('Y-m-d H:i'),
                    "CONCAT(Programaciones.fecha_programacion, ' ' , Programaciones.hor_inicio) <=" => $horaMax->format('Y-m-d H:i'),
                ], [
                    'Programaciones.fecha_programacion IN' => [date('Y-m-d'), $dateYesterday->format('Y-m-d')],
                    'Programaciones.estado_id IN' => [10],
                ], [
                    'Programaciones.fecha_programacion' => date('Y-m-d'),
                    'Programaciones.estado_id IN' => [4],
                    'Programaciones.turno IN' => ['Externo', 'Emergencia'],
                ]
            ]
        ])->toArray();

        $message = '';
        if (sizeof($programaciones) === 0) {
            $message = 'No se encontraron registros';
        } else {
            $message = 'Se encontraron registros';
        }

        $this->set(compact('programaciones', 'message', 'horaMin', 'horaMax'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function solicitar()
    {
        $this->getRequest()->allowMethod("POST");
        $centro = $this->getRequest()->getData('centro');
        $dni_medico = $this->getRequest()->getData('dni_medico');
        $fecha_programacion = $this->getRequest()->getData('fecha_programacion');
        $turno = $this->getRequest()->getData('turno');
        $profesional = $this->getRequest()->getData('profesional');
        $grupo_ocupacional = $this->getRequest()->getData('grupo_ocupacional');
        $cod_planilla = $this->getRequest()->getData('cod_planilla');
        $flag_interno = $this->getRequest()->getData('flag_interno');
        $emergencia = $this->getRequest()->getData('emergencia');

        $area_ingreso = $this->getRequest()->getData('area_ingreso');
        $tipo_epp = $this->getRequest()->getData('tipo_epp');
        $cantidad = $this->getRequest()->getData('cantidad');

        if (!$emergencia) {
            $programacion = $this->Programaciones->get([
                'centro' => $centro,
                'dni_medico' => $dni_medico,
                'fecha_programacion' => $fecha_programacion,
                'turno' => $turno
            ]);
            $programacion->estado_id = 3;
        }


        $solicitud = $this->Programaciones->Solicitudes->newEmptyEntity();
        $solicitud->area_ingreso = $area_ingreso;
        $solicitud->tipo_epp = $tipo_epp;
        $solicitud->cantidad = $cantidad;
        $solicitud->fecha_solicitud = date('Y-m-d h:i');
        $solicitud->estado_id = 3;
        $solicitud->profesional = $profesional;
        $solicitud->grupo_ocupacional = $grupo_ocupacional;
        $solicitud->cod_planilla = $cod_planilla;

        $solicitud->programacion_dni_medico = $dni_medico;
        $solicitud->programacion_fecha_programacion = $fecha_programacion;
        if ($emergencia) {
            if ($flag_interno === 1) {
                $solicitud->programacion_turno = 'Emergencia';
            } else {
                $solicitud->programacion_turno = 'Externo';
            }
            $solicitud->programacion_centro = 671;
        } else {
            $solicitud->programacion_turno = $turno;
            $solicitud->programacion_centro = $centro;
        }

        $errors = null;
        try {
            $this->Programaciones->getConnection()->begin();
            if ($centro !== null) {
                $this->Programaciones->saveOrFail($programacion);
            } else {
                $nuevaProgramacion = $this->Programaciones->newEmptyEntity();
                $nuevaProgramacion->centro = 671;
                $nuevaProgramacion->dni_medico = $dni_medico;
                $nuevaProgramacion->fecha_programacion = date('Y-m-d');
                $solicitud->programacion_fecha_programacion = $nuevaProgramacion->fecha_programacion;
                if ($flag_interno === 1) {
                    $nuevaProgramacion->turno = 'Emergencia';
                } else {
                    $nuevaProgramacion->turno = 'Externo';
                }

                $nuevaProgramacion->profesional = $profesional;
                $nuevaProgramacion->grupo_ocupacional = $grupo_ocupacional;
                $nuevaProgramacion->flag_interno = $flag_interno;
                $nuevaProgramacion->estado_id = 3;
                $this->Programaciones->saveOrFail($nuevaProgramacion);
            }
            $this->Programaciones->Solicitudes->saveOrFail($solicitud);
            $message = 'Se registró la solicitud correctamente';
            $this->Programaciones->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la solicitud';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
            $this->Programaciones->getConnection()->rollback();
        } finally {
            $this->set(compact('solicitud', 'message', 'errors'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    public function registerEntrada()
    {
        $this->getRequest()->allowMethod("POST");
        $centro = $this->getRequest()->getData('centro');
        $dni_medico = $this->getRequest()->getData('dni_medico');
        $fecha_programacion = $this->getRequest()->getData('fecha_programacion');
        $turno = $this->getRequest()->getData('turno');

        $programacion = $this->Programaciones->get([
            'centro' => $centro,
            'dni_medico' => $dni_medico,
            'fecha_programacion' => $fecha_programacion,
            'turno' => $turno
        ]);

        $programacion->fecha_hora_entrada = date('Y-m-d H:i:s');
        $programacion->estado_id = 5;

        $errors = null;
        if ($this->Programaciones->save($programacion)) {
            $message = 'Se registró la entrada correctamente';
        } else {
            $message = 'No se pudo registrar la entrada';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
        }

        $this->set(compact('programacion', 'message', 'errors'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function registerSalida()
    {
        $this->getRequest()->allowMethod("POST");
        $centro = $this->getRequest()->getData('centro');
        $dni_medico = $this->getRequest()->getData('dni_medico');
        $fecha_programacion = $this->getRequest()->getData('fecha_programacion');
        $turno = $this->getRequest()->getData('turno');
        $grupos = $this->getRequest()->getData('grupos');

        $programacion = $this->Programaciones->get([
            'centro' => $centro,
            'dni_medico' => $dni_medico,
            'fecha_programacion' => $fecha_programacion,
            'turno' => $turno
        ]);

        $programacion->fecha_hora_salida = date('Y-m-d H:i:s');
        $programacion->estado_id = 6;

        $cuestionariosTable = $this->getTableLocator()->get('Cuestionarios');

        $cuestionario = $cuestionariosTable->newEntity($this->getRequest()->getData('cuestionario'));
        $cuestionario->programacion_centro = $centro;
        $cuestionario->programacion_dni_medico = $dni_medico;
        $cuestionario->programacion_fecha_programacion = $fecha_programacion;
        $cuestionario->programacion_turno = $turno;
        $cuestionario->fecha_hora = date('Y-m-d H:i:s');

        $errors = null;
        try {
            $this->Programaciones->getConnection()->begin();
            $this->Programaciones->saveOrFail($programacion);
            $cuestionariosTable->saveOrFail($cuestionario);

            $respuestas = [];
            $respuestasTable = $this->getTableLocator()->get('Respuestas');
            foreach ($grupos as $grupo) {
                foreach ($grupo['preguntas'] as $pregunta) {
                    $respuesta = $respuestasTable->newEmptyEntity();
                    $respuesta->cuestionario_id = $cuestionario->id;
                    $respuesta->pregunta_id = $pregunta["id"];
                    $respuesta->valor = $pregunta["respuesta_valor"];
                    $respuestas[] = $respuesta;
                }
            }
            $respuestasTable->saveManyOrFail($respuestas);
            $message = 'Se registró la salida correctamente';
            $this->Programaciones->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la salida';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
            $this->Programaciones->getConnection()->rollback();
        } finally {
            $this->set(compact('programacion', 'message', 'errors'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    public function registerBreakStart()
    {
        $this->getRequest()->allowMethod("POST");
        $centro = $this->getRequest()->getData('centro');
        $dni_medico = $this->getRequest()->getData('dni_medico');
        $fecha_programacion = $this->getRequest()->getData('fecha_programacion');
        $turno = $this->getRequest()->getData('turno');
        $grupos = $this->getRequest()->getData('grupos');

        $programacion = $this->Programaciones->get([
            'centro' => $centro,
            'dni_medico' => $dni_medico,
            'fecha_programacion' => $fecha_programacion,
            'turno' => $turno
        ]);

        $programacion->fecha_hora_break_start = date('Y-m-d H:i:s');
        $programacion->estado_id = 10;

        $cuestionariosTable = $this->getTableLocator()->get('Cuestionarios');

        $cuestionario = $cuestionariosTable->newEntity($this->getRequest()->getData('cuestionario'));
        $cuestionario->programacion_centro = $centro;
        $cuestionario->programacion_dni_medico = $dni_medico;
        $cuestionario->programacion_fecha_programacion = $fecha_programacion;
        $cuestionario->programacion_turno = $turno;
        $cuestionario->fecha_hora = date('Y-m-d');

        $errors = null;
        try {
            $this->Programaciones->getConnection()->begin();
            $this->Programaciones->saveOrFail($programacion);
            $cuestionariosTable->saveOrFail($cuestionario);

            $respuestas = [];
            $respuestasTable = $this->getTableLocator()->get('Respuestas');
            foreach ($grupos as $grupo) {
                foreach ($grupo['preguntas'] as $pregunta) {
                    $respuesta = $respuestasTable->newEmptyEntity();
                    $respuesta->cuestionario_id = $cuestionario->id;
                    $respuesta->pregunta_id = $pregunta["id"];
                    $respuesta->valor = $pregunta["respuesta_valor"];
                    $respuestas[] = $respuesta;
                }
            }
            $respuestasTable->saveManyOrFail($respuestas);
            $message = 'Se registró la inicio del break correctamente';
            $this->Programaciones->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar el inicio del break correctamente';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
            $this->Programaciones->getConnection()->rollback();
        } finally {
            $this->set(compact('programacion', 'message', 'errors'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    public function registerBreakFinal()
    {
        $this->getRequest()->allowMethod("POST");
        $centro = $this->getRequest()->getData('centro');
        $dni_medico = $this->getRequest()->getData('dni_medico');
        $fecha_programacion = $this->getRequest()->getData('fecha_programacion');
        $turno = $this->getRequest()->getData('turno');

        $programacion = $this->Programaciones->get([
            'centro' => $centro,
            'dni_medico' => $dni_medico,
            'fecha_programacion' => $fecha_programacion,
            'turno' => $turno
        ]);

        $programacion->fecha_hora_break_final = date('Y-m-d H:i:s');
        $programacion->estado_id = 11;

        $errors = null;
        if ($this->Programaciones->save($programacion)) {
            $message = 'Se registró el final del break correctamente';
        } else {
            $message = 'No se pudo registrar el final del break correctamente';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
        }

        $this->set(compact('programacion', 'message', 'errors'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function report()
    {
        $this->getRequest()->allowMethod("GET");
        $dni = $this->getRequest()->getQuery('dni');
        $fecha = $this->getRequest()->getQuery('fecha');
        $itemsPerPage = $this->request->getQuery('itemsPerPage');

        $query = $this->Programaciones->find()
            ->contain(['Estados'])
            ->where(['Programaciones.estado_id <>' => 2])
            ->order(['Programaciones.fecha_programacion']);

        if ($dni) {
            $query->where([
                'Programaciones.dni_medico LIKE' => '%' . $dni . '%'
            ]);
        }

        if ($fecha) {
            $query->where(["Programaciones.fecha_programacion" => $fecha]);
        }

        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }
        $programaciones = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);
        $paginate = $this->request->getAttribute('paging')['Programaciones'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];

        $this->set(compact('programaciones', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function exportExcel()
    {
        $this->getRequest()->allowMethod("POST");
        $dni = $this->getRequest()->getData('dni');
        $fecha = $this->getRequest()->getData('fecha');

        $query = $this->Programaciones->find()
            ->contain(['Estados'])
            ->where(['Programaciones.estado_id <>' => 2])
            ->order(['Programaciones.fecha_programacion']);

        if ($dni) {
            $query->where([
                'Programaciones.dni_medico LIKE' => '%' . $dni . '%'
            ]);
        }

        if ($fecha) {
            $query->where(["Programaciones.fecha_programacion" => $fecha]);
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
        $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(55);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A2:K2')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true)->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A2:K2')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('42BEFF');
        $sheet = $spreadsheet->getActiveSheet();

        // LOGO
        $drawing = new Drawing();
        $drawing->setName('ESSALUD');
        $drawing->setDescription('ESSALUD');
        $drawing->setPath(WWW_ROOT . 'img' . DS . 'logo.jpg');
        $drawing->setCoordinates('A1');
        $drawing->setWidth(240);
        $drawing->setHeight(80);
        $drawing->getShadow()->setVisible(true);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $spreadsheet->getActiveSheet()->mergeCells("D1:K1");
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Reporte de Marcaciones');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setItalic(true)->setSize(18);

        $count = $query->count();
        $programaciones = $query->toArray();

        $spreadsheet->getActiveSheet()->getStyle('A3:k' . (2 + $count))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A3:k' . (2 + $count))->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A3:k' . (2 + $count))->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A3:A' . (2 + $count))->getFont()->setBold(true);

        for ($k = 1; $k <= $count; $k++) {
            $spreadsheet->getActiveSheet()->getRowDimension(strval($k + 2))->setRowHeight(16);
        }

        $spreadsheet->getActiveSheet()->getStyle('A3:K' . (2 + $count))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $headers = ['ÍTEM', 'DNI', utf8_decode('TRABAJADOR'), utf8_decode('GRUPO OCUPACIONAL'), utf8_decode('ESTADO'), utf8_decode('TURNO'), utf8_decode('FECHA'), utf8_decode('ENTRADA'), utf8_decode('BREAK INICIO'), utf8_decode('BREAK FIN'), utf8_decode('SALIDA')];

        $sheet->fromArray($headers, NULL, "A2");
        $i = 2;
        foreach ($programaciones as $programacion) {
            $estado = $programacion->estado->descripcion;
            if (in_array($programacion->estado_id, [1])) {
                $estado = 'Sin marcación';
            }
            if ($programacion->estado_id === 5 && $programacion->flag_entrada_sistema === '1') {
                $estado .= " (sistema)";
            }
            $record = [
                $i - 1,
                @$programacion->dni_medico,
                @$programacion->profesional,
                @$programacion->grupo_ocupacional,
                @$estado,
                @$programacion->turno,
                @$programacion->fecha_programacion ? @$programacion->fecha_programacion->i18nFormat() : '',
                @$programacion->fecha_hora_entrada ? @$programacion->fecha_hora_entrada->i18nFormat() : '',
                @$programacion->fecha_hora_break_start ? @$programacion->fecha_hora_break_start->i18nFormat() : '',
                @$programacion->fecha_hora_break_final ? @$programacion->fecha_hora_break_final->i18nFormat() : '',
                @$programacion->fecha_hora_salida ? @$programacion->fecha_hora_salida->i18nFormat() : '',
            ];
            $sheet->fromArray($record, NULL, "A" . ($i + 1));
            $i++;
        }

        $writer = new Xlsx($spreadsheet);

        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'reporte_' . date('Ymd');
        $response = $this->response;
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }
}
