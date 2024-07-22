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
            <?= $this->Html->link(__('List Reutilizables'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reutilizables form content">
            <?= $this->Form->create($reutilizable) ?>
            <fieldset>
                <legend><?= __('Add Reutilizable') ?></legend>
                <?php
                    echo $this->Form->control('codigo');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
