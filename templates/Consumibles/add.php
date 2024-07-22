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
            <?= $this->Html->link(__('List Consumibles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="consumibles form content">
            <?= $this->Form->create($consumible) ?>
            <fieldset>
                <legend><?= __('Add Consumible') ?></legend>
                <?php
                    echo $this->Form->control('descripcion');
                    echo $this->Form->control('stock');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
