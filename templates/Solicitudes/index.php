<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Solicitude[]|\Cake\Collection\CollectionInterface $solicitudes
 */
?>
<div class="solicitudes index content">
    <?= $this->Html->link(__('New Solicitude'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Solicitudes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('programaciones_centro') ?></th>
                    <th><?= $this->Paginator->sort('programaciones_trabajador_id') ?></th>
                    <th><?= $this->Paginator->sort('programaciones_fecha_programacion') ?></th>
                    <th><?= $this->Paginator->sort('programaciones_turno') ?></th>
                    <th><?= $this->Paginator->sort('area_ingreso') ?></th>
                    <th><?= $this->Paginator->sort('tipo_epp') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('fecha_solicitud') ?></th>
                    <th><?= $this->Paginator->sort('fecha_entrega') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($solicitudes as $solicitude): ?>
                <tr>
                    <td><?= $this->Number->format($solicitude->id) ?></td>
                    <td><?= h($solicitude->programaciones_centro) ?></td>
                    <td><?= $solicitude->has('programacione') ? $this->Html->link($solicitude->programacione->centro, ['controller' => 'Programaciones', 'action' => 'view', $solicitude->programacione->centro]) : '' ?></td>
                    <td><?= h($solicitude->programaciones_fecha_programacion) ?></td>
                    <td><?= h($solicitude->programaciones_turno) ?></td>
                    <td><?= h($solicitude->area_ingreso) ?></td>
                    <td><?= h($solicitude->tipo_epp) ?></td>
                    <td><?= $this->Number->format($solicitude->cantidad) ?></td>
                    <td><?= h($solicitude->fecha_solicitud) ?></td>
                    <td><?= h($solicitude->fecha_entrega) ?></td>
                    <td><?= $solicitude->has('estado') ? $this->Html->link($solicitude->estado->id, ['controller' => 'Estados', 'action' => 'view', $solicitude->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $solicitude->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $solicitude->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $solicitude->id], ['confirm' => __('Are you sure you want to delete # {0}?', $solicitude->id)]) ?>
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
