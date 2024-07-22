<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Solicitude $solicitude
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Solicitudes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="solicitudes form content">
            <?= $this->Form->create($solicitude) ?>
            <fieldset>
                <legend><?= __('Add Solicitude') ?></legend>
                <?php
                    echo $this->Form->control('programaciones_centro');
                    echo $this->Form->control('programaciones_trabajador_id', ['options' => $programaciones, 'empty' => true]);
                    echo $this->Form->control('programaciones_fecha_programacion', ['empty' => true]);
                    echo $this->Form->control('programaciones_turno');
                    echo $this->Form->control('area_ingreso');
                    echo $this->Form->control('tipo_epp');
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('fecha_solicitud');
                    echo $this->Form->control('fecha_entrega', ['empty' => true]);
                    echo $this->Form->control('firma');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
