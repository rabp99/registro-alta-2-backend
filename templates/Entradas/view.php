<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entrada $entrada
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Entrada'), ['action' => 'edit', $entrada->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Entrada'), ['action' => 'delete', $entrada->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entrada->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Entradas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Entrada'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="entradas view content">
            <h3><?= h($entrada->fecha_hora) ?></h3>
            <table>
                <tr>
                    <th><?= __('Trabajador') ?></th>
                    <td><?= $entrada->has('trabajador') ? $this->Html->link($entrada->trabajador->dni, ['controller' => 'Trabajadores', 'action' => 'view', $entrada->trabajador->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $entrada->has('user') ? $this->Html->link($entrada->user->id, ['controller' => 'Users', 'action' => 'view', $entrada->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= $entrada->has('area') ? $this->Html->link($entrada->area->id, ['controller' => 'Areas', 'action' => 'view', $entrada->area->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $entrada->has('estado') ? $this->Html->link($entrada->estado->id, ['controller' => 'Estados', 'action' => 'view', $entrada->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($entrada->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Hora') ?></th>
                    <td><?= h($entrada->fecha_hora) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
