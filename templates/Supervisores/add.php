<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisore $supervisore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Supervisores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="supervisores form content">
            <?= $this->Form->create($supervisore) ?>
            <fieldset>
                <legend><?= __('Add Supervisore') ?></legend>
                <?php
                    echo $this->Form->control('tipo_documento');
                    echo $this->Form->control('nro_documento');
                    echo $this->Form->control('trabajador');
                    echo $this->Form->control('estado_id', ['options' => $estados]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
