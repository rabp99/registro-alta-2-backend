<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tipo[]|\Cake\Collection\CollectionInterface $tipos
 */
?>
<div class="tipos index content">
    <?= $this->Html->link(__('New Tipo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tipos') ?></h3>
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
                <?php foreach ($tipos as $tipo): ?>
                <tr>
                    <td><?= $this->Number->format($tipo->id) ?></td>
                    <td><?= h($tipo->descripcion) ?></td>
                    <td><?= $tipo->has('estado') ? $this->Html->link($tipo->estado->id, ['controller' => 'Estados', 'action' => 'view', $tipo->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tipo->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tipo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tipo->id)]) ?>
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
