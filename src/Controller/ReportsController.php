<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Cake\Core\Configure;

/**
 * Reports Controller
 *
 * 
 * @property \App\Model\Table\ProductsTable $Products
 * @property \App\Model\Table\WorkersTable $Workers
 */
class ReportsController extends AppController
{
    /**
     * Get Product Request Records Data method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function getProductRequestRecordsData()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $workerDocumentType = $this->getRequest()->getParam("worker_document_type");
        $workerDocumentNumber = $this->getRequest()->getParam("worker_document_number");
        $startDate = $this->getRequest()->getParam("start_date");
        $endDate = $this->getRequest()->getParam("end_date");
        $itemsPerPage = $this->request->getQuery('itemsPerPage');

        $this->loadModel('Products');
        $this->loadModel('ProductRequests');

        $products = $this->Products->findListByStatus(true)->toArray();

        $query = $this->ProductRequests->find();

        $query->select([
            'ProductRequests.year',
            'ProductRequests.number',
            'attention_date' => $query->func()->date(['ProductRequests.attention_date' => 'identifier']),
            'work_area_description' => 'WorkAreas.description',
        ])->where([
            "ProductRequests.document_type" => $workerDocumentType,
            "ProductRequests.document_number" => $workerDocumentNumber,
        ]);

        if (!empty($startDate) && !empty($endDate)) {
            $query->andWhere(function ($exp, $query) use ($startDate, $endDate) {
                return $exp->between(
                    $query->func()->date(['ProductRequests.attention_date' => 'identifier']),
                    $startDate,
                    $endDate
                );
            });
        }

        $query->innerJoinWith('WorkAreaDetails', function ($q) {
            return $q->innerJoinWith('WorkAreas');
        });

        $query->innerJoinWith('KitsProductRequests', function ($q) {
            return $q->innerJoinWith('ProductRequestDetails', function ($q) {
                return $q->innerJoinWith('Products');
            });
        });

        $query
            ->order(['ProductRequests.year' => 'ASC', 'ProductRequests.number' => 'ASC'])
            ->group(['ProductRequests.year', 'ProductRequests.number']);

        foreach ($products as $productId => $productDescription) {
            $query->select([
                "product$productId" => $query->func()->coalesce([
                    $query->func()->sum(
                        $query->newExpr()->addCase(
                            [
                                $query->newExpr()->eq('ProductRequestDetails.product_id', $productId)
                            ],
                            [
                                $query->newExpr()->add([
                                    'KitsProductRequests.amount * ProductRequestDetails.amount'
                                ])
                            ],
                            ['integer']
                        )
                    ),
                    0
                ])
            ]);
        }

        $count = $query->count();

        if (!$itemsPerPage) {
            $itemsPerPage = $count;
        }

        $records = $this->paginate($query, [
            'limit' => $itemsPerPage
        ]);

        $paginate = $this->getRequest()->getAttribute('paging')['ProductRequests'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];

        $records = $records->map(function ($record) {
            return  $record->setHidden(['code']);
        });

        $delayResponsesStatus = Configure::read('DelayResponses.status');
        if ($delayResponsesStatus) {
            $delayTime = Configure::read('DelayResponses.time');
            sleep($delayTime);
        }

        $this->set(compact('records', 'products', 'pagination', 'count'));
    }

    /**
     * Get Product Request Records File method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function getProductRequestRecordsFile()
    {
        $this->getRequest()->allowMethod("GET");
        $this->viewBuilder()->setOption('serialize', true);

        $workerDocumentType = $this->getRequest()->getParam("worker_document_type");
        $workerDocumentNumber = $this->getRequest()->getParam("worker_document_number");
        $startDate = $this->getRequest()->getParam("start_date");
        $endDate = $this->getRequest()->getParam("end_date");

        $this->loadModel('Workers');
        $this->loadModel('Products');
        $this->loadModel('ProductRequests');
        $this->loadModel('Parameters');

        $worker = $this->Workers->get([$workerDocumentType, $workerDocumentNumber], [
            "contain" => ["WorkerOccupationalGroups"]
        ]);
        $workerCount = $this->Workers->find()->count();
        $products = $this->Products->findListByStatus(true)->toArray();

        $query = $this->ProductRequests->find();

        $query->select([
            'ProductRequests.year',
            'ProductRequests.number',
            'attention_date' => $query->func()->date(['ProductRequests.attention_date' => 'identifier']),
            'work_area_description' => 'WorkAreas.description',
            'signature_path'
        ])->where([
            "ProductRequests.document_type" => $workerDocumentType,
            "ProductRequests.document_number" => $workerDocumentNumber,
        ]);

        if (!empty($startDate) && !empty($endDate)) {
            $query->andWhere(function ($exp, $query) use ($startDate, $endDate) {
                return $exp->between(
                    $query->func()->date(['ProductRequests.attention_date' => 'identifier']),
                    $startDate,
                    $endDate
                );
            });
        }

        $query->innerJoinWith('WorkAreaDetails', function ($q) {
            return $q->innerJoinWith('WorkAreas');
        });

        $query->innerJoinWith('KitsProductRequests', function ($q) {
            return $q->innerJoinWith('ProductRequestDetails', function ($q) {
                return $q->innerJoinWith('Products');
            });
        });

        $query
            ->order(['ProductRequests.year' => 'ASC', 'ProductRequests.number' => 'ASC'])
            ->group(['ProductRequests.year', 'ProductRequests.number']);

        foreach ($products as $productId => $productDescription) {
            $query->select([
                "product$productId" => $query->func()->coalesce([
                    $query->func()->sum(
                        $query->newExpr()->addCase(
                            [
                                $query->newExpr()->eq('ProductRequestDetails.product_id', $productId)
                            ],
                            [
                                $query->newExpr()->add([
                                    'KitsProductRequests.amount * ProductRequestDetails.amount'
                                ])
                            ],
                            ['integer']
                        )
                    ),
                    0
                ])
            ]);
        }

        $count = $query->count();
        if ($count === 0) {
            throw new Exception("No es encontraron registros.");
        }
        $records = $query->all();

        $responsibleFullName = $this->Parameters->find()
            ->where(['Parameters.key' => 'responsible.full_name'])
            ->first()
            ->get('value');

        $responsibleJobPosition = $this->Parameters->find()
            ->where(['Parameters.key' => 'responsible.job_position'])
            ->first()
            ->get('value');

        $responsibleSignature = $this->Parameters->find()
            ->where(['Parameters.key' => 'responsible.signature'])
            ->first()
            ->get('value');

        $userTrackable = $this->getRequest()->getAttribute('identity');

        $reportProductRequestsRecordNumber = $this->Parameters->getNextReportProductRequestsRecordNunber($userTrackable->getIdentifier());

        $spreadsheet = IOFactory::load(RESOURCES . 'registro-epp.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue("D7", $worker->full_name);
        $sheet->setCellValue("H6", $worker->document_type);
        $sheet->setCellValue("J6", $worker->document_number);
        $sheet->setCellValue("J7", $worker->worker_occupational_group->description);
        $sheet->setCellValue("L4", $workerCount);
        $sheet->setCellValue("L3", $reportProductRequestsRecordNumber);

        $defaultHeaderColumnSize = 8;
        $signatureColumn = "L";

        $diff = count($products) - $defaultHeaderColumnSize;

        if ($diff > 0) {
            $signatureColumn = chr(ord($signatureColumn) + $diff);
            $sheet->insertNewColumnBefore('L', $diff);
        }

        if ($count > 1) {
            $sheet->insertNewRowBefore(10, $count - 1);
        }

        foreach ($records as $key => $record) {
            $data = [
                $key + 1,
                $record->attention_date->format('d/m/Y'),
                $record->work_area_description
            ];

            foreach ($products as $productId => $productDescription) {
                $productColumnValue = 'product' . $productId;
                $data[] = $record->$productColumnValue;
            }

            $sheet->fromArray($data, null, "A" . (9 + $key));

            if ($record->signature_path) {
                $drawing = new Drawing();
                $drawing->setPath(STORAGE_PATH . $record->signature_path);
                $drawing->setWidth(240);
                $drawing->setHeight(65);
                $drawing->setOffsetX(24);
                $drawing->setOffsetY(1);
                $drawing->setCoordinates($signatureColumn . (9 + $key));
                $drawing->setWorksheet($sheet);
            }

            if ($diff < 0) {
                $column = chr(ord("J") + ($diff + 1));
                $sheet->mergeCells($column . (9 + $key) . ':K' . (9 + $key));
            }
        }

        if ($diff < 0) {
            $column = chr(ord("J") + ($diff + 1));
            $sheet->mergeCells($column . '8:K8');
        }

        $sheet->fromArray($products, null, "D8");
        $sheet->getRowDimension(8)->setRowHeight(-1);

        if ($diff < 0) {
            $colWidth = 16 / (($diff * -1) + 1);
            foreach (range($column, 'K') as $col) {
                $sheet->getColumnDimension($col)->setWidth($colWidth);
            }
        } else {
            $lastColumn = chr(ord("J") + $diff + 1);
            foreach (range('D', $lastColumn) as $col) {
                $sheet->getColumnDimension($col)->setWidth(16);
            }
        }

        $sheet->setCellValue("D" . (12 + $count - 1), $responsibleFullName);
        $sheet->setCellValue("D" . (13 + $count - 1), $responsibleJobPosition);

        if ($responsibleSignature) {
            $drawing = new Drawing();
            $drawing->setPath(STORAGE_PATH . $responsibleSignature);
            $drawing->setWidth(240);
            $drawing->setHeight(65);
            $drawing->setOffsetX(64);
            $drawing->setOffsetY(1);
            $drawing->setCoordinates("J" . (12 + $count - 1));
            $drawing->setWorksheet($sheet);
        }

        $filename = 'Reporte de Registro de Entrega - ' . date('d-m-Y') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $response = $this->getResponse()->withType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        $delayResponsesStatus = Configure::read('DelayResponses.status');
        if ($delayResponsesStatus) {
            $delayTime = Configure::read('DelayResponses.time');
            sleep($delayTime);
        }

        return $response->withStringBody($excelOutput);
    }
}
