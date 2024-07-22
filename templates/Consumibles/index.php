<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consumible[]|\Cake\Collection\CollectionInterface $consumibles
 */
?>
<div class="consumibles index content">
    <?= $this->Html->link(__('New Consumible'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Consumibles') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('descripcion') ?></th>
                    <th><?= $this->Paginator->sort('stock') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consumibles as $consumible): ?>
                <tr>
                    <td><?= $this->Number->format($consumible->id) ?></td>
                    <td><?= h($consumible->descripcion) ?></td>
                    <td><?= $this->Number->format($consumible->stock) ?></td>
                    <td><?= $consumible->has('estado') ? $this->Html->link($consumible->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $consumible->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $consumible->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consumible->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consumible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consumible->id)]) ?>
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
