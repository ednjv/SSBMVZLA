<?php $this->beginContent('//layouts/main'); ?>

<div class="row-fluid">
   <div class="col-lg-2 padding-left-0">
    <?php $box = $this->beginWidget('booster.widgets.TbPanel', array(
        'title' => 'Acciones',
        'headerIcon' => 'th-list',
        'padContent' => false,
        'htmlOptions' => array('class' => 'bootstrap-widget-table')
    ));
    $this->widget('booster.widgets.TbMenu', array(
        'type'=>'list',
        'items'=>$this->menu,
     // 'htmlOptions'=>array('class'=>'side-nav btn'),
        ));
    $this->endWidget();
    ?>
</div>

<div class="col-lg-10 padding-right-0">
    <?php echo $content; ?> 
</div>
</div>

<?php $this->endContent(); ?>


