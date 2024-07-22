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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $reutilizablesSolicitudesDetalle->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reutilizablesSolicitudesDetalle->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Reutilizables Solicitudes Detalles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="reutilizablesSolicitudesDetalles form content">
            <?= $this->Form->create($reutilizablesSolicitudesDetalle) ?>
            <fieldset>
                <legend><?= __('Edit Reutilizables Solicitudes Detalle') ?></legend>
                <?php
                    echo $this->Form->control('fecha');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
