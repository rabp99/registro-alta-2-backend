<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Programacione $programacione
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $programacione->centro],
                ['confirm' => __('Are you sure you want to delete # {0}?', $programacione->centro), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Programaciones'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="programaciones form content">
            <?= $this->Form->create($programacione) ?>
            <fieldset>
                <legend><?= __('Edit Programacione') ?></legend>
                <?php
                    echo $this->Form->control('periodo');
                    echo $this->Form->control('area');
                    echo $this->Form->control('servicio');
                    echo $this->Form->control('actividad');
                    echo $this->Form->control('subactividad');
                    echo $this->Form->control('consultorio');
                    echo $this->Form->control('ubicacionconsult');
                    echo $this->Form->control('profesional');
                    echo $this->Form->control('grupo_ocupacional');
                    echo $this->Form->control('tip_programacion');
                    echo $this->Form->control('hor_inicio');
                    echo $this->Form->control('hor_fin');
                    echo $this->Form->control('estado_programacion');
                    echo $this->Form->control('motivo_suspension');
                    echo $this->Form->control('cod_planilla');
                    echo $this->Form->control('condtrabajador');
                    echo $this->Form->control('pertenece_otro_cas');
                    echo $this->Form->control('area_ingreso');
                    echo $this->Form->control('tipo_epp');
                    echo $this->Form->control('cantidad');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
