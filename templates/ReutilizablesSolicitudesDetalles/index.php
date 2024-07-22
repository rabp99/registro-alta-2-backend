<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReutilizablesSolicitudesDetalle[]|\Cake\Collection\CollectionInterface $reutilizablesSolicitudesDetalles
 */
?>
<div class="reutilizablesSolicitudesDetalles index content">
    <?= $this->Html->link(__('New Reutilizables Solicitudes Detalle'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reutilizables Solicitudes Detalles') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('solicitud_id') ?></th>
                    <th><?= $this->Paginator->sort('reutilizable_id') ?></th>
                    <th><?= $this->Paginator->sort('fecha') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reutilizablesSolicitudesDetalles as $reutilizablesSolicitudesDetalle): ?>
                <tr>
                    <td><?= $this->Number->format($reutilizablesSolicitudesDetalle->id) ?></td>
                    <td><?= $reutilizablesSolicitudesDetalle->has('solicitude') ? $this->Html->link($reutilizablesSolicitudesDetalle->solicitude->id, ['controller' => 'Solicitudes', 'action' => 'view', $reutilizablesSolicitudesDetalle->solicitude->id]) : '' ?></td>
                    <td><?= $reutilizablesSolicitudesDetalle->has('reutilizable') ? $this->Html->link($reutilizablesSolicitudesDetalle->reutilizable->id, ['controller' => 'Reutilizables', 'action' => 'view', $reutilizablesSolicitudesDetalle->reutilizable->id]) : '' ?></td>
                    <td><?= h($reutilizablesSolicitudesDetalle->fecha) ?></td>
                    <td><?= $reutilizablesSolicitudesDetalle->has('estado') ? $this->Html->link($reutilizablesSolicitudesDetalle->estado->id, ['controller' => 'Estados', 'action' => 'view', $reutilizablesSolicitudesDetalle->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $reutilizablesSolicitudesDetalle->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reutilizablesSolicitudesDetalle->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reutilizablesSolicitudesDetalle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reutilizablesSolicitudesDetalle->id)]) ?>
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
