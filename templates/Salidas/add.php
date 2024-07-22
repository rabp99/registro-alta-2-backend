<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salida $salida
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Salidas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salidas form content">
            <?= $this->Form->create($salida) ?>
            <fieldset>
                <legend><?= __('Add Salida') ?></legend>
                <?php
                    echo $this->Form->control('trabajador_id', ['options' => $trabajadores]);
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('fecha_hora');
                    echo $this->Form->control('estado_id', ['options' => $estados]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
