<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pregunta $pregunta
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pregunta->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pregunta->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Preguntas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="preguntas form content">
            <?= $this->Form->create($pregunta) ?>
            <fieldset>
                <legend><?= __('Edit Pregunta') ?></legend>
                <?php
                    echo $this->Form->control('nro');
                    echo $this->Form->control('descripcion');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
