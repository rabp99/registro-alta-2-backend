<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grupo $grupo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $grupo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $grupo->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Grupos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="grupos form content">
            <?= $this->Form->create($grupo) ?>
            <fieldset>
                <legend><?= __('Edit Grupo') ?></legend>
                <?php
                    echo $this->Form->control('descripcion');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
