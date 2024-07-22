<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Respuesta $respuesta
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $respuesta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $respuesta->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Respuestas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="respuestas form content">
            <?= $this->Form->create($respuesta) ?>
            <fieldset>
                <legend><?= __('Edit Respuesta') ?></legend>
                <?php
                    echo $this->Form->control('valor');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
