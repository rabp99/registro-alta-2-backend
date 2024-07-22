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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $colaboradore->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $colaboradore->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Colaboradores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="colaboradores form content">
            <?= $this->Form->create($colaboradore) ?>
            <fieldset>
                <legend><?= __('Edit Colaboradore') ?></legend>
                <?php
                    echo $this->Form->control('tipo_documento');
                    echo $this->Form->control('nro_documento');
                    echo $this->Form->control('trabajador');
                    echo $this->Form->control('grupo_ocupacional');
                    echo $this->Form->control('estado_id', ['options' => $estados]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
