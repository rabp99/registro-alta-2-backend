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
            <?= $this->Html->link(__('List Grupos Ocupacionales'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="gruposOcupacionales form content">
            <?= $this->Form->create($gruposOcupacionale) ?>
            <fieldset>
                <legend><?= __('Add Grupos Ocupacionale') ?></legend>
                <?php
                    echo $this->Form->control('descripcion');
                    echo $this->Form->control('flag_show');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
