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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tiposEpp->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tiposEpp->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tipos Epps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tiposEpps form content">
            <?= $this->Form->create($tiposEpp) ?>
            <fieldset>
                <legend><?= __('Edit Tipos Epp') ?></legend>
                <?php
                    echo $this->Form->control('descripcion');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
