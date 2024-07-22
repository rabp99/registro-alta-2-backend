<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuestionario $cuestionario
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cuestionario'), ['action' => 'edit', $cuestionario->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cuestionario'), ['action' => 'delete', $cuestionario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cuestionario->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cuestionarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cuestionario'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cuestionarios view content">
            <h3><?= h($cuestionario->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Programacion Centro') ?></th>
                    <td><?= h($cuestionario->programacion_centro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Programacion Dni Medico') ?></th>
                    <td><?= h($cuestionario->programacion_dni_medico) ?></td>
                </tr>
                <tr>
                    <th><?= __('Programacion Turno') ?></th>
                    <td><?= h($cuestionario->programacion_turno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supervisor Dni') ?></th>
                    <td><?= h($cuestionario->supervisor_dni) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supervisor Nombres') ?></th>
                    <td><?= h($cuestionario->supervisor_nombres) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cuestionario->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Programacion Fecha Programacion') ?></th>
                    <td><?= h($cuestionario->programacion_fecha_programacion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Hora') ?></th>
                    <td><?= h($cuestionario->fecha_hora) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
