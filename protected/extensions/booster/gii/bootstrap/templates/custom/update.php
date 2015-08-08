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
	'Modificar',
);\n";
?>

	$menu=array(
		array('label'=>'Administrar', 'buttonType'=>'link', 'icon'=>'th-list', 'url'=>array('admin')),
		array('label'=>'Nuevo registro', 'buttonType'=>'link', 'icon'=>'plus', 'url'=>array('create')),
	);
	?>

<?php echo "<?php"; ?> $this->Widget('booster.widgets.TbPanel', array(
	    'title' => 'Modificar',
    	'headerIcon' => 'pencil',
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
    'content' => $this->renderPartial('_form',array('model'=>$model),true,false),
        ));
?>

