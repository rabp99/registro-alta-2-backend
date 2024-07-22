<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Solicitude $solicitude
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Solicitude'), ['action' => 'edit', $solicitude->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Solicitude'), ['action' => 'delete', $solicitude->id], ['confirm' => __('Are you sure you want to delete # {0}?', $solicitude->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Solicitudes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Solicitude'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="solicitudes view content">
            <h3><?= h($solicitude->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Programaciones Centro') ?></th>
                    <td><?= h($solicitude->programaciones_centro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Programacione') ?></th>
                    <td><?= $solicitude->has('programacione') ? $this->Html->link($solicitude->programacione->centro, ['controller' => 'Programaciones', 'action' => 'view', $solicitude->programacione->centro]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Programaciones Turno') ?></th>
                    <td><?= h($solicitude->programaciones_turno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area Ingreso') ?></th>
                    <td><?= h($solicitude->area_ingreso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Epp') ?></th>
                    <td><?= h($solicitude->tipo_epp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $solicitude->has('estado') ? $this->Html->link($solicitude->estado->id, ['controller' => 'Estados', 'action' => 'view', $solicitude->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($solicitude->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($solicitude->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Programaciones Fecha Programacion') ?></th>
                    <td><?= h($solicitude->programaciones_fecha_programacion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Solicitud') ?></th>
                    <td><?= h($solicitude->fecha_solicitud) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Entrega') ?></th>
                    <td><?= h($solicitude->fecha_entrega) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Firma') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($solicitude->firma)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
