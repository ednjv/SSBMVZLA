<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Create :type', array(':type'=>Rights::getAuthItemTypeName($_GET['type']))),
); ?>

<div class="createAuthItem">
            <?php $this->beginWidget('booster.widgets.TbPanel', array(
                'title' => Rights::getAuthItemTypeName($_GET['type']),
                'headerIcon' => 'icon-user ',
        )); ?>

	<?php $this->renderPartial('_form', array('model'=>$formModel)); ?>
    <?php $this->endContent(); ?>
</div>