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
            <?= $this->Html->link(__('Edit Programacione'), ['action' => 'edit', $programacione->centro], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Programacione'), ['action' => 'delete', $programacione->centro], ['confirm' => __('Are you sure you want to delete # {0}?', $programacione->centro), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Programaciones'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Programacione'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="programaciones view content">
            <h3><?= h($programacione->centro) ?></h3>
            <table>
                <tr>
                    <th><?= __('Centro') ?></th>
                    <td><?= h($programacione->centro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($programacione->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= h($programacione->area) ?></td>
                </tr>
                <tr>
                    <th><?= __('Servicio') ?></th>
                    <td><?= h($programacione->servicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Actividad') ?></th>
                    <td><?= h($programacione->actividad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subactividad') ?></th>
                    <td><?= h($programacione->subactividad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Consultorio') ?></th>
                    <td><?= h($programacione->consultorio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ubicacionconsult') ?></th>
                    <td><?= h($programacione->ubicacionconsult) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dni Medico') ?></th>
                    <td><?= h($programacione->dni_medico) ?></td>
                </tr>
                <tr>
                    <th><?= __('Profesional') ?></th>
                    <td><?= h($programacione->profesional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grupo Ocupacional') ?></th>
                    <td><?= h($programacione->grupo_ocupacional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tip Programacion') ?></th>
                    <td><?= h($programacione->tip_programacion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hor Inicio') ?></th>
                    <td><?= h($programacione->hor_inicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hor Fin') ?></th>
                    <td><?= h($programacione->hor_fin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado Programacion') ?></th>
                    <td><?= h($programacione->estado_programacion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Motivo Suspension') ?></th>
                    <td><?= h($programacione->motivo_suspension) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cod Planilla') ?></th>
                    <td><?= h($programacione->cod_planilla) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turno') ?></th>
                    <td><?= h($programacione->turno) ?></td>
                </tr>
                <tr>
                    <th><?= __('Condtrabajador') ?></th>
                    <td><?= h($programacione->condtrabajador) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pertenece Otro Cas') ?></th>
                    <td><?= h($programacione->pertenece_otro_cas) ?></td>
                </tr>
                <tr>
                    <th><?= __('Area Ingreso') ?></th>
                    <td><?= h($programacione->area_ingreso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Epp') ?></th>
                    <td><?= h($programacione->tipo_epp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($programacione->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Programacion') ?></th>
                    <td><?= h($programacione->fecha_programacion) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
