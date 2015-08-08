	<?php
		$this->widget('application.extensions.widgets.TbMenuCollapse', array(
			'type'=>'list',
			'items'=>array(
				array(
					'label'=>'Administrador',
					'icon'=>'fa fa-cog'
				),
				array(
					'label'=>'Usuarios',
					'icon'=>' fa fa-user',
					'items'=>array(
						array(
							'label'=>'Administrar usuarios',
							'url'=>array('/user/admin')
						),
					)
				),
				array(
					'label'=>'Permisología',
					'icon'=>' fa fa-lock',
					'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
					'submenuOptions'=>array('id'=>'Permisologia'),
					'items'=>array(
						array(
							'label'=>Rights::t('core', 'Assignments'),
							'url'=>array('/rights/assignment/view'),
							'itemOptions'=>array('class'=>'item-assignments'),
						),
						array(
							'label'=>Rights::t('core', 'Permissions'),
							'url'=>array('/rights/authItem/permissions'),
							'itemOptions'=>array('class'=>'item-permissions'),
						),
						array(
							'label'=>Rights::t('core', 'Roles'),
							'url'=>array('/rights/authItem/roles'),
							'itemOptions'=>array('class'=>'item-roles'),
						),
						array(
							'label'=>Rights::t('core', 'Tasks'),
							'url'=>array('/rights/authItem/tasks'),
							'itemOptions'=>array('class'=>'item-tasks'),
						),
						array(
							'label'=>Rights::t('core', 'Operations'),
							'url'=>array('/rights/authItem/operations'),
							'itemOptions'=>array('class'=>'item-operations'),
						),
					),
				),
				array('label'=>'Módulos','icon'=>'fa fa-cog'),
				array('label'=>'Tipos de Producto','icon'=>'fa fa-tags','visible'=>Yii::app()->getUser()->checkAccess('Admin'),'url'=>array('/tipoProducto/admin')),
				array('label'=>'Productos','icon'=>'fa fa-briefcase','visible'=>Yii::app()->getUser()->checkAccess('Admin'),'url'=>array('/producto/admin')),
				array('label'=>'Clientes','icon'=>'fa fa-users','visible'=>Yii::app()->getUser()->checkAccess('Admin'),'url'=>array('/cliente/admin')),
				array('label'=>'Asignación a Clientes','icon'=>'fa fa-plus-circle','visible'=>Yii::app()->getUser()->checkAccess('Admin'),'url'=>array('/clienteProducto/admin')),
			),
			'htmlOptions'=>array('class'=>'nav-sidebar'),
		));
	?>