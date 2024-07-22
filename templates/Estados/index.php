<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estado[]|\Cake\Collection\CollectionInterface $estados
 */
?>
<div class="estados index content">
    <?= $this->Html->link(__('New Estado'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Estados') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('descripcion') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estados as $estado): ?>
                <tr>
                    <td><?= $this->Number->format($estado->id) ?></td>
                    <td><?= h($estado->descripcion) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $estado->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $estado->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $estado->id], ['confirm' => __('Are you sure you want to delete # {0}?', $estado->id)]) ?>
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
