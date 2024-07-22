<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisore[]|\Cake\Collection\CollectionInterface $supervisores
 */
?>
<div class="supervisores index content">
    <?= $this->Html->link(__('New Supervisore'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Supervisores') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tipo_documento') ?></th>
                    <th><?= $this->Paginator->sort('nro_documento') ?></th>
                    <th><?= $this->Paginator->sort('trabajador') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supervisores as $supervisore): ?>
                <tr>
                    <td><?= $this->Number->format($supervisore->id) ?></td>
                    <td><?= h($supervisore->tipo_documento) ?></td>
                    <td><?= h($supervisore->nro_documento) ?></td>
                    <td><?= h($supervisore->trabajador) ?></td>
                    <td><?= $supervisore->has('estado') ? $this->Html->link($supervisore->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $supervisore->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $supervisore->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $supervisore->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $supervisore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisore->id)]) ?>
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
