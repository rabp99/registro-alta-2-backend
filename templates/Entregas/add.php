<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entrega $entrega
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Entregas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="entregas form content">
            <?= $this->Form->create($entrega) ?>
            <fieldset>
                <legend><?= __('Add Entrega') ?></legend>
                <?php
                    echo $this->Form->control('fecha');
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('tipo_documento');
                    echo $this->Form->control('nro_documento');
                    echo $this->Form->control('profesional');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
