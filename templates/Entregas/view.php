<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entrega $entrega
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Entrega'), ['action' => 'edit', $entrega->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Entrega'), ['action' => 'delete', $entrega->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entrega->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Entregas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Entrega'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="entregas view content">
            <h3><?= h($entrega->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Consumible') ?></th>
                    <td><?= $entrega->has('consumible') ? $this->Html->link($entrega->consumible->id, ['controller' => 'Consumibles', 'action' => 'view', $entrega->consumible->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Documento') ?></th>
                    <td><?= h($entrega->tipo_documento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nro Documento') ?></th>
                    <td><?= h($entrega->nro_documento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Profesional') ?></th>
                    <td><?= h($entrega->profesional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($entrega->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($entrega->cantidad) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha') ?></th>
                    <td><?= h($entrega->fecha) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
