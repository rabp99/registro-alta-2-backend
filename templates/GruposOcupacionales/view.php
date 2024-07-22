<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GruposOcupacionale $gruposOcupacionale
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Grupos Ocupacionale'), ['action' => 'edit', $gruposOcupacionale->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Grupos Ocupacionale'), ['action' => 'delete', $gruposOcupacionale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gruposOcupacionale->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Grupos Ocupacionales'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Grupos Ocupacionale'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="gruposOcupacionales view content">
            <h3><?= h($gruposOcupacionale->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Descripcion') ?></th>
                    <td><?= h($gruposOcupacionale->descripcion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Flag Show') ?></th>
                    <td><?= h($gruposOcupacionale->flag_show) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($gruposOcupacionale->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
