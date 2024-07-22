<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TiposEpp $tiposEpp
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tipos Epp'), ['action' => 'edit', $tiposEpp->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tipos Epp'), ['action' => 'delete', $tiposEpp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tiposEpp->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tipos Epps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tipos Epp'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tiposEpps view content">
            <h3><?= h($tiposEpp->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Descripcion') ?></th>
                    <td><?= h($tiposEpp->descripcion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $tiposEpp->has('estado') ? $this->Html->link($tiposEpp->estado->id, ['controller' => 'Estados', 'action' => 'view', $tiposEpp->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tiposEpp->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
