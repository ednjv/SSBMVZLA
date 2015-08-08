<?php
$user = Yii::app()->getUser();
$userPhoto = Yii::app()->request->baseUrl . '/usuarios/' .$user->getPhoto();
echo ' <div class="navbar-content">
            <div class="row">
                <div class="col-sm-5">
                    <img src="'.$userPhoto.'"
                 width=103 />
                    <p class="text-center small">
                </div>
                <div class="col-sm-7">
                    <span>'.$user->getName().'</span>
                    <p class="text-muted small">
                    '.$user->getEmail().'</p>
                    <div class="divider"></div>
                     '.CHtml::link('<span class="glyphicon glyphicon-eye-open"></span>&nbspVer Perfil', array("/user/".$user->getId()), array('class'=>'btn btn-primary btn-sm')).'
                </div>
            </div>
        </div>
        <div class="navbar-footer">
            <div class="navbar-footer-content">
                <div class="row">
                    <div class="col-sm-6">
                         '.CHtml::link('<span class="glyphicon glyphicon-lock"></span>&nbspCambiar Contraseña', array("/user/updatePassword/".$user->getId()), array('class'=>'btn btn-default btn-sm')).'
                    </div>
                    <div class="col-sm-6">
                    '.CHtml::link('<span class="glyphicon glyphicon-off"></span>&nbspSalir', array("/site/logout"), array('class'=>'btn btn-default btn-sm pull-right')).'
                    </div>
                </div>
             </div>
        </div>';
        
?>