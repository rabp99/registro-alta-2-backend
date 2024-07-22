<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pregunta $pregunta
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pregunta'), ['action' => 'edit', $pregunta->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pregunta'), ['action' => 'delete', $pregunta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pregunta->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Preguntas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pregunta'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="preguntas view content">
            <h3><?= h($pregunta->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Grupo') ?></th>
                    <td><?= $pregunta->has('grupo') ? $this->Html->link($pregunta->grupo->id, ['controller' => 'Grupos', 'action' => 'view', $pregunta->grupo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $pregunta->has('estado') ? $this->Html->link($pregunta->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $pregunta->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pregunta->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nro') ?></th>
                    <td><?= $this->Number->format($pregunta->nro) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descripcion') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($pregunta->descripcion)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
