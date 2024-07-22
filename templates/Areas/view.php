<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Area $area
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Area'), ['action' => 'edit', $area->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Area'), ['action' => 'delete', $area->id], ['confirm' => __('Are you sure you want to delete # {0}?', $area->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Areas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Area'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areas view content">
            <h3><?= h($area->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Descripcion') ?></th>
                    <td><?= h($area->descripcion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $area->has('estado') ? $this->Html->link($area->estado->id, ['controller' => 'Estados', 'action' => 'view', $area->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($area->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Areas Tipo Epps') ?></h4>
                <?php if (!empty($area->areas_tipo_epps)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Area Id') ?></th>
                            <th><?= __('Tipos Epp Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($area->areas_tipo_epps as $areasTipoEpps) : ?>
                        <tr>
                            <td><?= h($areasTipoEpps->area_id) ?></td>
                            <td><?= h($areasTipoEpps->tipos_epp_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AreasTipoEpps', 'action' => 'view', $areasTipoEpps->area_id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AreasTipoEpps', 'action' => 'edit', $areasTipoEpps->area_id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AreasTipoEpps', 'action' => 'delete', $areasTipoEpps->area_id], ['confirm' => __('Are you sure you want to delete # {0}?', $areasTipoEpps->area_id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Entradas') ?></h4>
                <?php if (!empty($area->entradas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Trabajador Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Area Id') ?></th>
                            <th><?= __('Fecha Hora') ?></th>
                            <th><?= __('Estado Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($area->entradas as $entradas) : ?>
                        <tr>
                            <td><?= h($entradas->id) ?></td>
                            <td><?= h($entradas->trabajador_id) ?></td>
                            <td><?= h($entradas->user_id) ?></td>
                            <td><?= h($entradas->area_id) ?></td>
                            <td><?= h($entradas->fecha_hora) ?></td>
                            <td><?= h($entradas->estado_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Entradas', 'action' => 'view', $entradas->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Entradas', 'action' => 'edit', $entradas->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Entradas', 'action' => 'delete', $entradas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entradas->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Programaciones') ?></h4>
                <?php if (!empty($area->programaciones)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Centro') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Area') ?></th>
                            <th><?= __('Servicio') ?></th>
                            <th><?= __('Actividad') ?></th>
                            <th><?= __('Subactividad') ?></th>
                            <th><?= __('Consultorio') ?></th>
                            <th><?= __('Ubicacionconsult') ?></th>
                            <th><?= __('Dni Medico') ?></th>
                            <th><?= __('Profesional') ?></th>
                            <th><?= __('Grupo Ocupacional') ?></th>
                            <th><?= __('Tip Programacion') ?></th>
                            <th><?= __('Fecha Programacion') ?></th>
                            <th><?= __('Hor Inicio') ?></th>
                            <th><?= __('Hor Fin') ?></th>
                            <th><?= __('Estado Programacion') ?></th>
                            <th><?= __('Motivo Suspension') ?></th>
                            <th><?= __('Cod Planilla') ?></th>
                            <th><?= __('Turno') ?></th>
                            <th><?= __('Condtrabajador') ?></th>
                            <th><?= __('Pertenece Otro Cas') ?></th>
                            <th><?= __('Area Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($area->programaciones as $programaciones) : ?>
                        <tr>
                            <td><?= h($programaciones->centro) ?></td>
                            <td><?= h($programaciones->periodo) ?></td>
                            <td><?= h($programaciones->area) ?></td>
                            <td><?= h($programaciones->servicio) ?></td>
                            <td><?= h($programaciones->actividad) ?></td>
                            <td><?= h($programaciones->subactividad) ?></td>
                            <td><?= h($programaciones->consultorio) ?></td>
                            <td><?= h($programaciones->ubicacionconsult) ?></td>
                            <td><?= h($programaciones->dni_medico) ?></td>
                            <td><?= h($programaciones->profesional) ?></td>
                            <td><?= h($programaciones->grupo_ocupacional) ?></td>
                            <td><?= h($programaciones->tip_programacion) ?></td>
                            <td><?= h($programaciones->fecha_programacion) ?></td>
                            <td><?= h($programaciones->hor_inicio) ?></td>
                            <td><?= h($programaciones->hor_fin) ?></td>
                            <td><?= h($programaciones->estado_programacion) ?></td>
                            <td><?= h($programaciones->motivo_suspension) ?></td>
                            <td><?= h($programaciones->cod_planilla) ?></td>
                            <td><?= h($programaciones->turno) ?></td>
                            <td><?= h($programaciones->condtrabajador) ?></td>
                            <td><?= h($programaciones->pertenece_otro_cas) ?></td>
                            <td><?= h($programaciones->area_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Programaciones', 'action' => 'view', $programaciones->centro]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Programaciones', 'action' => 'edit', $programaciones->centro]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Programaciones', 'action' => 'delete', $programaciones->centro], ['confirm' => __('Are you sure you want to delete # {0}?', $programaciones->centro)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Registros') ?></h4>
                <?php if (!empty($area->registros)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Tipo') ?></th>
                            <th><?= __('Trabajador Id') ?></th>
                            <th><?= __('Fecha Hora') ?></th>
                            <th><?= __('Area Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($area->registros as $registros) : ?>
                        <tr>
                            <td><?= h($registros->tipo) ?></td>
                            <td><?= h($registros->trabajador_id) ?></td>
                            <td><?= h($registros->fecha_hora) ?></td>
                            <td><?= h($registros->area_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Registros', 'action' => 'view', $registros->]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Registros', 'action' => 'edit', $registros->]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Registros', 'action' => 'delete', $registros->], ['confirm' => __('Are you sure you want to delete # {0}?', $registros->)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
