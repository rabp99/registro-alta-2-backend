<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Respuesta[]|\Cake\Collection\CollectionInterface $respuestas
 */
?>
<div class="respuestas index content">
    <?= $this->Html->link(__('New Respuesta'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Respuestas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('cuestionario_id') ?></th>
                    <th><?= $this->Paginator->sort('pregunta_id') ?></th>
                    <th><?= $this->Paginator->sort('valor') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($respuestas as $respuesta): ?>
                <tr>
                    <td><?= $this->Number->format($respuesta->id) ?></td>
                    <td><?= $respuesta->has('cuestionario') ? $this->Html->link($respuesta->cuestionario->id, ['controller' => 'Cuestionarios', 'action' => 'view', $respuesta->cuestionario->id]) : '' ?></td>
                    <td><?= $respuesta->has('pregunta') ? $this->Html->link($respuesta->pregunta->id, ['controller' => 'Preguntas', 'action' => 'view', $respuesta->pregunta->id]) : '' ?></td>
                    <td><?= h($respuesta->valor) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $respuesta->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $respuesta->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $respuesta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $respuesta->id)]) ?>
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
