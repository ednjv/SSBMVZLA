<?php
$this->breadcrumbs=array(
	'Pvp Sets'=>array('admin'),
	'Nuevo registro',
);

$menu=array(
array('label'=>'Administrar', 'buttonType'=>'link', 'icon'=>'th-list', 'url'=>array('admin')),
);
?>

<?php $this->Widget('booster.widgets.TbPanel', array(
	    'title' => 'Nuevo registro',
    	'headerIcon' => 'icon-th-list ',
    	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
    	'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size' => 'small',
                'buttons'=>$menu,
            ),
        ),
    'content' => $this->renderPartial('_form',array('model'=>$model,'selectJugadores'=>$selectJugadores,'selectTorneos'=>$selectTorneos),true,false),
        ));
?>

