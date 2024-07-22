<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Respuesta $respuesta
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Respuesta'), ['action' => 'edit', $respuesta->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Respuesta'), ['action' => 'delete', $respuesta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $respuesta->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Respuestas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Respuesta'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="respuestas view content">
            <h3><?= h($respuesta->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Cuestionario') ?></th>
                    <td><?= $respuesta->has('cuestionario') ? $this->Html->link($respuesta->cuestionario->id, ['controller' => 'Cuestionarios', 'action' => 'view', $respuesta->cuestionario->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pregunta') ?></th>
                    <td><?= $respuesta->has('pregunta') ? $this->Html->link($respuesta->pregunta->id, ['controller' => 'Preguntas', 'action' => 'view', $respuesta->pregunta->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Valor') ?></th>
                    <td><?= h($respuesta->valor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($respuesta->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
