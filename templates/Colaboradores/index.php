<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Colaboradore[]|\Cake\Collection\CollectionInterface $colaboradores
 */
?>
<div class="colaboradores index content">
    <?= $this->Html->link(__('New Colaboradore'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Colaboradores') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tipo_documento') ?></th>
                    <th><?= $this->Paginator->sort('nro_documento') ?></th>
                    <th><?= $this->Paginator->sort('trabajador') ?></th>
                    <th><?= $this->Paginator->sort('grupo_ocupacional') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($colaboradores as $colaboradore): ?>
                <tr>
                    <td><?= $this->Number->format($colaboradore->id) ?></td>
                    <td><?= h($colaboradore->tipo_documento) ?></td>
                    <td><?= h($colaboradore->nro_documento) ?></td>
                    <td><?= h($colaboradore->trabajador) ?></td>
                    <td><?= h($colaboradore->grupo_ocupacional) ?></td>
                    <td><?= $colaboradore->has('estado') ? $this->Html->link($colaboradore->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $colaboradore->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $colaboradore->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $colaboradore->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $colaboradore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $colaboradore->id)]) ?>
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
