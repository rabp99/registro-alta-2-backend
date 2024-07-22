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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $areasTipoEpp->area_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $areasTipoEpp->area_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Areas Tipo Epps'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="areasTipoEpps form content">
            <?= $this->Form->create($areasTipoEpp) ?>
            <fieldset>
                <legend><?= __('Edit Areas Tipo Epp') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
