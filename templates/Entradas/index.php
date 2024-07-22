<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entrada[]|\Cake\Collection\CollectionInterface $entradas
 */
?>
<div class="entradas index content">
    <?= $this->Html->link(__('New Entrada'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Entradas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('trabajador_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('area_id') ?></th>
                    <th><?= $this->Paginator->sort('fecha_hora') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entradas as $entrada): ?>
                <tr>
                    <td><?= $this->Number->format($entrada->id) ?></td>
                    <td><?= $entrada->has('trabajador') ? $this->Html->link($entrada->trabajador->dni, ['controller' => 'Trabajadores', 'action' => 'view', $entrada->trabajador->id]) : '' ?></td>
                    <td><?= $entrada->has('user') ? $this->Html->link($entrada->user->id, ['controller' => 'Users', 'action' => 'view', $entrada->user->id]) : '' ?></td>
                    <td><?= $entrada->has('area') ? $this->Html->link($entrada->area->id, ['controller' => 'Areas', 'action' => 'view', $entrada->area->id]) : '' ?></td>
                    <td><?= h($entrada->fecha_hora) ?></td>
                    <td><?= $entrada->has('estado') ? $this->Html->link($entrada->estado->id, ['controller' => 'Estados', 'action' => 'view', $entrada->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $entrada->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $entrada->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $entrada->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entrada->id)]) ?>
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
