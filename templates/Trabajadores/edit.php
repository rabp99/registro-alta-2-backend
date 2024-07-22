<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Trabajadore $trabajadore
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $trabajadore->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $trabajadore->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Trabajadores'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="trabajadores form content">
            <?= $this->Form->create($trabajadore) ?>
            <fieldset>
                <legend><?= __('Edit Trabajadore') ?></legend>
                <?php
                    echo $this->Form->control('dni');
                    echo $this->Form->control('nombres');
                    echo $this->Form->control('apellido_paterno');
                    echo $this->Form->control('apellido_materno');
                    echo $this->Form->control('grupo_ocupacional');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
