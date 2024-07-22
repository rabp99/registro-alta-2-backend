<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pregunta[]|\Cake\Collection\CollectionInterface $preguntas
 */
?>
<div class="preguntas index content">
    <?= $this->Html->link(__('New Pregunta'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Preguntas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nro') ?></th>
                    <th><?= $this->Paginator->sort('grupo_id') ?></th>
                    <th><?= $this->Paginator->sort('estado_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($preguntas as $pregunta): ?>
                <tr>
                    <td><?= $this->Number->format($pregunta->id) ?></td>
                    <td><?= $this->Number->format($pregunta->nro) ?></td>
                    <td><?= $pregunta->has('grupo') ? $this->Html->link($pregunta->grupo->id, ['controller' => 'Grupos', 'action' => 'view', $pregunta->grupo->id]) : '' ?></td>
                    <td><?= $pregunta->has('estado') ? $this->Html->link($pregunta->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $pregunta->estado->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pregunta->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pregunta->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pregunta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pregunta->id)]) ?>
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
