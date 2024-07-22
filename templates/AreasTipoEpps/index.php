<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AreasTipoEpp[]|\Cake\Collection\CollectionInterface $areasTipoEpps
 */
?>
<div class="areasTipoEpps index content">
    <?= $this->Html->link(__('New Areas Tipo Epp'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Areas Tipo Epps') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('area_id') ?></th>
                    <th><?= $this->Paginator->sort('tipos_epp_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($areasTipoEpps as $areasTipoEpp): ?>
                <tr>
                    <td><?= $areasTipoEpp->has('area') ? $this->Html->link($areasTipoEpp->area->id, ['controller' => 'Areas', 'action' => 'view', $areasTipoEpp->area->id]) : '' ?></td>
                    <td><?= $areasTipoEpp->has('tipos_epp') ? $this->Html->link($areasTipoEpp->tipos_epp->id, ['controller' => 'TiposEpps', 'action' => 'view', $areasTipoEpp->tipos_epp->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $areasTipoEpp->area_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $areasTipoEpp->area_id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $areasTipoEpp->area_id], ['confirm' => __('Are you sure you want to delete # {0}?', $areasTipoEpp->area_id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
