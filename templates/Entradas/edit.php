<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entrada $entrada
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $entrada->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $entrada->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Entradas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="entradas form content">
            <?= $this->Form->create($entrada) ?>
            <fieldset>
                <legend><?= __('Edit Entrada') ?></legend>
                <?php
                    echo $this->Form->control('trabajador_id', ['options' => $trabajadores]);
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('area_id', ['options' => $areas]);
                    echo $this->Form->control('fecha_hora');
                    echo $this->Form->control('estado_id', ['options' => $estados]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
