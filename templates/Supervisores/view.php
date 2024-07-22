<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisore $supervisore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Supervisore'), ['action' => 'edit', $supervisore->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Supervisore'), ['action' => 'delete', $supervisore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supervisore->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Supervisores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Supervisore'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="supervisores view content">
            <h3><?= h($supervisore->trabajador) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tipo Documento') ?></th>
                    <td><?= h($supervisore->tipo_documento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nro Documento') ?></th>
                    <td><?= h($supervisore->nro_documento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Trabajador') ?></th>
                    <td><?= h($supervisore->trabajador) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $supervisore->has('estado') ? $this->Html->link($supervisore->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $supervisore->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($supervisore->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
