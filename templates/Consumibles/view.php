<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consumible $consumible
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Consumible'), ['action' => 'edit', $consumible->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Consumible'), ['action' => 'delete', $consumible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consumible->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Consumibles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Consumible'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="consumibles view content">
            <h3><?= h($consumible->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Descripcion') ?></th>
                    <td><?= h($consumible->descripcion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $consumible->has('estado') ? $this->Html->link($consumible->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $consumible->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($consumible->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Stock') ?></th>
                    <td><?= $this->Number->format($consumible->stock) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
