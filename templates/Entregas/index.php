<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entrega[]|\Cake\Collection\CollectionInterface $entregas
 */
?>
<div class="entregas index content">
    <?= $this->Html->link(__('New Entrega'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Entregas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('consumible_id') ?></th>
                    <th><?= $this->Paginator->sort('fecha') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('tipo_documento') ?></th>
                    <th><?= $this->Paginator->sort('nro_documento') ?></th>
                    <th><?= $this->Paginator->sort('profesional') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entregas as $entrega): ?>
                <tr>
                    <td><?= $this->Number->format($entrega->id) ?></td>
                    <td><?= $entrega->has('consumible') ? $this->Html->link($entrega->consumible->id, ['controller' => 'Consumibles', 'action' => 'view', $entrega->consumible->id]) : '' ?></td>
                    <td><?= h($entrega->fecha) ?></td>
                    <td><?= $this->Number->format($entrega->cantidad) ?></td>
                    <td><?= h($entrega->tipo_documento) ?></td>
                    <td><?= h($entrega->nro_documento) ?></td>
                    <td><?= h($entrega->profesional) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $entrega->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $entrega->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $entrega->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entrega->id)]) ?>
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
