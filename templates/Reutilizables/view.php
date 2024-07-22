<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reutilizable $reutilizable
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Reutilizable'), ['action' => 'edit', $reutilizable->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Reutilizable'), ['action' => 'delete', $reutilizable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reutilizable->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reutilizables'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Reutilizable'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reutilizables view content">
            <h3><?= h($reutilizable->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= $reutilizable->has('tipo') ? $this->Html->link($reutilizable->tipo->id, ['controller' => 'Tipos', 'action' => 'view', $reutilizable->tipo->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $reutilizable->has('estado') ? $this->Html->link($reutilizable->estado->id, ['controller' => 'Estados', 'action' => 'view', $reutilizable->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($reutilizable->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Codigo') ?></th>
                    <td><?= $this->Number->format($reutilizable->codigo) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
