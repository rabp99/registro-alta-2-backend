<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salida $salida
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Salida'), ['action' => 'edit', $salida->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Salida'), ['action' => 'delete', $salida->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salida->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Salidas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Salida'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salidas view content">
            <h3><?= h($salida->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Trabajador') ?></th>
                    <td><?= $salida->has('trabajador') ? $this->Html->link($salida->trabajador->dni, ['controller' => 'Trabajadores', 'action' => 'view', $salida->trabajador->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $salida->has('estado') ? $this->Html->link($salida->estado->id, ['controller' => 'Estados', 'action' => 'view', $salida->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($salida->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($salida->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Hora') ?></th>
                    <td><?= h($salida->fecha_hora) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
