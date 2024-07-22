<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReutilizablesSolicitudesDetalle $reutilizablesSolicitudesDetalle
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Reutilizables Solicitudes Detalles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reutilizablesSolicitudesDetalles form content">
            <?= $this->Form->create($reutilizablesSolicitudesDetalle) ?>
            <fieldset>
                <legend><?= __('Add Reutilizables Solicitudes Detalle') ?></legend>
                <?php
                    echo $this->Form->control('fecha');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
