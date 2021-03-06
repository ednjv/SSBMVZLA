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

  <!-- CSS -->
  <?php $cs->registerCssFile($themeUrl . '/css/main.css'); ?>
  <?php $cs->registerCssFile($baseUrl . '/js/fancybox/source/jquery.fancybox.css'); ?>

  <!-- JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
	<?php $cs->registerScriptFile($baseUrl . '/js/fancybox/source/jquery.fancybox.js'); ?>
	<?php $cs->registerScriptFile($baseUrl . '/js/utilidades.js'); ?>
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
							'label'=>'Players',
							'url'=>array('jugador/admin'),
						),
						array(
							'label'=>'Ranking',
							'url'=>array('jugadorRanking/admin'),
						),
						array(
							'label'=>'Tournaments',
							'url'=>array('torneo/admin'),
						),
						array(
							'label'=>'Admin',
							'visible'=>Yii::app()->getUser()->checkAccess('Admin'),
							'items'=>array(
								array(
									'label'=>'Temp Ranking',
									'url'=>array('jugadorRankTemp/admin'),
								),
								array(
									'label'=>'PVP Sets',
									'url'=>array('pvpSet/admin'),
								),
								array(
									'label'=>'Torn-Img',
									'url'=>array('torneoImagen/admin'),
								),
								array(
									'label'=>'Jug-Pj',
									'url'=>array('JugadorPersonaje/admin'),
								),
								array(
									'label'=>'Jug-Pos',
									'url'=>array('jugadorPosicionTorneo/admin'),
								),
								array(
									'label'=>'Characters',
									'url'=>array('personaje/admin'),
								),
								array(
									'label'=>'States',
									'url'=>array('/estado'),
									'active'=>Yii::app()->controller->id=='estado'
								),
								array(
									'label'=>'Countries',
									'url'=>array('pais/admin'),
								),
								array(
									'label'=>'Challonge Import',
									'url'=>array('ApiChallonge/index'),
								)
							)
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
