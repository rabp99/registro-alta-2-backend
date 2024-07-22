<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistorialConsumible $historialConsumible
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Historial Consumible'), ['action' => 'edit', $historialConsumible->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Historial Consumible'), ['action' => 'delete', $historialConsumible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historialConsumible->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Historial Consumibles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Historial Consumible'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="historialConsumibles view content">
            <h3><?= h($historialConsumible->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Consumible') ?></th>
                    <td><?= $historialConsumible->has('consumible') ? $this->Html->link($historialConsumible->consumible->descripcion, ['controller' => 'Consumibles', 'action' => 'view', $historialConsumible->consumible->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= h($historialConsumible->tipo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entrega') ?></th>
                    <td><?= $historialConsumible->has('entrega') ? $this->Html->link($historialConsumible->entrega->fecha, ['controller' => 'Entregas', 'action' => 'view', $historialConsumible->entrega->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($historialConsumible->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($historialConsumible->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha') ?></th>
                    <td><?= h($historialConsumible->fecha) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
