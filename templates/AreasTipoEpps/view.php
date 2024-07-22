<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AreasTipoEpp $areasTipoEpp
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Areas Tipo Epp'), ['action' => 'edit', $areasTipoEpp->area_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Areas Tipo Epp'), ['action' => 'delete', $areasTipoEpp->area_id], ['confirm' => __('Are you sure you want to delete # {0}?', $areasTipoEpp->area_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Areas Tipo Epps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Areas Tipo Epp'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areasTipoEpps view content">
            <h3><?= h($areasTipoEpp->area_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Area') ?></th>
                    <td><?= $areasTipoEpp->has('area') ? $this->Html->link($areasTipoEpp->area->id, ['controller' => 'Areas', 'action' => 'view', $areasTipoEpp->area->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipos Epp') ?></th>
                    <td><?= $areasTipoEpp->has('tipos_epp') ? $this->Html->link($areasTipoEpp->tipos_epp->id, ['controller' => 'TiposEpps', 'action' => 'view', $areasTipoEpp->tipos_epp->id]) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
