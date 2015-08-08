<?php
/* @var $this UserController */
/* @var $model User */
$this->pageTitle = 'Perfil de '.$model->username;
$user = Yii::app()->getUser();
$this->breadcrumbs = array(
    'Usuarios' => $user->checkAccess('Admin') ? array('admin') : array('view', 'id' => $model->id),
    $model->username,
    );


if ($user->checkAccess('Admin')) {
    $operaciones = array(
       // array('label' => 'Nuevo Usuario', 'url' => array('create')),
        array('label' => 'Eliminar cuenta', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => '¿Estás seguro de realizar esta acción?')),
      //  array('label' => 'Administrar Usuarios', 'url' => array('admin')),
        array('label' => 'Modificar datos', 'url' => array('update', 'id' => $model->id)),
        );
} else {
    $operaciones = array(
        array('label' => 'Modificar Contraseña', 'url' => array('updatePassword', 'id' => $model->id)),
        );
}

//$this->menu = $operaciones;
?>

<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'Perfil de usuario <b style="color:#4295B6">' . $model->username . '</b>',
    'headerIcon' => 'user',
    'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
    'headerButtons' => array(
        array(
            'class' => 'booster.widgets.TbButtonGroup',
            'htmlOptions'=>array('style'=>'margin-top:-5px;'),
            'size'=>'small',
            'buttons'=>array(
                array('label'=>'Operaciones', 'icon'=>'cog', 
                    'items'=>$operaciones),
                ),
            ),
        ),
    ));
    ?>

    <div class="col-sm-3">
        <strong>Fotografía</strong><br><br>
        <img src="<?php if ($model->photo != null) { 
            echo Yii::app()->request->baseUrl . '/usuarios/' . $model->photo; 
        } else {
            echo Yii::app()->request->baseUrl . '/usuarios/user-default.png';
        } ?>" 
        style="height:157px; width:147px;"/>		
    </div>
    <div class="col-sm-9">
        <strong>Datos de usuario</strong><br><br>
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'htmlOptions'=>array('style'=>"margin-left: 20px;"),
            'attributes' => array(
                'cedula',
                'username',
                'email',
                'create_at',
                'lastvisit_at',            
                array(
                    'name' => 'status',
                    'value' => CHtml::encode(User::itemAlias("UserStatus", $model->status)),
                    ),
                ),
));
?>
</div>


<?php $this->endWidget(); ?>