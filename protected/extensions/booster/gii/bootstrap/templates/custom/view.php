<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	\$model->{$nameColumn},
);\n";
?>

$menu=array(
array('label'=>'Nuevo registro', 'buttonType'=>'link', 'icon'=>'plus', 'url'=>array('create')),
array('label'=>'Modificar', 'icon'=>'pencil','url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
array('label'=>'Eliminar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'¿Está seguro que desea borrar este elemento?')),
array('label'=>'Administrar', 'buttonType'=>'link', 'icon'=>'th-list', 'url'=>array('admin')),
);
?>


<?php echo "<?php"; ?> $this->beginWidget('booster.widgets.TbPanel', array(
	    'title' => 'Detalles de registro '. <?php echo "\$model->{$this->tableSchema->primaryKey}"; ?>,
    	'headerIcon' => 'eye-open',
    	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
    	'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size' => 'small',
                'buttons'=>array(
                array('label'=>'Operaciones', 'icon'=>'cog', 
                    'items'=>$menu),
                ),
            ),
        ),
        ));
?>

<?php echo "<?php"; ?> $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
<?php
foreach ($this->tableSchema->columns as $column) {
	echo "\t\t'" . $column->name . "',\n";
}
?>
),
)); ?>

<?php echo "<?php "; ?>
$this->endWidget();
?>
