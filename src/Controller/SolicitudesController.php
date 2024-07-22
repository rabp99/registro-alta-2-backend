<?php

declare(strict_types=1);

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Http\CallbackStream;
use League\Csv\Writer;
use Cake\I18n\Time;
use Cake\I18n\FrozenDate;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Solicitudes Controller
 *
 * @property \App\Model\Table\SolicitudesTable $Solicitudes
 * @method \App\Model\Entity\Solicitude[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SolicitudesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Programaciones', 'Estados'],
        ];
        $solicitudes = $this->paginate($this->Solicitudes);

        $this->set(compact('solicitudes'));
    }

    /**
     * View method
     *
     * @param string|null $id Solicitude id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $solicitude = $this->Solicitudes->get($id, [
            'contain' => ['Programaciones', 'Estados'],
        ]);

        $this->set(compact('solicitude'));
    }

    /**
     * Save Entrega method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful Save Entrega, renders view otherwise.
     */
    public function saveEntrega()
    {
        $this->getRequest()->allowMethod('POST');
        $solicitud = $this->Solicitudes->newEntity($this->getRequest()->getData("solicitud"));

        try {
            $this->Solicitudes->getConnection()->begin();
            $consumiblesTable = $this->getTableLocator()->get('Consumibles');
            $consumible = $consumiblesTable->get($this->getRequest()->getData("consumible_id"));

            $errors = "";
            $result = $this->Authentication->getResult();
            $user_id = $result->getData()["id"];

            $solicitud->fecha_solicitud = date('Y-m-d H:i:s');
            $solicitud->fecha_entrega = date('Y-m-d H:i:s');
            $solicitud->programacion_centro = '671';
            $solicitud->tipo_epp = $consumible->descripcion . ($consumible->marca ? (" | " . $consumible->marca) : "");
            $solicitud->estado_id = 4;
            $solicitud->user_entrega_id = $user_id;
            $solicitud->flag_consumible = "1";

            if ($solicitud->cantidad <= $consumible->stock) {
                $this->Solicitudes->saveOrFail($solicitud);
                $consumible->stock = $consumible->stock - $solicitud->cantidad;
                $consumiblesTable->saveOrFail($consumible);
            } else {
                throw new \Exception('La cantidad solicitada supera el stock');
            }
            $message = 'La solicitud fue registrada correctamente';
            $this->Solicitudes->getConnection()->commit();
        } catch (Exception $ex) {
            $message = "La solicitud no fue registrada correctamente";
            if ($solicitud->cantidad > $consumible->stock) {
                $message .= "<br>" . "La cantidad solicitada supera el stock";
            }
            $errors = $solicitud->getErrors();
            $this->setResponse($this->response->withStatus(500));
            $this->Solicitudes->getConnection()->rollback();
        } finally {
            $this->set(compact('solicitud', 'message', 'errors'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Solicitude id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $solicitude = $this->Solicitudes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $solicitude = $this->Solicitudes->patchEntity($solicitude, $this->request->getData());
            if ($this->Solicitudes->save($solicitude)) {
                $this->Flash->success(__('The solicitude has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The solicitude could not be saved. Please, try again.'));
        }
        $programaciones = $this->Solicitudes->Programaciones->find('list', ['limit' => 200]);
        $estados = $this->Solicitudes->Estados->find('list', ['limit' => 200]);
        $this->set(compact('solicitude', 'programaciones', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Solicitude id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $solicitude = $this->Solicitudes->get($id);
        if ($this->Solicitudes->delete($solicitude)) {
            $this->Flash->success(__('The solicitude has been deleted.'));
        } else {
            $this->Flash->error(__('The solicitude could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function findLastEntregas()
    {
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $numero = $this->getRequest()->getParam('numero');
        $solicitudes = $this->Solicitudes->find()->where([
            'Solicitudes.programacion_dni_medico' => $dni_medico,
            'OR' => [
                'Solicitudes.flag_consumible' => 1,
                'Solicitudes.tipo_epp' => 'EPP 0'
            ],
            'Solicitudes.estado_id' => 4,
        ])
            ->order(["Solicitudes.fecha_entrega" => "DESC"])
            ->limit($numero)->toArray();

        $this->set(compact('solicitudes'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function findSolicitudes()
    {
        $solicitudes = [];
        $last_epp0 = null;
        $dni_medico = $this->getRequest()->getParam('dni_medico');
        $countSolicitudes = $this->Solicitudes->find()->where([
            'Solicitudes.programacion_dni_medico' => $dni_medico,
            "DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') =" => date('Y-m-d'),
            'Solicitudes.estado_id' => 3
        ])->count();

        $message = '';
        if (!$countSolicitudes) {
            $message = 'No se encontraron solicitudes pendientes de atender';
        } else {
            $solicitudes = $this->Solicitudes->find()->where([
                'Solicitudes.programacion_dni_medico' => $dni_medico,
                "DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') =" => date('Y-m-d'),
                'Solicitudes.estado_id' => 3
            ])->contain("Programaciones");

            // Última solicitud atendida de EPP 0
            $last_epp0 = @$this->Solicitudes->find()->where([
                'Solicitudes.programacion_dni_medico' => $dni_medico,
                'Solicitudes.tipo_epp' => 'EPP 0',
                'Solicitudes.estado_id' => 4,
            ])
                ->order(["Solicitudes.fecha_entrega" => "DESC"])
                ->first()->fecha_solicitud;

            $message = 'Se encontraron solicitudes';
        }

        $this->set(compact('solicitudes', 'message', 'last_epp0'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function entregar()
    {
        $this->getRequest()->allowMethod("POST");
        $solicitudesPorEntregar = $this->getRequest()->getData('solicitudes');
        $firma = $this->getRequest()->getData('firma');
        $reutilizablesDetalles = $this->getRequest()->getData('reutilizablesDetalles');
        $dni_medico = $this->getRequest()->getData('dni_medico');

        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];

        $solicitudes = [];
        $programaciones = [];
        foreach ($solicitudesPorEntregar as $solicitudPorEntregar) {
            $solicitud = $this->Solicitudes->get($solicitudPorEntregar['id']);
            $solicitud->cantidad = $solicitudPorEntregar['cantidad'];
            $solicitud->fecha_entrega = date('Y-m-d H:i:s');
            $solicitud->firma = $firma;
            $solicitud->estado_id = 4;
            $solicitud->user_entrega_id = $user_id;
            $solicitudes[] = $solicitud;

            $programacion = $this->Solicitudes->Programaciones->get([
                'centro' => $solicitudPorEntregar['programacion_centro'],
                'dni_medico' => $solicitudPorEntregar['programacion_dni_medico'],
                'fecha_programacion' => $solicitudPorEntregar['programacion_fecha_programacion'],
                'turno' => $solicitudPorEntregar['programacion_turno']
            ]);
            $programacion->estado_id = 4;
            $programaciones[] = $programacion;
        }

        $reutilizablesNoDisponibles = [];
        try {
            $this->Solicitudes->getConnection()->begin();
            $this->Solicitudes->saveManyOrFail($solicitudes);
            $this->Solicitudes->Programaciones->saveManyOrFail($programaciones);

            $reutilizablesSolicitudesDetallesTable = $this->getTableLocator()->get('ReutilizablesSolicitudesDetalles');
            $reutilizableTable = $this->getTableLocator()->get('Reutilizables');

            foreach ($reutilizablesDetalles as $reutilizableDetalle) {
                $reutilizable = $reutilizableTable->find()
                    ->where([
                        'Reutilizables.codigo' => $reutilizableDetalle['codigo'],
                        'Reutilizables.tipo_id' => $reutilizableDetalle['tipo_id'],
                        'Reutilizables.estado_id' => 7
                    ])->first();
                if (!is_null($reutilizable)) {
                    $reutilizable->estado_id = 8;
                    $reutilizableTable->saveOrFail($reutilizable);

                    $reutilizableSolicitudDetalle = $reutilizablesSolicitudesDetallesTable->newEmptyEntity();
                    $reutilizableSolicitudDetalle->solicitud_id = $reutilizableDetalle['solicitud_id'];
                    $reutilizableSolicitudDetalle->reutilizable_id = $reutilizable->id;
                    $reutilizableSolicitudDetalle->dni_medico = $dni_medico;
                    $reutilizableSolicitudDetalle->fecha_entrega = date('Y-m-d H:i:s');
                    $reutilizableSolicitudDetalle->estado_id = 4;
                    $reutilizableSolicitudDetalle->user_registro_entrega_id = $user_id;

                    $reutilizablesSolicitudesDetallesTable->saveOrFail($reutilizableSolicitudDetalle);
                } else {
                    $reutilizablesNoDisponibles[] = [
                        'tipo_id' => $reutilizableDetalle['tipo_id'],
                        'codigo' => $reutilizableDetalle['codigo']
                    ];
                }
            }

            if (sizeof($reutilizablesNoDisponibles) > 0) {
                throw new \Exception('Reutilizables ocupados');
            }

            $message = 'Se registró la entrega correctamente';
            $this->Solicitudes->getConnection()->commit();
        } catch (\Exception $ex) {
            $text = '';
            $tiposTable = $this->getTableLocator()->get('Tipos');
            foreach ($reutilizablesNoDisponibles as $reutilizablesNoDisponible) {
                $tipo = $tiposTable->get($reutilizablesNoDisponible['tipo_id']);
                $text .= '<br>' . $tipo->descripcion . ' con N° ' . $reutilizablesNoDisponible['codigo'];
            }

            $message = 'No se pudo registrar la entrega, se seleccionó indumentaria que no está disponible: ' . $text;
            $this->setResponse($this->response->withStatus(500));
            $this->Solicitudes->getConnection()->rollback();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la entrega';
            $this->setResponse($this->response->withStatus(500));
            $this->Solicitudes->getConnection()->rollback();
        } finally {
            $this->set(compact('solicitudes', 'message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }

    public function report()
    {
        $this->getRequest()->allowMethod("GET");
        $dni = $this->getRequest()->getQuery('dni');
        $tipo_epp = $this->getRequest()->getQuery('tipo_epp');
        $fecha_inicio = $this->getRequest()->getQuery('fecha_inicio');
        $fecha_fin = $this->getRequest()->getQuery('fecha_fin');
        $itemsPerPage = $this->request->getQuery('itemsPerPage');

        $query = $this->Solicitudes->find()
            ->contain(['Estados', 'ReutilizablesSolicitudesDetalles' => ['Reutilizables' => ['Tipos']]])
            ->order(['Solicitudes.fecha_solicitud']);

        if ($dni) {
            $query->where([
                'Solicitudes.programacion_dni_medico LIKE' => '%' . $dni . '%'
            ]);
        }

        if ($tipo_epp === "1") {
            $query->where([
                'Solicitudes.flag_consumible' => '1'
            ]);
        } elseif ($tipo_epp !== "") {
            $query->where([
                'Solicitudes.tipo_epp' => $tipo_epp
            ]);
        }

        if ($fecha_inicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') >=" => $fecha_inicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') <=" => $fecha_fin]);
        }

        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }
        $solicitudes = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);
        $paginate = $this->request->getAttribute('paging')['Solicitudes'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];

        $this->set(compact('solicitudes', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function remove()
    {
        $this->getRequest()->allowMethod('POST');
        $solicitud_id = $this->getRequest()->getData('solicitud_id');
        $solicitud = $this->Solicitudes->get($solicitud_id);
        $solicitud->estado_id = 2;
        $message = '';

        if ($this->Solicitudes->save($solicitud)) {
            $message = 'Se eliminó la solicitud correctamente';
        } else {
            $this->setResponse($this->response->withStatus(500));
            $message = 'No se pudo eliminar la solicitud correctamente';
        }

        $this->set(compact('message'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function removeBd()
    {
        $this->getRequest()->allowMethod('POST');
        $solicitud_id = $this->getRequest()->getData('solicitud_id');
        $solicitud = $this->Solicitudes->get($solicitud_id);
        $message = '';

        if ($this->Solicitudes->delete($solicitud)) {
            $message = 'Se eliminó la solicitud correctamente';
        } else {
            $this->setResponse($this->response->withStatus(500));
            $message = 'No se pudo eliminar la solicitud correctamente';
        }

        $this->set(compact('message'));
        $this->viewBuilder()->setOption('serialize', true);
    }

    public function exportExcel()
    {
        $this->getRequest()->allowMethod("POST");
        $dni = $this->getRequest()->getData('dni');
        $tipo_epp = $this->getRequest()->getData('tipo_epp');
        $fecha_inicio = $this->getRequest()->getData('fecha_inicio');
        $fecha_fin = $this->getRequest()->getData('fecha_fin');

        $query = $this->Solicitudes->find()
            ->contain(['Estados', 'ReutilizablesSolicitudesDetalles' => ['Reutilizables' => ['Tipos']]])
            ->order(['Solicitudes.fecha_solicitud']);

        if ($dni) {
            $query->where([
                'Solicitudes.programacion_dni_medico LIKE' => '%' . $dni . '%'
            ]);
        }

        if ($tipo_epp) {
            $query->where([
                'Solicitudes.flag_consumible' => '1'
            ]);
        } else {
            $query->where([
                'Solicitudes.flag_consumible IS NULL'
            ]);
        }

        if ($fecha_inicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') >=" => $fecha_inicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') <=" => $fecha_fin]);
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
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('A2:Q2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A2:Q2')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A2:Q2')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A2:Q2')->getFont()->setBold(true)->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A2:Q2')
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

        $spreadsheet->getActiveSheet()->mergeCells("D1:Q1");
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Reporte de Solicitudes');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setItalic(true)->setSize(18);

        $count = $query->count();
        $solicitudes = $query->toArray();

        $spreadsheet->getActiveSheet()->getStyle('A3:Q' . (2 + $count))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A3:Q' . (2 + $count))->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A3:Q' . (2 + $count))->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A3:A' . (2 + $count))->getFont()->setBold(true);

        for ($k = 1; $k <= $count; $k++) {
            $spreadsheet->getActiveSheet()->getRowDimension(strval($k + 2))->setRowHeight(62);
        }

        $spreadsheet->getActiveSheet()->getStyle('A3:Q' . (2 + $count))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $headers = ['ÍTEM', utf8_decode('NRO. DE DOC.'), utf8_decode('TRABAJADOR'), utf8_decode('ESTADO'), utf8_decode('SOLICITUD'), utf8_decode('ENTREGA'), 'ÁREA A LA QUE INGRESA', utf8_decode('TIPO DE EPP'), utf8_decode('CANTIDAD'), utf8_decode('TURNO'), utf8_decode('FIRMA')];

        $tiposTable = TableRegistry::getTableLocator()->get('Tipos');
        $tipos = $tiposTable->find()->toArray();

        foreach ($tipos as $tipo) {
            $headers[] = $tipo->descripcion . ' - 1';
        }

        foreach ($tipos as $tipo) {
            $headers[] = $tipo->descripcion . ' - 2';
        }

        $sheet->fromArray($headers, NULL, "A2");
        $i = 2;
        foreach ($solicitudes as $solicitud) {
            if ($solicitud->firma) {
                // Resample image
                $orig = @imagecreatefrompng($solicitud->firma);
                if (!$orig) {
                    $target  = imagecreatetruecolor(90, 30);
                    $fondo = imagecolorallocate($target, 255, 255, 255);
                    $ct  = imagecolorallocate($target, 0, 0, 0);
                    imagefilledrectangle($target, 0, 0, 90, 30, $fondo);

                    Log::notice($solicitud->programacion_dni_medico, 'firmas');
                } else {
                    $imgWidth = imagesx($orig);
                    $imgHeight = imagesy($orig);

                    $target = imagecreatetruecolor($imgWidth, $imgHeight);

                    imagealphablending($target, false);
                    imagesavealpha($target, true);

                    imagecopyresampled($target, $orig, 0, 0, 0, 0, $imgWidth, $imgHeight, $imgWidth, $imgHeight);
                }

                $drawing = new MemoryDrawing();
                $drawing->setName($solicitud->programacion_dni_medico);
                $drawing->setDescription($solicitud->programacion_dni_medico);
                $drawing->setImageResource($target);
                $drawing->setRenderingFunction(MemoryDrawing::RENDERING_PNG);
                $drawing->setMimeType(MemoryDrawing::MIMETYPE_DEFAULT);
                $drawing->setCoordinates('K' . ($i + 1));
                $drawing->setWidth(240);
                $drawing->setHeight(80);
                $drawing->setOffsetX(1);
                $drawing->setOffsetY(1);
                // $drawing->setOffsetX(110);
                // $drawing->setRotation(25);
                $drawing->getShadow()->setVisible(true);
                // $drawing->getShadow()->setDirection(45);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());
            }

            $fecha_solicitud = '';
            if ($solicitud->fecha_solicitud) {
                $fecha_solicitud = @$solicitud->fecha_solicitud->i18nFormat();
            }

            $fecha_entrega = '';
            if ($solicitud->fecha_entrega) {
                $fecha_entrega = @$solicitud->fecha_entrega->i18nFormat();
            }

            $indumentaria = [];
            $reutilizablesSolicitudesDetalles = $solicitud->reutilizables_solicitudes_detalles;
            foreach ($tipos as $tipo) {
                $found = false;
                foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                    if ($tipo->id === $reutilizablesSolicitudesDetalle->reutilizable->tipo_id) {
                        $indumentaria[] = $reutilizablesSolicitudesDetalle->reutilizable->codigo;
                        $index = array_search($reutilizablesSolicitudesDetalle, $reutilizablesSolicitudesDetalles);
                        unset($reutilizablesSolicitudesDetalles[$index]);
                        $found = true;
                        break;
                    }
                }
                if (!$found && $solicitud->tipo_epp !== 'EPP 2') {
                    $indumentaria[] = 'D';
                }
            }

            if ($solicitud->cantidad === 2) {
                foreach ($tipos as $tipo) {
                    $found = false;
                    foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                        if ($tipo->id === $reutilizablesSolicitudesDetalle->reutilizable->tipo_id) {
                            $indumentaria[] = $reutilizablesSolicitudesDetalle->reutilizable->codigo;
                            $index = array_search($reutilizablesSolicitudesDetalle, $reutilizablesSolicitudesDetalles);
                            unset($reutilizablesSolicitudesDetalles[$index]);
                            $found = true;
                            break;
                        }
                    }
                    if (!$found && $solicitud->tipo_epp !== 'EPP 2') {
                        $indumentaria[] = 'D';
                    }
                }
            }

            $record = array_merge([
                $i - 1,
                @$solicitud->programacion_dni_medico,
                @$solicitud->profesional,
                @$solicitud->estado->descripcion,
                $fecha_solicitud,
                $fecha_entrega,
                @$solicitud->area_ingreso,
                @$solicitud->tipo_epp,
                @$solicitud->cantidad,
                @$solicitud->programacion_turno,
                ''
            ], $indumentaria);
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

    public function exportCsv()
    {
        $this->getRequest()->allowMethod("POST");
        $dni = $this->getRequest()->getData('dni');
        $tipo_epp = $this->getRequest()->getData('tipo_epp');
        $fecha_inicio = $this->getRequest()->getData('fecha_inicio');
        $fecha_fin = $this->getRequest()->getData('fecha_fin');

        $query = $this->Solicitudes->find()
            ->contain(['Estados', 'ReutilizablesSolicitudesDetalles' => ['Reutilizables' => ['Tipos']]])
            ->order(['Solicitudes.fecha_solicitud']);

        if ($dni) {
            $query->where([
                'Solicitudes.programacion_dni_medico LIKE' => '%' . $dni . '%'
            ]);
        }

        if ($tipo_epp) {
            $query->where([
                'Solicitudes.flag_consumible' => '1'
            ]);
        } else {
            $query->where([
                'Solicitudes.flag_consumible IS NULL'
            ]);
        }

        if ($fecha_inicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') >=" => $fecha_inicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_solicitud, '%Y-%m-%d') <=" => $fecha_fin]);
        }

        $count = $query->count();

        $headers1 = [
            utf8_decode('ÍTEM'), utf8_decode('NRO. DE DOC.'), utf8_decode('TRABAJADOR'), utf8_decode('ESTADO'),
            utf8_decode('SOLICITUD'), utf8_decode('ENTREGA'), utf8_decode('ÁREA A LA QUE INGRESA'),
            utf8_decode('TIPO DE EPP'), utf8_decode('CANTIDAD'), utf8_decode('TURNO')
        ];

        $tiposTable = TableRegistry::getTableLocator()->get('Tipos');
        $tipos = $tiposTable->find()->toArray();

        foreach ($tipos as $tipo) {
            $headers1[] = utf8_decode($tipo->descripcion . ' - 1');
        }

        foreach ($tipos as $tipo) {
            $headers1[] = utf8_decode($tipo->descripcion . ' - 2');
        }

        $time = new Time();
        $timeText = $time->format('YmdHis');
        $file = TMP . 'reports' . DS . 'report-' . $timeText . '.csv';
        $csv = Writer::createFromPath($file, 'w+');
        $csv->setDelimiter('|');

        $csv->insertOne($headers1);
        $i = 1;
        for ($j = 0; $j <= $count; $j = $j + 1000) {
            $solicitudes = $query->limit(1000)->offset($j)->toArray();

            foreach ($solicitudes as $solicitud) {
                $fecha_solicitud = '';
                if ($solicitud->fecha_solicitud) {
                    $fecha_solicitud = @$solicitud->fecha_solicitud->i18nFormat();
                }

                $fecha_entrega = '';
                if ($solicitud->fecha_entrega) {
                    $fecha_entrega = @$solicitud->fecha_entrega->i18nFormat();
                }

                $indumentaria = [];
                $reutilizablesSolicitudesDetalles = $solicitud->reutilizables_solicitudes_detalles;
                foreach ($tipos as $tipo) {
                    $found = false;
                    foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                        if ($tipo->id === $reutilizablesSolicitudesDetalle->reutilizable->tipo_id) {
                            $indumentaria[] = $reutilizablesSolicitudesDetalle->reutilizable->codigo;
                            $index = array_search($reutilizablesSolicitudesDetalle, $reutilizablesSolicitudesDetalles);
                            unset($reutilizablesSolicitudesDetalles[$index]);
                            $found = true;
                            break;
                        }
                    }
                    if (!$found && $solicitud->tipo_epp !== 'EPP 2') {
                        $indumentaria[] = 'D';
                    }
                }

                if ($solicitud->cantidad === 2) {
                    foreach ($tipos as $tipo) {
                        $found = false;
                        foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle) {
                            if ($tipo->id === $reutilizablesSolicitudesDetalle->reutilizable->tipo_id) {
                                $indumentaria[] = $reutilizablesSolicitudesDetalle->reutilizable->codigo;
                                $index = array_search($reutilizablesSolicitudesDetalle, $reutilizablesSolicitudesDetalles);
                                unset($reutilizablesSolicitudesDetalles[$index]);
                                $found = true;
                                break;
                            }
                        }
                        if (!$found && $solicitud->tipo_epp !== 'EPP 2') {
                            $indumentaria[] = 'D';
                        }
                    }
                }

                $solicitudNew = array_merge([
                    $i,
                    @$solicitud->programacion_dni_medico,
                    utf8_decode(@$solicitud->profesional),
                    @$solicitud->estado->descripcion,
                    $fecha_solicitud,
                    $fecha_entrega,
                    utf8_decode(@$solicitud->area_ingreso),
                    utf8_decode(@$solicitud->tipo_epp),
                    @$solicitud->cantidad,
                    @$solicitud->programacion_turno
                ], $indumentaria);

                $csv->insertOne($solicitudNew);
                $i++;
            }
            unset($solicitudes);
        }
        $response = $this->response->withFile(
            $file,
            ['download' => true, 'name' => 'reporte-' . $timeText . '.csv']
        );

        // Delete older files
        // 86400
        $currentFile = new File($file);
        $currentTimeStamp = $currentFile->lastChange();

        $folderToSearch = new Folder(TMP . 'reports');
        $fileNames = $folderToSearch->find();
        foreach ($fileNames as $fileName) {
            $fileIt = new File(TMP . 'reports' . DS . $fileName);
            if ($currentTimeStamp - $fileIt->lastChange() > 86400) {
                $fileIt->delete();
            }
        }
        return $response;
    }

    public function reportAnexo3()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');
        $fechaInicioFormated = new FrozenDate($fechaInicio);
        $fechaFinFormated = new FrozenDate($fechaFin);

        $query = $this->Solicitudes->find()
            ->where(["Solicitudes.estado_id" => 4]);

        if ($fechaInicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') >=" => $fechaInicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') <=" => $fechaFin]);
        }

        $headers = [
            'Áreas / EPP', 'Asistenciales', 'Administrativos', 'Mantenimiento', 'Limpieza', 'Seguridad',
            'Otras (Biomédico Hemodialisis, Nutrición, Biomédico, Ofic. Relaciones Institucionales, Sacerdote, Operario)'
        ];

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->mergeCells("C1:G1");
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'Anexo 3');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->setBold(true)->setItalic(true)->setSize(18);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
        $spreadsheet->getActiveSheet()->setCellValue('A3', "Intervalo de Fechas: " . $fechaInicioFormated->i18nFormat() . " - " . $fechaFinFormated->i18nFormat());

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

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

        $spreadsheet->getActiveSheet()->getRowDimension(4)->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle("A4:G4")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A4:G4")->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle("A4:G4")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A4:G4")->getFont()->setBold(true)->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle("A4:G4")
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('42BEFF');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($headers, NULL, "A4");

        $spreadsheet->getActiveSheet()->getStyle('A5:G22')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('B5:G22')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A5:G22')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A5:A22')->getFont()->setBold(true);

        for ($k = 1; $k <= 22; $k++) {
            $spreadsheet->getActiveSheet()->getRowDimension(strval($k + 3))->setRowHeight(30);
        }

        $spreadsheet->getActiveSheet()->getStyle('A5:G22')
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $gruposAsistenciales = [
            "MEDICO",
            "TECNOLOGO MEDICO EN TERAPIA FIS.Y REHAB.",
            "ENFERMERA(O)",
            "TECNICO DE ENFERMERIA",
            "TECNOLOGO MEDICO DE LABORATORIO",
            "TECNICO DE SERVICIO ASISTENCIAL",
            "TECNOLOGO MEDICO DE RADIOLOGIA",
            "ENFERMERA",
            "TECNOLOGO MEDICO",
            "QUIMICO FARMACEUTICO",
            "OBSTETRIZ",
            "BIOLOGO",
            "ODONTOLOGO",
            "RESIDENTE MEDICO",
            "QUMICO FARMACEUTICO",
            "NUTRICIONISTA",
            "TRABAJADOR(A) SOCIAL",
            "TRABAJADORA SOCIAL",
            "Chofer Asistencial",
            "PSICOLOGO",
            "DIGITADOR ASISTENCIAL"
        ];

        $gruposAdministrativos = [
            "ADMINISTRACION"
        ];

        $gruposMantenimiento = [
            "Mantenimiento Electromecanico",
            "Mantenimiento Infraestructura"
        ];

        $gruposLimpieza = [
            "Limpieza", "Silsa 5to"
        ];

        $grupoSeguridad = [
            "Vigilancia"
        ];

        $grupoOtras = [
            "Biomédico Hemodialisis",
            "Nutrición",
            "Biomedico",
            "OFIC. RELACIONES INSTITUCIONALES",
            "Padre",
            "SACERDOTE", 'operario'
        ];

        $asistenciales = $query->cleanCopy();
        $asistenciales->where(['Solicitudes.grupo_ocupacional IN' => $gruposAsistenciales]);

        $administrativos = $query->cleanCopy();
        $administrativos->where(['Solicitudes.grupo_ocupacional IN' => $gruposAdministrativos]);

        $mantenimiento = $query->cleanCopy();
        $mantenimiento->where(['Solicitudes.grupo_ocupacional IN' => $gruposMantenimiento]);

        $limpieza = $query->cleanCopy();
        $limpieza->where(['Solicitudes.grupo_ocupacional IN' => $gruposLimpieza]);

        $seguridad = $query->cleanCopy();
        $seguridad->where(['Solicitudes.grupo_ocupacional IN' => $grupoSeguridad]);

        $otras = $query->cleanCopy();
        $otras->where(['OR' => [
            'Solicitudes.grupo_ocupacional IN' => $grupoOtras,
            'Solicitudes.grupo_ocupacional IS NULL'
        ]]);

        // EPP 0
        $epp0 = [];
        $epp0[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 0'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp0[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 0'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp0[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 0'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp0[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 0'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp0[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 0'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp0[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 0'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        // EPP 2
        $epp2 = [];
        $epp2[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 2'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp2[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 2'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp2[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 2'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp2[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 2'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp2[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 2'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp2[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 2'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        // EPP 5
        $epp5 = [];
        $epp5[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 5'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp5[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 5'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp5[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 5'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp5[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 5'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp5[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 5'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp5[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 5'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        // EPP 8
        $epp8 = [];
        $epp8[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 8'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp8[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 8'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp8[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 8'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp8[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 8'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp8[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 8'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $epp8[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp' => 'EPP 8'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        // Respiradores
        $respiradoresEPP = [];
        $respiradoresEPP[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%RESPIRADOR%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $respiradoresEPP[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%RESPIRADOR%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $respiradoresEPP[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%RESPIRADOR%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $respiradoresEPP[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%RESPIRADOR%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $respiradoresEPP[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%RESPIRADOR%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $respiradoresEPP[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%RESPIRADOR%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        // N95
        $n95EPP = [];
        $n95EPP[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp' => 'N95'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $n95EPP[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp' => 'N95'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $n95EPP[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp' => 'N95'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $n95EPP[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp' => 'N95'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $n95EPP[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp' => 'N95'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $n95EPP[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp' => 'N95'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        // Lentes
        $lentesEPP = [];
        $lentesEPP[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%LENTES%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $lentesEPP[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%LENTES%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $lentesEPP[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%LENTES%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $lentesEPP[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%LENTES%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $lentesEPP[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%LENTES%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $lentesEPP[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%LENTES%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        // Filtros
        $filtrosEPP = [];
        $filtrosEPP[] = array_reduce($asistenciales->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%FILTROS%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $filtrosEPP[] = array_reduce($administrativos->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%FILTROS%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $filtrosEPP[] = array_reduce($mantenimiento->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%FILTROS%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $filtrosEPP[] = array_reduce($limpieza->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%FILTROS%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $filtrosEPP[] = array_reduce($seguridad->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%FILTROS%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });
        $filtrosEPP[] = array_reduce($otras->cleanCopy()->where(['Solicitudes.tipo_epp LIKE' => '%FILTROS%'])->toArray(), function ($carry, $row) {
            $carry += $row->cantidad;
            return $carry;
        });

        $gorros = [];
        $caretas = [];
        $mascarillasQuiru = [];
        $mascarillaN95 = [];
        $mascarillaKN95 = []; // no hay
        $respiradores = [];
        $filtros = [];
        $guantesQuiru = [];
        $guantesEsteriles = []; // no hays
        $chaquetas = [];
        $pantalones = [];
        $mandilones = [];
        $mamelucos = [];
        $botasDescartables = [];
        $botasGoma = []; // no hay
        $guantesTermicos = []; // no hay
        $lentes = [];
        $otros = []; // no hay

        // EPP 0
        $caretas = $epp0;
        $mascarillasQuiru = array_map(function ($epp) {
            return $epp * 50;
        }, $epp0);

        // EPP 2
        $gorros = $epp2;
        $guantesQuiru = $epp2;
        $mandilones = $epp2;
        foreach ($caretas as $key => $careta) {
            $caretas[$key] += $epp2[$key];
        }

        foreach ($mascarillasQuiru as $key => $mascarillaQuiru) {
            // $mascarillasQuiru[$key] += ($epp2[$key] * 50);
        }

        // EPP 5
        $chaquetas = $epp5;
        $botasDescartables = $epp5;
        foreach ($gorros as $key => $gorro) {
            $gorros[$key] += $epp5[$key];
        }

        foreach ($guantesQuiru as $key => $guanteQuiru) {
            $guantesQuiru[$key] += $epp5[$key];
        }

        foreach ($mandilones as $key => $mandilon) {
            $mandilones[$key] += $epp5[$key];
        }

        foreach ($caretas as $key => $careta) {
            $caretas[$key] += $epp5[$key];
        }

        foreach ($mascarillasQuiru as $key => $mascarillaQuiru) {
            $mascarillasQuiru[$key] += $epp5[$key];
        }

        $pantalones = $epp5;

        // EPP 8
        foreach ($chaquetas as $key => $chaqueta) {
            $chaquetas[$key] += $epp8[$key];
        }

        foreach ($botasDescartables as $key => $botasDescartable) {
            $botasDescartables[$key] += $epp8[$key];
        }

        foreach ($gorros as $key => $gorro) {
            $gorros[$key] += $epp8[$key];
        }

        foreach ($guantesQuiru as $key => $guanteQuiru) {
            $guantesQuiru[$key] += $epp8[$key];
        }

        $mamelucos = $epp8;

        foreach ($mandilones as $key => $mandilon) {
            $mandilones[$key] += $epp8[$key];
        }

        foreach ($caretas as $key => $careta) {
            $caretas[$key] += $epp8[$key];
        }

        foreach ($mascarillasQuiru as $key => $mascarillaQuiru) {
            $mascarillasQuiru[$key] += $epp8[$key];
        }

        foreach ($pantalones as $key => $pantalon) {
            $gorros[$key] += $epp8[$key];
        }

        // Respiradores
        $respiradores = $respiradoresEPP;

        // N95
        $mascarillaN95 = $n95EPP;

        // Lentes
        $lentes = $lentesEPP;

        // Filtros
        $filtros = $filtrosEPP;

        $i = 4;
        array_unshift($gorros, "Gorros");
        array_unshift($caretas, "Caretas");
        array_unshift($mascarillasQuiru, "Mascarilla Quirurgica");
        array_unshift($mascarillaN95, "Mascarilla N95");
        array_unshift($mascarillaKN95, "Mascarilla KN95");
        array_unshift($respiradores, "Respiradores");
        array_unshift($filtros, "Filtros");
        array_unshift($guantesQuiru, "Guantes Quirurgicos");
        array_unshift($guantesEsteriles, "Guantes Esteriles");
        array_unshift($chaquetas, "Chaquetas");
        array_unshift($pantalones, "Pantalón");
        array_unshift($mandilones, "Mandilon");
        array_unshift($mamelucos, "Mameluco");
        array_unshift($botasDescartables, "Botas descartables");
        array_unshift($botasGoma, "Botas de Goma");
        array_unshift($guantesTermicos, "Guantes Térmicos");
        array_unshift($lentes, "Lentes");
        array_unshift($otros, "Otros (Especificar)");

        $sheet->fromArray($gorros, NULL, "A" . ($i + 1));
        $sheet->fromArray($caretas, NULL, "A" . ($i + 2));
        $sheet->fromArray($mascarillasQuiru, NULL, "A" . ($i + 3));
        $sheet->fromArray($mascarillaN95, NULL, "A" . ($i + 4));
        $sheet->fromArray($mascarillaKN95, NULL, "A" . ($i + 5));
        $sheet->fromArray($respiradores, NULL, "A" . ($i + 6));
        $sheet->fromArray($filtros, NULL, "A" . ($i + 7));
        $sheet->fromArray($guantesQuiru, NULL, "A" . ($i + 8));
        $sheet->fromArray($guantesEsteriles, NULL, "A" . ($i + 9));
        $sheet->fromArray($chaquetas, NULL, "A" . ($i + 10));
        $sheet->fromArray($pantalones, NULL, "A" . ($i + 11));
        $sheet->fromArray($mandilones, NULL, "A" . ($i + 12));
        $sheet->fromArray($mamelucos, NULL, "A" . ($i + 13));
        $sheet->fromArray($botasDescartables, NULL, "A" . ($i + 14));
        $sheet->fromArray($botasGoma, NULL, "A" . ($i + 15));
        $sheet->fromArray($guantesTermicos, NULL, "A" . ($i + 16));
        $sheet->fromArray($lentes, NULL, "A" . ($i + 17));
        $sheet->fromArray($otros, NULL, "A" . ($i + 18));

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

    public function reportAnexo4()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');
        $fechaInicioFormated = new FrozenDate($fechaInicio);
        $fechaFinFormated = new FrozenDate($fechaFin);

        $query = $this->Solicitudes->find()
            ->where(["Solicitudes.estado_id" => 4]);

        if ($fechaInicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') >=" => $fechaInicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') <=" => $fechaFin]);
        }

        $query->select([
            'profesional',
            'grupo_ocupacional',
            'epp_0' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 0' THEN cantidad ELSE 0 END"),
            'epp_2' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 2' THEN cantidad ELSE 0 END"),
            'epp_5' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 5' THEN cantidad ELSE 0 END"),
            'epp_8' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 8' THEN cantidad ELSE 0 END"),
            'respiradores' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%RESPIRADOR%' THEN cantidad ELSE 0 END"),
            'n95' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%N95%' THEN cantidad ELSE 0 END"),
            'lentes' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%LENTES%' THEN cantidad ELSE 0 END"),
            'filtros' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%FILTROS%' THEN cantidad ELSE 0 END"),
        ])
            ->group(['profesional', 'grupo_ocupacional']);

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->mergeCells("C1:G1");
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'Anexo 4');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->setBold(true)->setItalic(true)->setSize(18);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
        $spreadsheet->getActiveSheet()->setCellValue('A3', "Intervalo de Fechas: " . $fechaInicioFormated->i18nFormat() . " - " . $fechaFinFormated->i18nFormat());

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
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);

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

        $spreadsheet->getActiveSheet()->getRowDimension(4)->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle("A4:T4")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A4:T4")->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle("A4:T4")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A4:T4")->getFont()->setBold(true)->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle("A4:T4")
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('42BEFF');
        $sheet = $spreadsheet->getActiveSheet();

        $count = $query->count();
        $solicitudes = $query->map(function ($solicitud) {
            // Gorros
            $solicitud->gorros = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Caretas
            $solicitud->caretas = $solicitud->epp_0 + $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Mascarilla Quirurgica
            $solicitud->mascarilla_quirurgica = ($solicitud->epp_0 * 50) + ($solicitud->epp_2 * 0) + ($solicitud->epp_5 * 1) + ($solicitud->epp_8 * 1);

            // Mascarilla N95
            $solicitud->mascarilla_n95 = $solicitud->n95;

            // Mascarilla KN95
            $solicitud->mascarilla_kn95 = 0;

            // Respiradores
            $solicitud->respiradores = $solicitud->respiradores;

            // Filtros
            $solicitud->filtros = $solicitud->filtros;

            // Guantes Quirurgicos
            $solicitud->guantes_quirurgicos = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Guantes Esteriles
            $solicitud->guantes_esteriles = 0;

            // Chaquetas
            $solicitud->chaquetas = $solicitud->epp_5 + $solicitud->epp_8;

            // Pantalones
            $solicitud->pantalones = $solicitud->epp_5 + $solicitud->epp_8;

            // Mandilones
            $solicitud->mandilones = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Mamelucos
            $solicitud->mamelucos = $solicitud->epp_8;

            // Botas descartables
            $solicitud->botas_descartables = $solicitud->epp_5 + $solicitud->epp_8;

            // Botas de Goma
            $solicitud->botas_goma = 0;

            // Guantes Térmicos
            $solicitud->guantes_termicos = 0;

            // Lentes
            $solicitud->lentes = $solicitud->lentes;

            // Otros
            $solicitud->otros = 0;

            return $solicitud;
        })->toArray();

        $spreadsheet->getActiveSheet()->getStyle('A5:T' . (4 + $count))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A5:T' . (4 + $count))->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A5:T' . (4 + $count))->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A5:A' . (4 + $count))->getFont()->setBold(true);

        for ($k = 1; $k <= $count; $k++) {
            $spreadsheet->getActiveSheet()->getRowDimension(strval($k + 4))->setRowHeight(30);
        }

        $spreadsheet->getActiveSheet()->getStyle('A5:T' . (4 + $count))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $headers = [
            'Nombres y Apellidos', 'Área', 'Gorros', 'Caretas', 'Mascarilla Quirúrgica', //5
            'Mascarilla N95', 'Mascarilla KN95', 'Respiradores', 'Filtros', 'Guantes Quirúrgicos', //5 
            'Guantes Esteriles', 'Chaqueta', 'Pantalón', 'Mandilon', 'Mameluco', 'Botas descartables', //6
            'Botas de Goma', 'Guantes Térmicos', 'Lentes', 'Otros (Especificar)'
        ]; //4
        $sheet->fromArray($headers, NULL, "A4");

        $i = 2;
        $gruposAsistenciales = [
            "MEDICO",
            "TECNOLOGO MEDICO EN TERAPIA FIS.Y REHAB.",
            "ENFERMERA(O)",
            "TECNICO DE ENFERMERIA",
            "TECNOLOGO MEDICO DE LABORATORIO",
            "TECNICO DE SERVICIO ASISTENCIAL",
            "TECNOLOGO MEDICO DE RADIOLOGIA",
            "ENFERMERA",
            "TECNOLOGO MEDICO",
            "QUIMICO FARMACEUTICO",
            "OBSTETRIZ",
            "BIOLOGO",
            "ODONTOLOGO",
            "RESIDENTE MEDICO",
            "QUMICO FARMACEUTICO",
            "NUTRICIONISTA",
            "TRABAJADOR(A) SOCIAL",
            "TRABAJADORA SOCIAL",
            "Chofer Asistencial",
            "PSICOLOGO",
            "DIGITADOR ASISTENCIAL"
        ];

        $gruposAdministrativos = [
            "ADMINISTRACION"
        ];

        $gruposMantenimiento = [
            "Mantenimiento Electromecanico",
            "Mantenimiento Infraestructura"
        ];

        $gruposLimpieza = [
            "Limpieza", "Silsa 5to"
        ];

        $grupoSeguridad = [
            "Vigilancia"
        ];

        $grupoOtras = [
            "Biomédico Hemodialisis",
            "Nutrición",
            "Biomedico",
            "OFIC. RELACIONES INSTITUCIONALES",
            "Padre",
            "SACERDOTE", 'operario'
        ];
        foreach ($solicitudes as $solicitud) {
            if (in_array($solicitud["grupo_ocupacional"], $gruposAsistenciales)) {
                $area = "Asistenciales";
            }

            if (in_array($solicitud["grupo_ocupacional"], $gruposAdministrativos)) {
                $area = "Administrativos";
            }

            if (in_array($solicitud["grupo_ocupacional"], $gruposMantenimiento)) {
                $area = "Mantenimiento";
            }

            if (in_array($solicitud["grupo_ocupacional"], $gruposLimpieza)) {
                $area = "Limpieza";
            }

            if (in_array($solicitud["grupo_ocupacional"], $grupoSeguridad)) {
                $area = "Seguridad";
            }

            if (in_array($solicitud["grupo_ocupacional"], $grupoOtras)) {
                $area = "Otras (Biomédico Hemodialisis, Nutrición, Biomédico, Ofic. Relaciones Institucionales, Sacerdote, Operario)";
            }

            $record = [
                @$solicitud["profesional"],
                @$area,
                @$solicitud["gorros"],
                @$solicitud["caretas"],
                @$solicitud["mascarilla_quirurgica"],
                @$solicitud["mascarilla_n95"],
                @$solicitud["mascarilla_kn95"],
                @$solicitud["respiradores"],
                @$solicitud["filtros"],
                @$solicitud["guantes_quirurgicos"],
                @$solicitud["guantes_esteriles"],
                @$solicitud["chaquetas"],
                @$solicitud["pantalones"],
                @$solicitud["mandilones"],
                @$solicitud["mamelucos"],
                @$solicitud["botas_descartables"],
                @$solicitud["botas_goma"],
                @$solicitud["guantes_termicos"],
                @$solicitud["lentes"],
                @$solicitud["otros"]
            ];
            $sheet->fromArray($record, NULL, "A" . ($i + 3));
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

    public function reportCuadroResumen()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');
        $fechaInicioFormated = new FrozenDate($fechaInicio);
        $fechaFinFormated = new FrozenDate($fechaFin);

        $query = $this->Solicitudes->find()
            ->where(["Solicitudes.estado_id" => 4]);

        if ($fechaInicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') >=" => $fechaInicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') <=" => $fechaFin]);
        }

        $query->select([
            'user_entrega_id',
            "fecha_entrega_date" => "DATE(fecha_entrega)",
            'Users.nombre_completo',
            'Users.username',
            'epp_0' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 0' THEN cantidad ELSE 0 END"),
            'epp_2' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 2' THEN cantidad ELSE 0 END"),
            'epp_5' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 5' THEN cantidad ELSE 0 END"),
            'epp_8' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 8' THEN cantidad ELSE 0 END"),
            'respiradores' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%RESPIRADOR%' THEN cantidad ELSE 0 END"),
            'n95' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%N95%' THEN cantidad ELSE 0 END"),
            'lentes' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%LENTES%' THEN cantidad ELSE 0 END"),
            'filtros' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%FILTROS%' THEN cantidad ELSE 0 END"),
        ])
            ->group(['user_entrega_id', "fecha_entrega_date"])
            ->order(['fecha_entrega_date'])
            ->contain(['Users']);

        $spreadsheet = IOFactory::load(RESOURCES . 'cuadro_resumen_template.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->getCell('C1')->setValue("ENTREGA DE EPP DEL " . $fechaInicioFormated . " AL " . $fechaFinFormated);

        $count = $query->count();

        $spreadsheet->getActiveSheet()->insertNewRowBefore(11, $count);
        $spreadsheet->getActiveSheet()->removeRow(10 + $count);

        $solicitudes = $query->map(function ($solicitud) {
            // Gorros
            $solicitud->gorros = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Caretas
            $solicitud->caretas = $solicitud->epp_0 + $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Mascarilla Quirurgica
            $solicitud->mascarilla_quirurgica = ($solicitud->epp_0 * 50) + ($solicitud->epp_2 * 0) + ($solicitud->epp_5 * 1) + ($solicitud->epp_8 * 1);

            // Mascarilla N95
            $solicitud->mascarilla_n95 = $solicitud->n95;

            // Mascarilla KN95
            $solicitud->mascarilla_kn95 = 0;

            // Respiradores
            $solicitud->respiradores = $solicitud->respiradores;

            // Filtros
            $solicitud->filtros = $solicitud->filtros;

            // Guantes Quirurgicos
            $solicitud->guantes_quirurgicos = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Guantes Esteriles
            $solicitud->guantes_esteriles = 0;

            // Chaquetas
            $solicitud->chaquetas = $solicitud->epp_5 + $solicitud->epp_8;

            // Pantalones
            $solicitud->pantalones = $solicitud->epp_5 + $solicitud->epp_8;

            // Mandilones
            $solicitud->mandilones = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Mamelucos
            $solicitud->mamelucos = $solicitud->epp_8;

            // Botas descartables
            $solicitud->botas_descartables = $solicitud->epp_5 + $solicitud->epp_8;

            // Botas de Goma
            $solicitud->botas_goma = 0;

            // Guantes Térmicos
            $solicitud->guantes_termicos = 0;

            // Lentes
            $solicitud->lentes = $solicitud->lentes;

            // Otros
            $solicitud->otros = 0;

            return $solicitud;
        })->toArray();

        $razon_soclal = "RED ASISTENCIAL LA LIBERTAD";
        $ipress = "HOSPITAL DE ALTA COMPLEJIDAD";
        $i = 0;
        foreach ($solicitudes as $solicitud) {
            $record = [
                @$razon_soclal,
                @$solicitud->user->username,
                @$solicitud->user->nombre_completo,
                @$ipress,
                @$solicitud->respiradores ?: "0",
                @$solicitud->mascarilla_quirurgica ?: "0",
                @$solicitud->lentes ?: "0",
                @$solicitud->mandilones ?: "0",
                @$solicitud->pantalones ?: "0",
                @$solicitud->caretas ?: "0",
                @$solicitud->guantes_quirurgicos ?: "0",
                @$solicitud->botas_descartables ?: "0",
                @$solicitud->gorros ?: "0",
                "0",
                @$solicitud->chaquetas ?: "0",
                @$solicitud->filtros ?: "0",
                @$solicitud->mamelucos ?: "0",
                @$solicitud->fecha_entrega_date
            ];
            $worksheet->fromArray($record, NULL, "A" . ($i + 10));
            $i++;
        }
        $lastRow = $count + 9;
        $formulas = [
            "=SUM(E10:E$lastRow)",
            "=SUM(F10:F$lastRow)",
            "=SUM(G10:G$lastRow)",
            "=SUM(H10:H$lastRow)",
            "=SUM(I10:I$lastRow)",
            "=SUM(J10:J$lastRow)",
            "=SUM(K10:K$lastRow)",
            "=SUM(L10:L$lastRow)",
            "=SUM(M10:M$lastRow)",
            "=SUM(N10:N$lastRow)",
            "=SUM(O10:O$lastRow)",
            "=SUM(P10:P$lastRow)",
            "=SUM(Q10:Q$lastRow)",
        ];
        $worksheet->fromArray($formulas, NULL, "E" . ($lastRow + 1));

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'reporte_' . date('Ymd');
        $response = $this->response;
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function reportCuadroResumenCsv()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');
        $fechaInicioFormated = new FrozenDate($fechaInicio);
        $fechaFinFormated = new FrozenDate($fechaFin);

        $query = $this->Solicitudes->find()
            ->where(["Solicitudes.estado_id" => 4]);

        if ($fechaInicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') >=" => $fechaInicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') <=" => $fechaFin]);
        }

        $query->select([
            'user_entrega_id',
            "fecha_entrega_date" => "DATE(fecha_entrega)",
            'Users.nombre_completo',
            'Users.username',
            'epp_0' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 0' THEN cantidad ELSE 0 END"),
            'epp_2' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 2' THEN cantidad ELSE 0 END"),
            'epp_5' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 5' THEN cantidad ELSE 0 END"),
            'epp_8' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 8' THEN cantidad ELSE 0 END"),
            'respiradores' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%RESPIRADOR%' THEN cantidad ELSE 0 END"),
            'n95' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%N95%' THEN cantidad ELSE 0 END"),
            'lentes' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%LENTES%' THEN cantidad ELSE 0 END"),
            'filtros' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%FILTROS%' THEN cantidad ELSE 0 END"),
        ])
            ->group(['user_entrega_id', "fecha_entrega_date"])
            ->order(['fecha_entrega_date'])
            ->contain(['Users']);

        $count = $query->count();

        $headers1 = [
            utf8_decode('RA/RP/OC/OD'),
            utf8_decode('DNI'),
            utf8_decode('RESPONSABLE DE ENTREGA DE EPP'),
            utf8_decode('IPRES RECEPTORA'),
            utf8_decode('RESPIRADORES'),
            utf8_decode('MASCARILLA QUIRURGICA'),
            utf8_decode('GAFAS PROTECTORAS'),
            utf8_decode('MANDILON DESCARTABLE'),
            utf8_decode('PANTALON DESCARTABLE'),
            utf8_decode('PROTECTOR FACIAL'),
            utf8_decode('GUANTES DESCARTABLES'),
            utf8_decode('PROTECTOR E CALZADO / BOTAS DESCARTABLES'),
            utf8_decode('GORRO DESCARTABLE'),
            utf8_decode('ALCOHOL EN GEL 1L.'),
            utf8_decode('CHAQUETAS'),
            utf8_decode('FILTROS'),
            utf8_decode('MAMELUCOS'),
            utf8_decode('FECHA DE ENTREGA DE EPP')
        ];

        $time = new Time();
        $timeText = $time->format('YmdHis');
        $file = TMP . 'reports' . DS . 'report-cuadro-resumen' . $timeText . '.csv';
        $csv = Writer::createFromPath($file, 'w+');
        $csv->setDelimiter('|');

        $csv->insertOne($headers1);
        $i = 1;
        for ($j = 0; $j <= $count; $j = $j + 1000) {
            $solicitudes = $query->limit(1000)->offset($j)->map(function ($solicitud) {
                // Gorros
                $solicitud->gorros = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Caretas
                $solicitud->caretas = $solicitud->epp_0 + $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Mascarilla Quirurgica
                $solicitud->mascarilla_quirurgica = ($solicitud->epp_0 * 50) + ($solicitud->epp_2 * 0) + ($solicitud->epp_5 * 1) + ($solicitud->epp_8 * 1);

                // Mascarilla N95
                $solicitud->mascarilla_n95 = $solicitud->n95;

                // Mascarilla KN95
                $solicitud->mascarilla_kn95 = 0;

                // Respiradores
                $solicitud->respiradores = $solicitud->respiradores;

                // Filtros
                $solicitud->filtros = $solicitud->filtros;

                // Guantes Quirurgicos
                $solicitud->guantes_quirurgicos = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Guantes Esteriles
                $solicitud->guantes_esteriles = 0;

                // Chaquetas
                $solicitud->chaquetas = $solicitud->epp_5 + $solicitud->epp_8;

                // Pantalones
                $solicitud->pantalones = $solicitud->epp_5 + $solicitud->epp_8;

                // Mandilones
                $solicitud->mandilones = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Mamelucos
                $solicitud->mamelucos = $solicitud->epp_8;

                // Botas descartables
                $solicitud->botas_descartables = $solicitud->epp_5 + $solicitud->epp_8;

                // Botas de Goma
                $solicitud->botas_goma = 0;

                // Guantes Térmicos
                $solicitud->guantes_termicos = 0;

                // Lentes
                $solicitud->lentes = $solicitud->lentes;

                // Otros
                $solicitud->otros = 0;

                return $solicitud;
            })->toArray();
            $razon_soclal = "RED ASISTENCIAL LA LIBERTAD";
            $ipress = "HOSPITAL DE ALTA COMPLEJIDAD";

            foreach ($solicitudes as $solicitud) {
                $record = [
                    @$razon_soclal,
                    @$solicitud->user->username,
                    @$solicitud->user->nombre_completo,
                    @$ipress,
                    @$solicitud->respiradores ?: "0",
                    @$solicitud->mascarilla_quirurgica ?: "0",
                    @$solicitud->lentes ?: "0",
                    @$solicitud->mandilones ?: "0",
                    @$solicitud->pantalones ?: "0",
                    @$solicitud->caretas ?: "0",
                    @$solicitud->guantes_quirurgicos ?: "0",
                    @$solicitud->botas_descartables ?: "0",
                    @$solicitud->gorros ?: "0",
                    "0",
                    @$solicitud->chaquetas ?: "0",
                    @$solicitud->filtros ?: "0",
                    @$solicitud->mamelucos ?: "0",
                    @$solicitud->fecha_entrega_date
                ];

                $csv->insertOne($record);
                $i++;
            }
            unset($solicitudes);
        }
        $response = $this->response->withFile(
            $file,
            ['download' => true, 'name' => 'report-cuadro-resumen' . $timeText . '.csv']
        );

        // Delete older files
        // 86400
        $currentFile = new File($file);
        $currentTimeStamp = $currentFile->lastChange();

        $folderToSearch = new Folder(TMP . 'reports');
        $fileNames = $folderToSearch->find();
        foreach ($fileNames as $fileName) {
            $fileIt = new File(TMP . 'reports' . DS . $fileName);
            if ($currentTimeStamp - $fileIt->lastChange() > 86400) {
                $fileIt->delete();
            }
        }
        return $response;
    }

    public function reportReporteSemanal()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');
        // $fechaInicioFormated = new FrozenDate($fechaInicio);
        // $fechaFinFormated = new FrozenDate($fechaFin);

        $query = $this->Solicitudes->find()
            ->where(["Solicitudes.estado_id" => 4]);

        if ($fechaInicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') >=" => $fechaInicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') <=" => $fechaFin]);
        }

        $query->select([
            'profesional',
            'programacion_dni_medico',
            'firma',
            'epp_0' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 0' THEN cantidad ELSE 0 END"),
            'epp_2' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 2' THEN cantidad ELSE 0 END"),
            'epp_5' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 5' THEN cantidad ELSE 0 END"),
            'epp_8' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 8' THEN cantidad ELSE 0 END"),
            'respiradores' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%RESPIRADOR%' THEN cantidad ELSE 0 END"),
            'n95' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%N95%' THEN cantidad ELSE 0 END"),
            'lentes' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%LENTES%' THEN cantidad ELSE 0 END"),
            'filtros' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%FILTROS%' THEN cantidad ELSE 0 END"),
        ])
            ->group(['profesional', 'programacion_dni_medico']);

        $spreadsheet = IOFactory::load(RESOURCES . 'reporte_semanal_template.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();

        $count = $query->count();

        $worksheet->getCell('N10')->setValue($count);

        $worksheet->insertNewRowBefore(17, $count);
        $worksheet->removeRow(16 + $count);

        $solicitudes = $query->map(function ($solicitud) {
            // Gorros
            $solicitud->gorros = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Caretas
            $solicitud->caretas = $solicitud->epp_0 + $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Mascarilla Quirurgica
            $solicitud->mascarilla_quirurgica = ($solicitud->epp_0 * 50) + ($solicitud->epp_2 * 0) + ($solicitud->epp_5 * 1) + ($solicitud->epp_8 * 1);

            // Mascarilla N95
            $solicitud->mascarilla_n95 = $solicitud->n95;

            // Mascarilla KN95
            $solicitud->mascarilla_kn95 = 0;

            // Respiradores
            $solicitud->respiradores = $solicitud->respiradores;

            // Filtros
            $solicitud->filtros = $solicitud->filtros;

            // Guantes Quirurgicos
            $solicitud->guantes_quirurgicos = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Guantes Esteriles
            $solicitud->guantes_esteriles = 0;

            // Chaquetas
            $solicitud->chaquetas = $solicitud->epp_5 + $solicitud->epp_8;

            // Pantalones
            $solicitud->pantalones = $solicitud->epp_5 + $solicitud->epp_8;

            // Mandilones
            $solicitud->mandilones = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Mamelucos
            $solicitud->mamelucos = $solicitud->epp_8;

            // Botas descartables
            $solicitud->botas_descartables = $solicitud->epp_5 + $solicitud->epp_8;

            // Botas de Goma
            $solicitud->botas_goma = 0;

            // Guantes Térmicos
            $solicitud->guantes_termicos = 0;

            // Lentes
            $solicitud->lentes = $solicitud->lentes;

            // Otros
            $solicitud->otros = 0;

            return $solicitud;
        })->toArray();

        $i = 0;
        foreach ($solicitudes as $solicitud) {
            if ($solicitud->firma) {
                // Resample image
                $orig = @imagecreatefrompng($solicitud->firma);
                if (!$orig) {
                    $target  = imagecreatetruecolor(90, 30);
                    $fondo = imagecolorallocate($target, 255, 255, 255);
                    $ct  = imagecolorallocate($target, 0, 0, 0);
                    imagefilledrectangle($target, 0, 0, 90, 30, $fondo);

                    Log::notice($solicitud->programacion_dni_medico, 'firmas');
                } else {
                    $imgWidth = imagesx($orig);
                    $imgHeight = imagesy($orig);

                    $target = imagecreatetruecolor($imgWidth, $imgHeight);

                    imagealphablending($target, false);
                    imagesavealpha($target, true);

                    imagecopyresampled($target, $orig, 0, 0, 0, 0, $imgWidth, $imgHeight, $imgWidth, $imgHeight);
                }

                $drawing = new MemoryDrawing();
                $drawing->setName($solicitud->programacion_dni_medico);
                $drawing->setDescription($solicitud->programacion_dni_medico);
                $drawing->setImageResource($target);
                $drawing->setRenderingFunction(MemoryDrawing::RENDERING_PNG);
                $drawing->setMimeType(MemoryDrawing::MIMETYPE_DEFAULT);
                $drawing->setCoordinates('Q' . ($i + 16));
                $drawing->setWidth(230);
                $drawing->setHeight(67);
                $drawing->setOffsetX(1);
                $drawing->setOffsetY(1);
                // $drawing->setOffsetX(110);
                // $drawing->setRotation(25);
                $drawing->getShadow()->setVisible(true);
                // $drawing->getShadow()->setDirection(45);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());
            }
            $record = [
                ($i + 1),
                @$solicitud->profesional,
                null,
                @$solicitud->programacion_dni_medico,
                @$solicitud->mascarilla_n95 ?: "0",
                @$solicitud->mascarilla_quirurgica ?: "0",
                @$solicitud->lentes ?: "0",
                @$solicitud->mandilones ?: "0",
                @$solicitud->caretas ?: "0",
                @$solicitud->guantes_quirurgicos ?: "0",
                @$solicitud->botas_descartables ?: "0",
                @$solicitud->mamelucos ?: "0",
                @$solicitud->respiradores ?: "0",
                @$solicitud->filtros ?: "0",
                @$solicitud->gorros ?: "0",
            ];
            $worksheet->fromArray($record, NULL, "B" . ($i + 16));
            $i++;
        }
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'reporte_' . date('Ymd');
        $response = $this->response;
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function reportReporteSemanalCsv()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');

        $query = $this->Solicitudes->find()
            ->where(["Solicitudes.estado_id" => 4]);

        if ($fechaInicio) {
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') >=" => $fechaInicio]);
            $query->where(["DATE_FORMAT(Solicitudes.fecha_entrega, '%Y-%m-%d') <=" => $fechaFin]);
        }

        $query->select([
            'profesional',
            'programacion_dni_medico',
            'firma',
            'epp_0' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 0' THEN cantidad ELSE 0 END"),
            'epp_2' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 2' THEN cantidad ELSE 0 END"),
            'epp_5' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 5' THEN cantidad ELSE 0 END"),
            'epp_8' => $query->func()->sum("CASE WHEN tipo_epp = 'EPP 8' THEN cantidad ELSE 0 END"),
            'respiradores' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%RESPIRADOR%' THEN cantidad ELSE 0 END"),
            'n95' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%N95%' THEN cantidad ELSE 0 END"),
            'lentes' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%LENTES%' THEN cantidad ELSE 0 END"),
            'filtros' => $query->func()->sum("CASE WHEN tipo_epp LIKE '%FILTROS%' THEN cantidad ELSE 0 END"),
        ])
            ->group(['profesional', 'programacion_dni_medico']);

        $count = $query->count();

        $headers1 = [
            utf8_decode('N°'), utf8_decode('APELLIDOS Y NOMBRES'), utf8_decode('DNI'), utf8_decode('RESPIRADOR N95'),
            utf8_decode('MACARILLA QUIRURGICA'), utf8_decode('GAFAS PROTECTORAS'), utf8_decode('MANDILON DESCARTABLE'),
            utf8_decode('PROTECTOR FACIAL'), utf8_decode('GUANTES DESCARTABLES'), utf8_decode('PROTECTOR E CALZADO / BOTAS DESCARTABLES'),
            utf8_decode('MAMELUCOS'), utf8_decode('RESPIRADORES'), utf8_decode('FILTROS'), utf8_decode('GORRO DESCARTABLE')
        ];

        $time = new Time();
        $timeText = $time->format('YmdHis');
        $file = TMP . 'reports' . DS . 'report-semanal' . $timeText . '.csv';
        $csv = Writer::createFromPath($file, 'w+');
        $csv->setDelimiter('|');

        $csv->insertOne($headers1);
        $i = 1;
        for ($j = 0; $j <= $count; $j = $j + 1000) {
            $solicitudes = $query->limit(1000)->offset($j)->map(function ($solicitud) {
                // Gorros
                $solicitud->gorros = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Caretas
                $solicitud->caretas = $solicitud->epp_0 + $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Mascarilla Quirurgica
                $solicitud->mascarilla_quirurgica = ($solicitud->epp_0 * 50) + ($solicitud->epp_2 * 0) + ($solicitud->epp_5 * 1) + ($solicitud->epp_8 * 1);

                // Mascarilla N95
                $solicitud->mascarilla_n95 = $solicitud->n95;

                // Mascarilla KN95
                $solicitud->mascarilla_kn95 = 0;

                // Respiradores
                $solicitud->respiradores = $solicitud->respiradores;

                // Filtros
                $solicitud->filtros = $solicitud->filtros;

                // Guantes Quirurgicos
                $solicitud->guantes_quirurgicos = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Guantes Esteriles
                $solicitud->guantes_esteriles = 0;

                // Chaquetas
                $solicitud->chaquetas = $solicitud->epp_5 + $solicitud->epp_8;

                // Pantalones
                $solicitud->pantalones = $solicitud->epp_5 + $solicitud->epp_8;

                // Mandilones
                $solicitud->mandilones = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Mamelucos
                $solicitud->mamelucos = $solicitud->epp_8;

                // Botas descartables
                $solicitud->botas_descartables = $solicitud->epp_5 + $solicitud->epp_8;

                // Botas de Goma
                $solicitud->botas_goma = 0;

                // Guantes Térmicos
                $solicitud->guantes_termicos = 0;

                // Lentes
                $solicitud->lentes = $solicitud->lentes;

                // Otros
                $solicitud->otros = 0;

                return $solicitud;
            })->toArray();

            foreach ($solicitudes as $solicitud) {
                $record = [
                    ($i + 1),
                    @$solicitud->profesional,
                    @$solicitud->programacion_dni_medico,
                    @$solicitud->mascarilla_n95 ?: "0",
                    @$solicitud->mascarilla_quirurgica ?: "0",
                    @$solicitud->lentes ?: "0",
                    @$solicitud->mandilones ?: "0",
                    @$solicitud->caretas ?: "0",
                    @$solicitud->guantes_quirurgicos ?: "0",
                    @$solicitud->botas_descartables ?: "0",
                    @$solicitud->mamelucos ?: "0",
                    @$solicitud->respiradores ?: "0",
                    @$solicitud->filtros ?: "0",
                    @$solicitud->gorros ?: "0",
                ];

                $csv->insertOne($record);
                $i++;
            }
            unset($solicitudes);
        }
        $response = $this->response->withFile(
            $file,
            ['download' => true, 'name' => 'report-semanal' . $timeText . '.csv']
        );

        // Delete older files
        // 86400
        $currentFile = new File($file);
        $currentTimeStamp = $currentFile->lastChange();

        $folderToSearch = new Folder(TMP . 'reports');
        $fileNames = $folderToSearch->find();
        foreach ($fileNames as $fileName) {
            $fileIt = new File(TMP . 'reports' . DS . $fileName);
            if ($currentTimeStamp - $fileIt->lastChange() > 86400) {
                $fileIt->delete();
            }
        }
        return $response;
    }

    public function reportCuadroResumenDiario()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');
        $fechaInicioFormated = new FrozenDate($fechaInicio);
        $fechaFinFormated = new FrozenDate($fechaFin);

        $cuadroResumenTable = TableRegistry::getTableLocator()->get('CuadroResumen');
        $query = $cuadroResumenTable->find();

        if ($fechaInicio) {
            $query->where(["DATE(CuadroResumen.fecha_entrega_date_solicitud) >=" => $fechaInicio]);
            $query->where(["DATE(CuadroResumen.fecha_entrega_date_solicitud) <=" => $fechaFin]);
        }

        $spreadsheet = IOFactory::load(RESOURCES . 'cuadro_resumen_diario_template.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->getCell('C1')->setValue("ENTREGA DE EPP DEL " . $fechaInicioFormated . " AL " . $fechaFinFormated);

        $count = $query->count();

        $spreadsheet->getActiveSheet()->insertNewRowBefore(11, $count);
        $spreadsheet->getActiveSheet()->removeRow(10 + $count);

        $solicitudes = $query->map(function ($solicitud) {
            // Gorros///////////////////////////
            $solicitud->gorros = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Caretas////////////////////////////////////////////////////
            $solicitud->caretas = $solicitud->epp_0 + $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Mascarilla Quirurgica//////////////////////////////////////
            $solicitud->mascarilla_quirurgica = ($solicitud->epp_0 * 50) + ($solicitud->epp_2 * 0) + ($solicitud->epp_5 * 1) + ($solicitud->epp_8 * 1);

            // Mascarilla N95
            $solicitud->mascarilla_n95 = $solicitud->n95;

            // Mascarilla KN95
            $solicitud->mascarilla_kn95 = 0;

            // Respiradores///////////////////////////////////////
            $solicitud->respiradores = $solicitud->respiradores;

            // Filtros/////////////////////////////////////////
            $solicitud->filtros = $solicitud->filtros;

            // Guantes Quirurgicos////////////////////////
            $solicitud->guantes_quirurgicos = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

            // Guantes Esteriles
            $solicitud->guantes_esteriles = 0;

            // Chaquetas de tela///////////////////////
            $solicitud->chaquetas_tela = $solicitud->chaquetas_tela;

            // Chaquetas descartables///////////////////
            $solicitud->chaquetas_descartables = ($solicitud->epp_5 + $solicitud->epp_8) - $solicitud->chaquetas_tela;

            // Pantalones de tela/////////////////////////
            $solicitud->pantalones_tela = $solicitud->pantalones_tela;

            // Pantalones descartables////////////////////
            $solicitud->pantalones_descartables = ($solicitud->epp_5 + $solicitud->epp_8) - $solicitud->pantalones_tela;

            // Mandilones de tela///////////////////////////////////
            $solicitud->mandilones_tela = $solicitud->mandilones_tela;

            // Mandilones descartables///////////////////////////
            $solicitud->mandilones_descartables = ($solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8) - $solicitud->mandilones_tela;

            // Mamelucos
            $solicitud->mamelucos = $solicitud->epp_8;

            // Botas descartables/////////////////////////////////
            $solicitud->botas_descartables = $solicitud->epp_5 + $solicitud->epp_8;

            // Botas de Goma
            $solicitud->botas_goma = 0;

            // Guantes Térmicos
            $solicitud->guantes_termicos = 0;

            // Lentes///////////////////////////////////////////////////////
            $solicitud->lentes = $solicitud->lentes;

            // Otros
            $solicitud->otros = 0;

            return $solicitud;
        })->toArray();

        $razon_soclal = "RED ASISTENCIAL LA LIBERTAD";
        $ipress = "HOSPITAL DE ALTA COMPLEJIDAD";
        $i = 0;
        foreach ($solicitudes as $solicitud) {
            $record = [
                @$razon_soclal,
                @$solicitud->username,
                @$solicitud->nombre_completo,
                @$ipress,
                @$solicitud->respiradores ?: "0",
                @$solicitud->mascarilla_n95 ?: "0",
                @$solicitud->mascarilla_quirurgica ?: "0",
                @$solicitud->lentes ?: "0",
                @$solicitud->mandilones_tela ?: "0",
                @$solicitud->mandilones_descartables ?: "0",
                @$solicitud->pantalones_tela ?: "0",
                @$solicitud->pantalones_descartables ?: "0",
                @$solicitud->chaquetas_tela ?: "0",
                @$solicitud->chaquetas_descartables ?: "0",
                @$solicitud->caretas ?: "0",
                @$solicitud->guantes_quirurgicos ?: "0",
                @$solicitud->botas_descartables ?: "0",
                @$solicitud->gorros ?: "0",
                @$solicitud->filtros ?: "0",
                "0",
                @$solicitud->mamelucos ?: "0",
                @$solicitud->fecha_entrega_date_solicitud
            ];
            $worksheet->fromArray($record, NULL, "A" . ($i + 10));
            $i++;
        }
        $lastRow = $count + 9;
        $formulas = [
            "=SUM(E10:E$lastRow)",
            "=SUM(F10:F$lastRow)",
            "=SUM(G10:G$lastRow)",
            "=SUM(H10:H$lastRow)",
            "=SUM(I10:I$lastRow)",
            "=SUM(J10:J$lastRow)",
            "=SUM(K10:K$lastRow)",
            "=SUM(L10:L$lastRow)",
            "=SUM(M10:M$lastRow)",
            "=SUM(N10:N$lastRow)",
            "=SUM(O10:O$lastRow)",
            "=SUM(P10:P$lastRow)",
            "=SUM(Q10:Q$lastRow)",
            "=SUM(R10:R$lastRow)",
            "=SUM(S10:S$lastRow)",
            "=SUM(T10:T$lastRow)",
            "=SUM(U10:U$lastRow)",
        ];
        $worksheet->fromArray($formulas, NULL, "E" . ($lastRow + 1));

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'reporte_diario' . date('Ymd');
        $response = $this->response;
        return $response->withType('xlsx')
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}.xlsx\"")
            ->withBody($stream);
    }

    public function reportCuadroResumenDiarioCsv()
    {
        $this->getRequest()->allowMethod("POST");
        $fechaInicio = $this->getRequest()->getData('fecha_inicio');
        $fechaFin = $this->getRequest()->getData('fecha_fin');
        $fechaInicioFormated = new FrozenDate($fechaInicio);
        $fechaFinFormated = new FrozenDate($fechaFin);

        $cuadroResumenTable = TableRegistry::getTableLocator()->get('CuadroResumen');
        $query = $cuadroResumenTable->find();

        if ($fechaInicio) {
            $query->where(["DATE(CuadroResumen.fecha_entrega_date_solicitud) >=" => $fechaInicio]);
            $query->where(["DATE(CuadroResumen.fecha_entrega_date_solicitud) <=" => $fechaFin]);
        }

        $count = $query->count();

        $headers1 = [
            utf8_decode('RA/RP/OC/OD'),
            utf8_decode('DNI'),
            utf8_decode('RESPONSABLE DE ENTREGA DE EPP'),
            utf8_decode('IPRES RECEPTORA'),
            utf8_decode('RESPIRADORES'),
            utf8_decode('MASCARILLA N95'),
            utf8_decode('MASCARILLA QUIRURGICA'),
            utf8_decode('GAFAS PROTECTORAS'),
            utf8_decode('MANDILON TELA'),
            utf8_decode('MANDILON DESCARTABLE'),
            utf8_decode('PANTALON TELA'),
            utf8_decode('PANTALON DESCARTABLE'),
            utf8_decode('CHAQUETAS TELA'),
            utf8_decode('CHAQUETAS DESCARTABLE'),
            utf8_decode('PROTECTOR FACIAL'),
            utf8_decode('GUANTES DESCARTABLES'),
            utf8_decode('PROTECTOR E CALZADO / BOTAS DESCARTABLES'),
            utf8_decode('GORRO DESCARTABLE'),
            utf8_decode('FILTROS'),
            utf8_decode('ALCOHOL EN GEL 1L.'),
            utf8_decode('MAMELUCO'),
            utf8_decode('FECHA DE ENTREGA DE EPP')
        ];

        $time = new Time();
        $timeText = $time->format('YmdHis');
        $file = TMP . 'reports' . DS . 'report-cuadro-resumen-diario' . $timeText . '.csv';
        $csv = Writer::createFromPath($file, 'w+');
        $csv->setDelimiter('|');

        $csv->insertOne($headers1);
        $i = 1;
        for ($j = 0; $j <= $count; $j = $j + 1000) {
            $solicitudes = $query->limit(1000)->offset($j)->map(function ($solicitud) {
                // Gorros///////////////////////////
                $solicitud->gorros = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Caretas////////////////////////////////////////////////////
                $solicitud->caretas = $solicitud->epp_0 + $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Mascarilla Quirurgica//////////////////////////////////////
                $solicitud->mascarilla_quirurgica = ($solicitud->epp_0 * 50) + ($solicitud->epp_2 * 0) + ($solicitud->epp_5 * 1) + ($solicitud->epp_8 * 1);

                // Mascarilla N95
                $solicitud->mascarilla_n95 = $solicitud->n95;

                // Mascarilla KN95
                $solicitud->mascarilla_kn95 = 0;

                // Respiradores///////////////////////////////////////
                $solicitud->respiradores = $solicitud->respiradores;

                // Filtros/////////////////////////////////////////
                $solicitud->filtros = $solicitud->filtros;

                // Guantes Quirurgicos////////////////////////
                $solicitud->guantes_quirurgicos = $solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8;

                // Guantes Esteriles
                $solicitud->guantes_esteriles = 0;

                // Chaquetas de tela///////////////////////
                $solicitud->chaquetas_tela = $solicitud->chaquetas_tela;

                // Chaquetas descartables///////////////////
                $solicitud->chaquetas_descartables = ($solicitud->epp_5 + $solicitud->epp_8) - $solicitud->chaquetas_tela;

                // Pantalones de tela/////////////////////////
                $solicitud->pantalones_tela = $solicitud->pantalones_tela;

                // Pantalones descartables////////////////////
                $solicitud->pantalones_descartables = ($solicitud->epp_5 + $solicitud->epp_8) - $solicitud->pantalones_tela;

                // Mandilones de tela///////////////////////////////////
                $solicitud->mandilones_tela = $solicitud->mandilones_tela;

                // Mandilones descartables///////////////////////////
                $solicitud->mandilones_descartables = ($solicitud->epp_2 + $solicitud->epp_5 + $solicitud->epp_8) - $solicitud->mandilones_tela;

                // Mamelucos
                $solicitud->mamelucos = $solicitud->epp_8;

                // Botas descartables/////////////////////////////////
                $solicitud->botas_descartables = $solicitud->epp_5 + $solicitud->epp_8;

                // Botas de Goma
                $solicitud->botas_goma = 0;

                // Guantes Térmicos
                $solicitud->guantes_termicos = 0;

                // Lentes///////////////////////////////////////////////////////
                $solicitud->lentes = $solicitud->lentes;

                // Otros
                $solicitud->otros = 0;

                return $solicitud;
            })->toArray();

            $razon_soclal = "RED ASISTENCIAL LA LIBERTAD";
            $ipress = "HOSPITAL DE ALTA COMPLEJIDAD";

            foreach ($solicitudes as $solicitud) {
                $record = [
                    @$razon_soclal,
                    @$solicitud->username,
                    @$solicitud->nombre_completo,
                    @$ipress,
                    @$solicitud->respiradores ?: "0",
                    @$solicitud->mascarilla_n95 ?: "0",
                    @$solicitud->mascarilla_quirurgica ?: "0",
                    @$solicitud->lentes ?: "0",
                    @$solicitud->mandilones_tela ?: "0",
                    @$solicitud->mandilones_descartables ?: "0",
                    @$solicitud->pantalones_tela ?: "0",
                    @$solicitud->pantalones_descartables ?: "0",
                    @$solicitud->chaquetas_tela ?: "0",
                    @$solicitud->chaquetas_descartables ?: "0",
                    @$solicitud->caretas ?: "0",
                    @$solicitud->guantes_quirurgicos ?: "0",
                    @$solicitud->botas_descartables ?: "0",
                    @$solicitud->gorros ?: "0",
                    @$solicitud->filtros ?: "0",
                    "0",
                    @$solicitud->mamelucos ?: "0",
                    @$solicitud->fecha_entrega_date_solicitud
                ];

                $csv->insertOne($record);
                $i++;
            }
            unset($solicitudes);
        }
        $response = $this->response->withFile(
            $file,
            ['download' => true, 'name' => 'report-cuadro-resumen-diario' . $timeText . '.csv']
        );

        // Delete older files
        // 86400
        $currentFile = new File($file);
        $currentTimeStamp = $currentFile->lastChange();

        $folderToSearch = new Folder(TMP . 'reports');
        $fileNames = $folderToSearch->find();
        foreach ($fileNames as $fileName) {
            $fileIt = new File(TMP . 'reports' . DS . $fileName);
            if ($currentTimeStamp - $fileIt->lastChange() > 86400) {
                $fileIt->delete();
            }
        }
        return $response;
    }
}
