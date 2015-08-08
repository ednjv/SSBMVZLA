<?php
/*## TbToggleNavbar class file.
 *
 */

/*
* LAYOUT STRUCTURE
* <div id="mainwrap">
*	<div id="sidebar"></div>
*   <div id="main"></div>
* </div>
*/


Yii::import('booster.widgets.TbNavbar');




/**
 * Bootstrap navigation bar widget.
 */
class TbToggleNavbar extends TbNavbar
{
	/**
	 * @var boolean whether to enable toggleable sidebarmenu. Default to true.
	 */
	public $toggleSideBar=true;

	/**
	 * @var string wrapper element Id.
	 */
	public $wrapper = 'mainwrap';

	/**
	 * @var string sidebar element Id.
	 */
	public $sidebar = 'sidebar';

	/**
	 * @var string content element Id.
	 */
	public $content = 'main';

		/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run() {
		
		echo CHtml::openTag('nav', $this->htmlOptions);
		echo '<div class="' . $this->getContainerCssClass() . '">';
		
		echo '<div class="navbar-header">';
		if($this->collapse) {
			$this->controller->widget('booster.widgets.TbButton', array(
				'label' => '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>',
				'encodeLabel' => false,
				'htmlOptions' => array(
					'class' => 'navbar-toggle',
					'data-toggle' => 'collapse',
					'data-target' => '#'.self::CONTAINER_PREFIX.$this->id,
					)
				));
		}
		
		if ($this->brand !== false) {
			if ($this->brandUrl !== false) {
				if($this->toggleSideBar){
					echo 		
					'<button id="sidebar-toggle">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					';
				}
				echo CHtml::openTag('a', $this->brandOptions) . $this->brand . '</a>';
			} else {
				unset($this->brandOptions['href']); // spans cannot have a href attribute
				echo CHtml::openTag('span', $this->brandOptions) . $this->brand . '</span>';
			}
		}
		echo '</div>';
		
		echo '<div class="collapse navbar-collapse" id="'.self::CONTAINER_PREFIX.$this->id.'">';
		foreach ($this->items as $item) {
			if (is_string($item)) {
				echo $item;
			} else {
				if (isset($item['class'])) {
					$className = $item['class'];
					unset($item['class']);

					$this->controller->widget($className, $item);
				}
			}
		}
		echo '</div></div></nav>';

		$this->registerClientScript();
	}


	/**
	 * Publishes and registers the necessary script files.
	 */
	protected function registerClientScript()
	{
		$assets = Booster::getBooster()->cs;

		$assets->registerCss(__CLASS__ . '#sidebar-toggle','
					#'.$this->wrapper.'.toggled #'.$this->sidebar.' {
					    width: 0px;
					}
					#'.$this->wrapper.'.toggled #'.$this->content.' {
					   width: 100%;
					   margin-left: 0px;
					}
					');

		$assets->registerScript(
			__CLASS__ . '#sidebar-toggle' , '
                $("#sidebar-toggle").click(function(){  
                    $("#'.$this->wrapper.'").toggleClass("toggled");  
                });
            ', CClientScript::POS_LOAD
		);
	}

}
