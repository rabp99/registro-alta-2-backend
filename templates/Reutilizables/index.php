<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reutilizable[]|\Cake\Collection\CollectionInterface $reutilizables
 */
?>
<div class="reutilizables index content">
    <?= $this->Html->link(__('New Reutilizable'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reutilizables') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tipo_id') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th><?= $this->Paginator->sort('codigo') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reutilizables as $reutilizable): ?>
                <tr>
                    <td><?= $this->Number->format($reutilizable->id) ?></td>
                    <td><?= $reutilizable->has('tipo') ? $this->Html->link($reutilizable->tipo->id, ['controller' => 'Tipos', 'action' => 'view', $reutilizable->tipo->id]) : '' ?></td>
                    <td><?= $reutilizable->has('estado') ? $this->Html->link($reutilizable->estado->id, ['controller' => 'Estados', 'action' => 'view', $reutilizable->estado->id]) : '' ?></td>
                    <td><?= $this->Number->format($reutilizable->codigo) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $reutilizable->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reutilizable->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reutilizable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reutilizable->id)]) ?>
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
