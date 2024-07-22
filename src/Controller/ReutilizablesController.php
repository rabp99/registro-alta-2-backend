<?php
declare(strict_types=1);

namespace App\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Cake\Http\CallbackStream;

/**
 * Reutilizables Controller
 *
 * @property \App\Model\Table\ReutilizablesTable $Reutilizables
 * @method \App\Model\Entity\Reutilizable[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReutilizablesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tipos', 'Estados'],
        ];
        $reutilizables = $this->paginate($this->Reutilizables);

        $this->set(compact('reutilizables'));
    }

    /**
     * View method
     *
     * @param string|null $id Reutilizable id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reutilizable = $this->Reutilizables->get($id, [
            'contain' => ['Tipos', 'Estados'],
        ]);

        $this->set(compact('reutilizable'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reutilizable = $this->Reutilizables->newEmptyEntity();
        if ($this->request->is('post')) {
            $reutilizable = $this->Reutilizables->patchEntity($reutilizable, $this->request->getData());
            if ($this->Reutilizables->save($reutilizable)) {
                $this->Flash->success(__('The reutilizable has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reutilizable could not be saved. Please, try again.'));
        }
        $tipos = $this->Reutilizables->Tipos->find('list', ['limit' => 200]);
        $estados = $this->Reutilizables->Estados->find('list', ['limit' => 200]);
        $this->set(compact('reutilizable', 'tipos', 'estados'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reutilizable id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reutilizable = $this->Reutilizables->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reutilizable = $this->Reutilizables->patchEntity($reutilizable, $this->request->getData());
            if ($this->Reutilizables->save($reutilizable)) {
                $this->Flash->success(__('The reutilizable has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reutilizable could not be saved. Please, try again.'));
        }
        $tipos = $this->Reutilizables->Tipos->find('list', ['limit' => 200]);
        $estados = $this->Reutilizables->Estados->find('list', ['limit' => 200]);
        $this->set(compact('reutilizable', 'tipos', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reutilizable id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reutilizable = $this->Reutilizables->get($id);
        if ($this->Reutilizables->delete($reutilizable)) {
            $this->Flash->success(__('The reutilizable has been deleted.'));
        } else {
            $this->Flash->error(__('The reutilizable could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function liberar() {
        $this->getRequest()->allowMethod("POST");
        $codigos = $this->getRequest()->getData('codigos');
        
        try {
            $this->Reutilizables->getConnection()->begin();
            foreach ($codigos as $codigo) {
                $numeros = explode(",", $codigo["numeros"]);
                $this->Reutilizables->updateAll([
                    "estado_id" => 7
                ], [
                    'tipo_id' => $codigo["tipo_id"],
                    'codigo IN' => $numeros
                ]);
            }
            $message = 'Se liberó la indumentaria correctamente';
            $this->Reutilizables->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo liberar la indumentaria';
            $this->setResponse($this->response->withStatus(500));
            $this->Reutilizables->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    /**
     * Find En Vestidores method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function findEnLavanderia() {
        $reutilizables = $this->Reutilizables
            ->find()
            ->contain(["Tipos"])
            ->where([
                'Reutilizables.estado_id' => 13
            ])->order(['Reutilizables.codigo'])
            ->toArray();
        
        $this->set(compact("reutilizables"));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    public function registrarDevolucion() {
        $this->getRequest()->allowMethod("POST");
        $reutilizablesId = $this->getRequest()->getData('reutilizables_id');
        
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];
        
        try {
            $this->Reutilizables->getConnection()->begin();
            $this->Reutilizables->updateAll([
                "estado_id" => 7
            ], [
                'id IN' => $reutilizablesId
            ]);
                
            $this->Reutilizables->ReutilizablesSolicitudesDetalles->updateAll([
                "fecha_devolucion" => date('Y-m-d H:i:s'),
                "estado_id" => 9,
                "user_registro_devolucion_id" => $user_id
            ], [
                'reutilizable_id IN' => $reutilizablesId
            ]);
            
            $message = 'Se registró la devolución correctamente';
            $this->Reutilizables->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la devolución';
            $this->setResponse($this->response->withStatus(500));
            $this->Reutilizables->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    /**
     * Find En Vestidores method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function findEnVestidores() {
        $reutilizables = $this->Reutilizables
            ->find()
            ->contain(["Tipos"])
            ->where([
                'Reutilizables.estado_id' => 12
            ])->order(['Reutilizables.codigo'])
            ->toArray();
        
        $this->set(compact("reutilizables"));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    public function registrarEnLavanderia() {
        $this->getRequest()->allowMethod("POST");
        $reutilizablesId = $this->getRequest()->getData('reutilizables_id');
        
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];
        
        try {
            $this->Reutilizables->getConnection()->begin();
            $this->Reutilizables->updateAll([
                "estado_id" => 13
            ], [
                'id IN' => $reutilizablesId
            ]);
                
            $this->Reutilizables->ReutilizablesSolicitudesDetalles->updateAll([
                "fecha_lavanderia" => date('Y-m-d H:i:s'),
                "estado_id" => 13,
                "user_registro_lavanderia_id" => $user_id
            ], [
                'reutilizable_id IN' => $reutilizablesId
            ]);
            
            $message = 'Se registró la indumentaria en lavandería correctamente';
            $this->Reutilizables->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la indumentaria en lavandería';
            $this->setResponse($this->response->withStatus(500));
            $this->Reutilizables->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    public function lavanderiaRegularizar() {
        $this->getRequest()->allowMethod("POST");
        $codigos = $this->getRequest()->getData('codigos');
        
        $result = $this->Authentication->getResult();
        $user_id = $result->getData()["id"];
        
        try {
            $this->Reutilizables->getConnection()->begin();
            foreach ($codigos as $codigo) {
                $numeros = explode(",", $codigo["numeros"]);
                $this->Reutilizables->updateAll([
                    "estado_id" => 13
                ], [
                    'tipo_id' => $codigo["tipo_id"],
                    'codigo IN' => $numeros
                ]);
                // ahora los detalles
                $reutilizablesId = $this->Reutilizables->find()
                    ->where([
                        'Reutilizables.tipo_id' => $codigo["tipo_id"],
                        'Reutilizables.codigo IN' => $numeros
                    ])
                    ->map(function ($row) {
                        return $row->id;
                    })
                    ->toArray();
                    
                if (!empty($reutilizablesId)) {
                    $this->Reutilizables->ReutilizablesSolicitudesDetalles->updateAll([
                        "fecha_lavanderia" => date('Y-m-d H:i:s'),
                        "estado_id" => 13,
                        "user_registro_lavanderia_id" => $user_id
                    ], [
                        'reutilizable_id IN' => $reutilizablesId,
                        'estado_id IN' => [4, 12]
                    ]);
                }
            }
            
            $message = 'Se registró la indumentaria en lavandería correctamente';
            $this->Reutilizables->getConnection()->commit();
        } catch (Exception $ex) {
            $message = 'No se pudo registrar la indumentaria en lavandería';
            $this->setResponse($this->response->withStatus(500));
            $this->Reutilizables->getConnection()->rollback();
        } finally {
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', true);
        }
    }
    
    public function report() {
        $this->getRequest()->allowMethod("GET");
        $tipo_id = $this->getRequest()->getQuery('tipo_id');
        $estado_id = $this->getRequest()->getQuery('estado_id');
        $codigo = $this->getRequest()->getQuery('codigo');
        $itemsPerPage = $this->getRequest()->getQuery('itemsPerPage');
        $page = $this->getRequest()->getQuery('page');
           
        $query = $this->Reutilizables->find()
            ->contain(['Estados', 'Tipos', 'ReutilizablesSolicitudesDetalles' => function ($q) {
                return $q
                    ->contain(['Solicitudes'])
                    ->where(['ReutilizablesSolicitudesDetalles.estado_id IN' => [4, 12, 13]])
                    ->order(['ReutilizablesSolicitudesDetalles.fecha_entrega' => 'DESC']);
            }]);
        
        if ($tipo_id) {
            $query->where(["Reutilizables.tipo_id" => $tipo_id]);
        }
        
        if ($estado_id) {
            $query->where(["Reutilizables.estado_id" => $estado_id]);
        }
        
        if ($codigo) {
            $query->where(["Reutilizables.codigo" => $codigo]);
        }
                  
        $count = $query->count();
        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }
        $reutilizables = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);
        $paginate = $this->request->getAttribute('paging')['Reutilizables'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage'],
            'page' => $page
        ];
        
        $this->set(compact('reutilizables', 'pagination', 'count'));
        $this->viewBuilder()->setOption('serialize', true);
    }
    
    public function exportExcel() {
        $this->getRequest()->allowMethod("POST");
        $tipo_id = $this->getRequest()->getData('tipo_id');
        $estado_id = $this->getRequest()->getData('estado_id');
        $codigo = $this->getRequest()->getData('codigo');
                
        $query = $this->Reutilizables->find()
            ->contain(['Estados', 'Tipos', 'ReutilizablesSolicitudesDetalles' => function ($q) {
                return $q
                    ->contain(['Solicitudes'])
                    ->where(['ReutilizablesSolicitudesDetalles.estado_id IN' => [4, 12, 13]])
                    ->order(['ReutilizablesSolicitudesDetalles.fecha_entrega' => 'DESC']);
            }]);
        
        if ($tipo_id) {
            $query->where(["Reutilizables.tipo_id" => $tipo_id]);
        }
        
        if ($estado_id) {
            $query->where(["Reutilizables.estado_id" => $estado_id]);
        }
        
        if ($codigo) {
            $query->where(["Reutilizables.codigo" => $codigo]);
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
        $spreadsheet->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true)->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('A2:G2')
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
        
        $spreadsheet->getActiveSheet()->mergeCells("E1:G1");
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'Reporte de Indumentaria');
        $spreadsheet->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('E1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('E1')->getFont()->setBold(true)->setItalic(true)->setSize(18);
        
        $count = $query->count();
        $reutilizables = $query->toArray();
        
        $spreadsheet->getActiveSheet()->getStyle('A3:G' . (2 + $count))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A3:G' . (2 + $count))->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A3:G' . (2 + $count))->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A3:A' . (2 + $count))->getFont()->setBold(true);
        
        for ($k = 1; $k <= $count; $k++) {
            $spreadsheet->getActiveSheet()->getRowDimension(strval($k + 2))->setRowHeight(16);
        }
        
        $spreadsheet->getActiveSheet()->getStyle('A3:G' . (2 + $count))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        
        $headers = ['ÍTEM', utf8_decode('TIPO'), 'N°', utf8_decode('ESTADO'), 'ÚLTIMA SOLICITUD', utf8_decode('NRO. DOCUMENTO'), utf8_decode('PROFESIONAL')];

        $sheet->fromArray($headers, NULL, "A2");
        $i = 2;
        foreach ($reutilizables as $reutilizable) {
            $ultima_solicitud = '';
            if (@$reutilizable->reutilizables_solicitudes_detalles[0]) {
                $ultima_solicitud = $reutilizable->reutilizables_solicitudes_detalles[0]->fecha_entrega->i18nFormat();
            }
            $record = [
                $i - 1,
                @$reutilizable->tipo->descripcion,
                @$reutilizable->codigo,
                @$reutilizable->estado->descripcion,
                @$ultima_solicitud,
                @$reutilizable->reutilizables_solicitudes_detalles[0]->dni_medico,
                @$reutilizable->reutilizables_solicitudes_detalles[0]->solicitud->profesional,
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
    
    public function reportHistorial() {
        $this->getRequest()->allowMethod("POST");
        $reutilizable_id = $this->getRequest()->getData('reutilizable_id');
        
        $reutilizable = $this->Reutilizables->find()
            ->where(['Reutilizables.id' => $reutilizable_id])
            ->contain([
                'ReutilizablesSolicitudesDetalles' => [
                    'Solicitudes', 'EntregaUsers', 'VestuarioUsers', 'LavanderiaUsers', 'DevolucionUsers'
                ], 'Tipos'                
            ])
            ->first();
        
        $headers = ['ÍTEM', utf8_decode('ESTADO'), utf8_decode('FECHA'), utf8_decode('NRO. DOCUMENTO'), utf8_decode('TRABAJADOR'), utf8_decode('USUARIO QUE REALIZA EL REGISTRO')];
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->mergeCells("D1:F1");
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Historial de Indumentaria');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->setBold(true)->setItalic(true)->setSize(18);
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
        
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        
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
        $spreadsheet->getActiveSheet()->setCellValue('A3', $reutilizable->tipo->descripcion . " N° " . $reutilizable->codigo);
        
        $spreadsheet->getActiveSheet()->getRowDimension(5)->setRowHeight(40);
        $spreadsheet->getActiveSheet()->getStyle("A5:F5")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle("A5:F5")->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle("A5:F5")->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle("A5:F5")->getFont()->setBold(true)->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle("A5:F5")
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('42BEFF');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($headers, NULL, "A5");
        
        $padding = 4;
        $i = $padding;
        foreach ($reutilizable->reutilizables_solicitudes_detalles as $reutilizablesSolicitudesDetalle) {
            if ($reutilizablesSolicitudesDetalle->fecha_entrega) {
                $record = [
                    $i - ($padding - 1),
                    'ENTREGADO',
                    @$reutilizablesSolicitudesDetalle->fecha_entrega->i18nFormat(),
                    @$reutilizablesSolicitudesDetalle->solicitud->programacion_dni_medico,
                    @$reutilizablesSolicitudesDetalle->solicitud->profesional,
                    @$reutilizablesSolicitudesDetalle->entrega_user->nombre_completo,
                ];
                $sheet->fromArray($record, NULL, "A" . ($i + 2));
                $i++;
            }
            if ($reutilizablesSolicitudesDetalle->fecha_vestuario) {
                $record = [
                    $i - ($padding - 1),
                    'EN VESTIDORES',
                    @$reutilizablesSolicitudesDetalle->fecha_vestuario->i18nFormat(),
                    @$reutilizablesSolicitudesDetalle->solicitud->programacion_dni_medico,
                    @$reutilizablesSolicitudesDetalle->solicitud->profesional,
                    @$reutilizablesSolicitudesDetalle->vestuario_user->nombre_completo,
                ];
                $sheet->fromArray($record, NULL, "A" . ($i + 2));
                $i++;
            }
            if ($reutilizablesSolicitudesDetalle->fecha_lavanderia) {
                $record = [
                    $i - ($padding - 1),
                    'EN LAVANDERÍA',
                    @$reutilizablesSolicitudesDetalle->fecha_lavanderia->i18nFormat(),
                    @$reutilizablesSolicitudesDetalle->solicitud->programacion_dni_medico,
                    @$reutilizablesSolicitudesDetalle->solicitud->profesional,
                    @$reutilizablesSolicitudesDetalle->lavanderia_user->nombre_completo,
                ];
                $sheet->fromArray($record, NULL, "A" . ($i + 2));
                $i++;
            }
            if ($reutilizablesSolicitudesDetalle->fecha_devolucion) {
                $record = [
                    $i - ($padding - 1),
                    'DEVUELTO',
                    @$reutilizablesSolicitudesDetalle->fecha_devolucion->i18nFormat(),
                    @$reutilizablesSolicitudesDetalle->solicitud->programacion_dni_medico,
                    @$reutilizablesSolicitudesDetalle->solicitud->profesional,
                    @$reutilizablesSolicitudesDetalle->devolucion_user->nombre_completo,
                ];
                $sheet->fromArray($record, NULL, "A" . ($i + 2));
                $i++;
            }
        }
                
        $spreadsheet->getActiveSheet()->getStyle('A6:F' . (1 + $i))->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A6:F' . (1 + $i))->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A6:F' . (1 + $i))->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A6:A' . (1 + $i))->getFont()->setBold(true);
                
        for ($k = 1; $k < $i; $k++) {
            $spreadsheet->getActiveSheet()->getRowDimension(strval($k + 5))->setRowHeight(16);
        }
        
        $spreadsheet->getActiveSheet()->getStyle('A6:F' . (1 + $i))
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
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