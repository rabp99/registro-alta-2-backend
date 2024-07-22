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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $gruposOcupacionale->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $gruposOcupacionale->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Grupos Ocupacionales'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="gruposOcupacionales form content">
            <?= $this->Form->create($gruposOcupacionale) ?>
            <fieldset>
                <legend><?= __('Edit Grupos Ocupacionale') ?></legend>
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
