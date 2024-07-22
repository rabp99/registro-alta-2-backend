<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salida[]|\Cake\Collection\CollectionInterface $salidas
 */
?>
<div class="salidas index content">
    <?= $this->Html->link(__('New Salida'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Salidas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('trabajador_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('fecha_hora') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salidas as $salida): ?>
                <tr>
                    <td><?= $this->Number->format($salida->id) ?></td>
                    <td><?= $salida->has('trabajador') ? $this->Html->link($salida->trabajador->dni, ['controller' => 'Trabajadores', 'action' => 'view', $salida->trabajador->id]) : '' ?></td>
                    <td><?= $this->Number->format($salida->user_id) ?></td>
                    <td><?= h($salida->fecha_hora) ?></td>
                    <td><?= $salida->has('estado') ? $this->Html->link($salida->estado->id, ['controller' => 'Estados', 'action' => 'view', $salida->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $salida->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salida->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salida->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salida->id)]) ?>
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
