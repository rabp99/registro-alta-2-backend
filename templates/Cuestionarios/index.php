<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuestionario[]|\Cake\Collection\CollectionInterface $cuestionarios
 */
?>
<div class="cuestionarios index content">
    <?= $this->Html->link(__('New Cuestionario'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cuestionarios') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('programacion_centro') ?></th>
                    <th><?= $this->Paginator->sort('programacion_dni_medico') ?></th>
                    <th><?= $this->Paginator->sort('programacion_fecha_programacion') ?></th>
                    <th><?= $this->Paginator->sort('programacion_turno') ?></th>
                    <th><?= $this->Paginator->sort('fecha_hora') ?></th>
                    <th><?= $this->Paginator->sort('supervisor_dni') ?></th>
                    <th><?= $this->Paginator->sort('supervisor_nombres') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cuestionarios as $cuestionario): ?>
                <tr>
                    <td><?= $this->Number->format($cuestionario->id) ?></td>
                    <td><?= h($cuestionario->programacion_centro) ?></td>
                    <td><?= h($cuestionario->programacion_dni_medico) ?></td>
                    <td><?= h($cuestionario->programacion_fecha_programacion) ?></td>
                    <td><?= h($cuestionario->programacion_turno) ?></td>
                    <td><?= h($cuestionario->fecha_hora) ?></td>
                    <td><?= h($cuestionario->supervisor_dni) ?></td>
                    <td><?= h($cuestionario->supervisor_nombres) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cuestionario->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cuestionario->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cuestionario->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cuestionario->id)]) ?>
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
