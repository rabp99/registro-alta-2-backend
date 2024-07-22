<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Programacione[]|\Cake\Collection\CollectionInterface $programaciones
 */
?>
<div class="programaciones index content">
    <?= $this->Html->link(__('New Programacione'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Programaciones') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('centro') ?></th>
                    <th><?= $this->Paginator->sort('periodo') ?></th>
                    <th><?= $this->Paginator->sort('area') ?></th>
                    <th><?= $this->Paginator->sort('servicio') ?></th>
                    <th><?= $this->Paginator->sort('actividad') ?></th>
                    <th><?= $this->Paginator->sort('subactividad') ?></th>
                    <th><?= $this->Paginator->sort('consultorio') ?></th>
                    <th><?= $this->Paginator->sort('ubicacionconsult') ?></th>
                    <th><?= $this->Paginator->sort('dni_medico') ?></th>
                    <th><?= $this->Paginator->sort('profesional') ?></th>
                    <th><?= $this->Paginator->sort('grupo_ocupacional') ?></th>
                    <th><?= $this->Paginator->sort('tip_programacion') ?></th>
                    <th><?= $this->Paginator->sort('fecha_programacion') ?></th>
                    <th><?= $this->Paginator->sort('hor_inicio') ?></th>
                    <th><?= $this->Paginator->sort('hor_fin') ?></th>
                    <th><?= $this->Paginator->sort('estado_programacion') ?></th>
                    <th><?= $this->Paginator->sort('motivo_suspension') ?></th>
                    <th><?= $this->Paginator->sort('cod_planilla') ?></th>
                    <th><?= $this->Paginator->sort('turno') ?></th>
                    <th><?= $this->Paginator->sort('condtrabajador') ?></th>
                    <th><?= $this->Paginator->sort('pertenece_otro_cas') ?></th>
                    <th><?= $this->Paginator->sort('area_ingreso') ?></th>
                    <th><?= $this->Paginator->sort('tipo_epp') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programaciones as $programacione): ?>
                <tr>
                    <td><?= h($programacione->centro) ?></td>
                    <td><?= h($programacione->periodo) ?></td>
                    <td><?= h($programacione->area) ?></td>
                    <td><?= h($programacione->servicio) ?></td>
                    <td><?= h($programacione->actividad) ?></td>
                    <td><?= h($programacione->subactividad) ?></td>
                    <td><?= h($programacione->consultorio) ?></td>
                    <td><?= h($programacione->ubicacionconsult) ?></td>
                    <td><?= h($programacione->dni_medico) ?></td>
                    <td><?= h($programacione->profesional) ?></td>
                    <td><?= h($programacione->grupo_ocupacional) ?></td>
                    <td><?= h($programacione->tip_programacion) ?></td>
                    <td><?= h($programacione->fecha_programacion) ?></td>
                    <td><?= h($programacione->hor_inicio) ?></td>
                    <td><?= h($programacione->hor_fin) ?></td>
                    <td><?= h($programacione->estado_programacion) ?></td>
                    <td><?= h($programacione->motivo_suspension) ?></td>
                    <td><?= h($programacione->cod_planilla) ?></td>
                    <td><?= h($programacione->turno) ?></td>
                    <td><?= h($programacione->condtrabajador) ?></td>
                    <td><?= h($programacione->pertenece_otro_cas) ?></td>
                    <td><?= h($programacione->area_ingreso) ?></td>
                    <td><?= h($programacione->tipo_epp) ?></td>
                    <td><?= $this->Number->format($programacione->cantidad) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $programacione->centro]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $programacione->centro]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $programacione->centro], ['confirm' => __('Are you sure you want to delete # {0}?', $programacione->centro)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
