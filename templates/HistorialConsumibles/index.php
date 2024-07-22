<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistorialConsumible[]|\Cake\Collection\CollectionInterface $historialConsumibles
 */
?>
<div class="historialConsumibles index content">
    <?= $this->Html->link(__('New Historial Consumible'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Historial Consumibles') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('consumible_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('fecha') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th><?= $this->Paginator->sort('entrega_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historialConsumibles as $historialConsumible): ?>
                <tr>
                    <td><?= $this->Number->format($historialConsumible->id) ?></td>
                    <td><?= $historialConsumible->has('consumible') ? $this->Html->link($historialConsumible->consumible->descripcion, ['controller' => 'Consumibles', 'action' => 'view', $historialConsumible->consumible->id]) : '' ?></td>
                    <td><?= h($historialConsumible->tipo) ?></td>
                    <td><?= h($historialConsumible->fecha) ?></td>
                    <td><?= $this->Number->format($historialConsumible->cantidad) ?></td>
                    <td><?= $historialConsumible->has('entrega') ? $this->Html->link($historialConsumible->entrega->fecha, ['controller' => 'Entregas', 'action' => 'view', $historialConsumible->entrega->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $historialConsumible->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $historialConsumible->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $historialConsumible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historialConsumible->id)]) ?>
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
