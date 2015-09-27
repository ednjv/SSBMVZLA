<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
	<?php
		$baseUrl=Yii::app()->baseUrl;
		$themeUrl=Yii::app()->theme->baseUrl;
		$cs=Yii::app()->getClientScript();
		$user=Yii::app()->getUser();
	?>
	<!-- Necesidades básicas de la página
	================================================== -->
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="" name="description">
	<meta content="" name="author">
	<!-- Titulo de página -->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="icon" type="image/png" href="<?php echo $themeUrl.'/img/smash.png'; ?>">

	<?php $cs->registerCssFile($themeUrl . '/css/main.css'); ?>
	<?php $cs->registerScriptFile($baseUrl . '/js/ChartJs/Chart.js'); ?>
	<?php $cs->registerPackage('select2'); ?>
</head>
<body>
	<?php
        $this->widget('application.extensions.booster.widgets.TbNavbar', array(
			'fixed'=>'top',
			'collapse'=>true,
			'type'=>'inverse',
			'fluid'=>true,
			'items'=>array(
				array(
					'class'=>'booster.widgets.TbMenu',
					'htmlOptions'=>array('class'=>'navbar-left', 'id'=>'topMenu'),
					'type'=>'navbar',
					'encodeLabel'=>false,
					'items'=>array(
						array(
							'label'=>'Jugadores',
							'url'=>array('jugador/admin'),
						),
						array(
							'label'=>'Ranking',
							'url'=>array('jugadorRanking/admin'),
						),
						array(
							'label'=>'Temp Ranking',
							'url'=>array('jugadorRankTemp/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
						array(
							'label'=>'PVP Sets',
							'url'=>array('pvpSet/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
						array(
							'label'=>'Torneos',
							'url'=>array('torneo/admin'),
						),
						array(
							'label'=>'Torn-Img',
							'url'=>array('torneoImagen/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
						array(
							'label'=>'Jug-Pj',
							'url'=>array('JugadorPersonaje/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
						array(
							'label'=>'Jug-Pos',
							'url'=>array('jugadorPosicionTorneo/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
						array(
							'label'=>'Personajes',
							'url'=>array('personaje/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
						array(
							'label'=>'Estados',
							'url'=>array('estado/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
						array(
							'label'=>'Países',
							'url'=>array('pais/admin'),
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
						),
					)
				),
                array(
                    'class'=>'booster.widgets.TbMenu',
                    'htmlOptions'=>array('class'=>'navbar-right', 'id'=>'topMenu'),
                    'type'=>'navbar',
                    'encodeLabel'=>false,
                    'items'=>array(
                        array('label'=>$user->getName(), 'icon'=>'user white', 'url'=>'#',
                    		'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
                            'itemOptions'=>array('id'=>'profileBtn'),
                            'submenuOptions'=>array('id'=>'profileBox', 'class'=>'pull-right'),
                            'items'=>array(
                                array('label'=>$this->renderPartial('//user/_flashCard', array(), true, false))
                            )
                        ),
                    )
                ),
            )
        ));
	?>
	<div class="container-fluid"> 
		<div id="main">
			<!-- BREADCRUMBS -->
			<?php
				if (isset($this->breadcrumbs)):
					$this->widget('booster.widgets.TbBreadcrumbs', array(
						'homeLink' => CHtml::link('Inicio', Yii::app()->homeUrl),
						'links' => $this->breadcrumbs,
				));
				endif
			?>
			<!-- ALERTS -->
			<?php
				$flashMessages=Yii::app()->user->getFlashes();
				if ($flashMessages) {
					foreach($flashMessages as $key => $message) {
						echo '<div class="alert in fade alert-'.$key.'">';
						echo '<a class="close" data-dismiss="alert" href="#">×</a>';
						echo $message;
						echo '</div>';
					}
				}
			?>
			<!-- CONTENT -->
			<?php echo $content; ?> 
		</div>
	</div>
	<div class="footer"> 
		<div class="container-fluid">
			<p>SSBM Venezuela 2015</p>
		</div>    
	</div>
</body>