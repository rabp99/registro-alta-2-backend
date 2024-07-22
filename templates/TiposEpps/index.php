<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TiposEpp[]|\Cake\Collection\CollectionInterface $tiposEpps
 */
?>
<div class="tiposEpps index content">
    <?= $this->Html->link(__('New Tipos Epp'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tipos Epps') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('descripcion') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tiposEpps as $tiposEpp): ?>
                <tr>
                    <td><?= $this->Number->format($tiposEpp->id) ?></td>
                    <td><?= h($tiposEpp->descripcion) ?></td>
                    <td><?= $tiposEpp->has('estado') ? $this->Html->link($tiposEpp->estado->id, ['controller' => 'Estados', 'action' => 'view', $tiposEpp->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tiposEpp->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tiposEpp->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tiposEpp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tiposEpp->id)]) ?>
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
