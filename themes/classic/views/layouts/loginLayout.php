<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
        <?php  
            $baseUrl = Yii::app()->baseUrl; 
            $themeUrl = Yii::app()->theme->baseUrl; 
            $cs = Yii::app()->getClientScript();
            $user = Yii::app()->getUser();
        ?>

    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <!-- Titulo de página -->
    <title><?php echo CHtml::encode($this->pageTitle); ?></title> 
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- CSS
    ================================================== -->
    
   <!-- JS
   ================================================== -->   
   <!-- Favicon
   ================================================== -->
   <link rel="shortcut icon" href="<?php echo $baseUrl; ?>/images/favicon.ico">

</head>
    <body>            
               <!-- CONTAINER -->
               <div class="container-fluid">         
                        <!-- CONTENT -->
                        <?php echo $content; ?>
               </div>   
    </body>
</html>
