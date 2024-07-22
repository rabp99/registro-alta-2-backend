<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GruposOcupacionale[]|\Cake\Collection\CollectionInterface $gruposOcupacionales
 */
?>
<div class="gruposOcupacionales index content">
    <?= $this->Html->link(__('New Grupos Ocupacionale'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Grupos Ocupacionales') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('descripcion') ?></th>
                    <th><?= $this->Paginator->sort('flag_show') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gruposOcupacionales as $gruposOcupacionale): ?>
                <tr>
                    <td><?= $this->Number->format($gruposOcupacionale->id) ?></td>
                    <td><?= h($gruposOcupacionale->descripcion) ?></td>
                    <td><?= h($gruposOcupacionale->flag_show) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $gruposOcupacionale->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $gruposOcupacionale->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $gruposOcupacionale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gruposOcupacionale->id)]) ?>
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
