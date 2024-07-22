<?php
declare(strict_types=1);

namespace App\Controller;
use League\Csv\Reader;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use App\Services\TrabajadoresService;

/**
 * Programaciones Controller
 *
 * @property \App\Model\Table\ProgramacionesTable $Programaciones
 * @method \App\Model\Entity\Programacione[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrabajadoresController extends AppController
{    
    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['findAvailables', 'findEntregados', 'solicitar', 'registerEntrada', 'registerSalida']);
    }
    
    public function initialize(): void {
        parent::initialize();
        $this->loadComponent('Random');
        
    }
    
    /**
     * Load method
     *
     * @return \Cake\Http\Response|null|void Renders load
     */
    public function load() {
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
            
            $countBefore = sizeof($this->Programaciones->find()->toArray());
            $programaciones = [];
            $http = new TrabajadoresService();
            foreach ($csv as $record) {
                $programacion = $this->Programaciones->newEmptyEntity();
                if ($record['ESTADO_PROGRAMACION'] === 'APROBADA') {
                    $programacion->centro = $record["CENTRO"];
                    $programacion->periodo = $record["PERIODO"];
                    $programacion->area = $record["AREA"];
                    $programacion->servicio = $record["SERVICIO"];
                    $programacion->actividad = $record["ACTIVIDAD"];
                    $programacion->subactividad = $record["SUBACTIVIDAD"];
                    $programacion->consultorio = $record["CONSULTORIO"];
                    $programacion->ubicacionconsult = $record["UBICACIONCONSULT"];
                    
                    // $programacion->dni_medico = $record['DNI_MEDICO'], 8, '0', STR_PAD_LEFT);
                    // $programacion->profesional = $record["PROFESIONAL"];
                    $programacion->dni_medico = $record['DNI_MEDICO'];
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
                    $programacion->estado_id = 1;

                    $programaciones[] = $programacion;
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
    
    public function findAvailables() {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $programaciones = $this->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico,
            'Programaciones.fecha_programacion' => date('Y-m-d'),
            'Programaciones.estado_id' => 1
        ])->toArray();
        
        $message = '';
        if (sizeof($programaciones) === 0) {
            $message = 'No se encontraron programaciones disponibles';
        } else {
            $message = 'Se encontraron programaciones';
        }
        
        $this->set(compact('programaciones', 'message'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    public function findSolicitudes() {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $programaciones = $this->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico,
            'Programaciones.fecha_programacion' => date('Y-m-d'),
            'Programaciones.estado_id' => 3
        ])->toArray();
        
        $message = '';
        if (sizeof($programaciones) === 0) {
            $message = 'No se encontraron solicitudes';
        } else {
            $message = 'Se encontraron solicitudes';
        }
        
        $this->set(compact('programaciones', 'message'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    public function findEntregados() {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        
        $horaMin = new FrozenTime('1 hours ago');
        $horaMax = new FrozenTime('+1 hours');
        
        $programaciones = $this->Programaciones->find()->where([
            'Programaciones.dni_medico' => $dni_medico,
            'Programaciones.fecha_programacion' => date('Y-m-d'),
            'OR' => [[
                    'Programaciones.estado_id' => 4,
                    'Programaciones.hor_inicio >=' => $horaMin->format('H:i'),
                    'Programaciones.hor_inicio <=' => $horaMax->format('H:i'),                    
                ], [
                    'Programaciones.estado_id' => 5,
                    'Programaciones.hor_fin >=' => $horaMin->format('H:i'),
                    'Programaciones.hor_fin <=' => $horaMax->format('H:i'),
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
    
    public function solicitar() {
        $this->getRequest()->allowMethod("POST");
        $centro = $this->getRequest()->getData('centro');
        $dni_medico = $this->getRequest()->getData('dni_medico');
        $fecha_programacion = $this->getRequest()->getData('fecha_programacion');
        $turno = $this->getRequest()->getData('turno');
        $area_ingreso = $this->getRequest()->getData('area_ingreso');
        $tipo_epp = $this->getRequest()->getData('tipo_epp');
        $cantidad = $this->getRequest()->getData('cantidad');
        
        $programacion = $this->Programaciones->get([
            'centro' => $centro,
            'dni_medico' => $dni_medico,
            'fecha_programacion' => $fecha_programacion,
            'turno' => $turno
        ]);
        
        $programacion->area_ingreso = $area_ingreso;
        $programacion->tipo_epp = $tipo_epp;
        $programacion->cantidad = $cantidad;
        $programacion->estado_id = 3;
        
        $errors = null;
        if ($this->Programaciones->save($programacion)) {
            $message = 'Se registró la solicitud correctamente';
        } else {
            $message = 'No se pudo registrar la solicitud';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
        }
        
        $this->set(compact('programacion', 'message', 'errors'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    public function entregar() {
        $this->getRequest()->allowMethod("POST");
        $programacionesPorEntregar = $this->getRequest()->getData('programaciones');
        $firma = $this->getRequest()->getData('firma');
        
        $programaciones = [];
        foreach ($programacionesPorEntregar as $programacionPorEntregar) {
            $programacion = $this->Programaciones->get([
                'centro' => $programacionPorEntregar['centro'],
                'dni_medico' => $programacionPorEntregar['dni_medico'],
                'fecha_programacion' => $programacionPorEntregar['fecha_programacion'],
                'turno' => $programacionPorEntregar['turno']
            ]);
            $programacion->fecha_entrega = date('Y-m-d H:i:s');
            $programacion->firma = $firma;
            $programacion->estado_id = 4;
            $programaciones[] = $programacion;
        }
                
        $errors = null;
        if ($this->Programaciones->saveMany($programaciones)) {
            $message = 'Se registró la entrega correctamente';
        } else {
            $message = 'No se pudo registrar la entrega';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
        }
        
        $this->set(compact('programacion', 'message', 'errors'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    public function registerEntrada() {
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
    
    public function registerSalida() {
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
        
        $programacion->fecha_hora_salida = date('Y-m-d H:i:s');
        $programacion->estado_id = 6;
        
        $errors = null;
        if ($this->Programaciones->save($programacion)) {
            $message = 'Se registró la salida correctamente';
        } else {
            $message = 'No se pudo registrar la salida';
            $errors = $programacion->getErrors();
            $this->setResponse($this->response->withStatus(500));
        }
        
        $this->set(compact('programacion', 'message', 'errors'));
        $this->viewBuilder()->setOption('serialize', true);
    }
}