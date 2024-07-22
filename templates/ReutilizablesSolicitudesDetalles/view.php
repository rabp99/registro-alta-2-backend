<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReutilizablesSolicitudesDetalle $reutilizablesSolicitudesDetalle
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Reutilizables Solicitudes Detalle'), ['action' => 'edit', $reutilizablesSolicitudesDetalle->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Reutilizables Solicitudes Detalle'), ['action' => 'delete', $reutilizablesSolicitudesDetalle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reutilizablesSolicitudesDetalle->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reutilizables Solicitudes Detalles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Reutilizables Solicitudes Detalle'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reutilizablesSolicitudesDetalles view content">
            <h3><?= h($reutilizablesSolicitudesDetalle->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Solicitude') ?></th>
                    <td><?= $reutilizablesSolicitudesDetalle->has('solicitude') ? $this->Html->link($reutilizablesSolicitudesDetalle->solicitude->id, ['controller' => 'Solicitudes', 'action' => 'view', $reutilizablesSolicitudesDetalle->solicitude->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Reutilizable') ?></th>
                    <td><?= $reutilizablesSolicitudesDetalle->has('reutilizable') ? $this->Html->link($reutilizablesSolicitudesDetalle->reutilizable->id, ['controller' => 'Reutilizables', 'action' => 'view', $reutilizablesSolicitudesDetalle->reutilizable->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $reutilizablesSolicitudesDetalle->has('estado') ? $this->Html->link($reutilizablesSolicitudesDetalle->estado->id, ['controller' => 'Estados', 'action' => 'view', $reutilizablesSolicitudesDetalle->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($reutilizablesSolicitudesDetalle->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha') ?></th>
                    <td><?= h($reutilizablesSolicitudesDetalle->fecha) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
