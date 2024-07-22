<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Trabajadore $trabajadore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Trabajadore'), ['action' => 'edit', $trabajadore->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Trabajadore'), ['action' => 'delete', $trabajadore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trabajadore->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Trabajadores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Trabajadore'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="trabajadores view content">
            <h3><?= h($trabajadore->dni) ?></h3>
            <table>
                <tr>
                    <th><?= __('Dni') ?></th>
                    <td><?= h($trabajadore->dni) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nombres') ?></th>
                    <td><?= h($trabajadore->nombres) ?></td>
                </tr>
                <tr>
                    <th><?= __('Apellido Paterno') ?></th>
                    <td><?= h($trabajadore->apellido_paterno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Apellido Materno') ?></th>
                    <td><?= h($trabajadore->apellido_materno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grupo Ocupacional') ?></th>
                    <td><?= h($trabajadore->grupo_ocupacional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($trabajadore->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
