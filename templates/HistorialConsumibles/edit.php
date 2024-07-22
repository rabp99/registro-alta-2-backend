<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistorialConsumible $historialConsumible
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $historialConsumible->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $historialConsumible->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Historial Consumibles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="historialConsumibles form content">
            <?= $this->Form->create($historialConsumible) ?>
            <fieldset>
                <legend><?= __('Edit Historial Consumible') ?></legend>
                <?php
                    echo $this->Form->control('consumible_id', ['options' => $consumibles]);
                    echo $this->Form->control('tipo');
                    echo $this->Form->control('fecha');
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('entrega_id', ['options' => $entregas, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
