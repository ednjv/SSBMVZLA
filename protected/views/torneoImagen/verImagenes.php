<?php
    $baseUrl=Yii::app()->baseUrl;
?>

<link rel="stylesheet" href="<?php echo $baseUrl . '/js/CSS3FluidParallaxSlideshow/css/style.css'?>"></link>
<!-- <script type="text/javascript" async="" src="<?php echo $baseUrl . '/js/jquery.elevatezoom.min.js'?>"></script> !-->

<div class="sp-slideshow">
	<?php
		$i=1;
		foreach ($arrImagenes as $key => $value) {
			if($i==1){
				echo "
				<input id='button-$i' type='radio' name='radio-set' class='sp-selector-$i' checked='checked' />
				";
			}else{
				echo "
				<input id='button-$i' type='radio' name='radio-set' class='sp-selector-$i' />
				"; 
			}
		echo "
		<label for='button-$i' class='button-label-$i'></label>
		<label for='button-$i' class='sp-arrow sp-a$i'></label>";
	?>
	<?php $i++; } ?>
	<div class='sp-content'>
		<div class='sp-parallax-bg'></div>
		<ul class='sp-slider clearfix'>
			<?php
				$i=1;
				foreach ($arrImagenes as $key => $value) {
				echo '<li><img id="torneo'.$i.'" src="'.$value['imagen'].'" alt="" /></li>';
				//echo '<script>$("#torneo'.$i.'").elevateZoom({ easing : true });</script>';
			} ?>
		</ul>
	</div><!-- sp-content -->
</div><!-- sp-slideshow -->