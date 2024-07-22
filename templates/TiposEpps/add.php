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
            <?= $this->Html->link(__('List Tipos Epps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tiposEpps form content">
            <?= $this->Form->create($tiposEpp) ?>
            <fieldset>
                <legend><?= __('Add Tipos Epp') ?></legend>
                <?php
                    echo $this->Form->control('descripcion');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
