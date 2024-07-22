<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Colaboradore $colaboradore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Colaboradore'), ['action' => 'edit', $colaboradore->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Colaboradore'), ['action' => 'delete', $colaboradore->id], ['confirm' => __('Are you sure you want to delete # {0}?', $colaboradore->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Colaboradores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Colaboradore'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="colaboradores view content">
            <h3><?= h($colaboradore->nro_documento) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tipo Documento') ?></th>
                    <td><?= h($colaboradore->tipo_documento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nro Documento') ?></th>
                    <td><?= h($colaboradore->nro_documento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Trabajador') ?></th>
                    <td><?= h($colaboradore->trabajador) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grupo Ocupacional') ?></th>
                    <td><?= h($colaboradore->grupo_ocupacional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado') ?></th>
                    <td><?= $colaboradore->has('estado') ? $this->Html->link($colaboradore->estado->descripcion, ['controller' => 'Estados', 'action' => 'view', $colaboradore->estado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($colaboradore->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
