<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuestionario $cuestionario
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cuestionario->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cuestionario->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cuestionarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cuestionarios form content">
            <?= $this->Form->create($cuestionario) ?>
            <fieldset>
                <legend><?= __('Edit Cuestionario') ?></legend>
                <?php
                    echo $this->Form->control('fecha_hora');
                    echo $this->Form->control('supervisor_dni');
                    echo $this->Form->control('supervisor_nombres');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
