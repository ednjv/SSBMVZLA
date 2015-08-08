<?php
/**
 *## TbMenu class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 */

Yii::import('application.extensions.widgets.TbBaseMenuCollapse');

/**
 * Bootstrap menu.
 *
 * @see <http://twitter.github.com/bootstrap/components.html#navs>
 *
 * @package booster.widgets.navigation
 */
class TbMenuCollapse extends TbBaseMenuCollapse {
	
	// Menu types.
	const TYPE_TABS = 'tabs';
	const TYPE_PILLS = 'pills';
	const TYPE_LIST = 'list';
	const TYPE_NAVBAR = 'navbar';

	/**
	 * @var string the menu type.
	 *
	 * Valid values are 'tabs', 'pills', or 'list'.
	 */
	public $type;

	/**
	 * @var string|array the scrollspy target or configuration.
	 */
	public $scrollspy;

	/**
	 * @var boolean indicates whether the menu should appear vertically stacked.
	 */
	public $stacked = false;
	
	/**
	 * @var boolean indicates whether the menu should be justified.
	 */
	public $justified = false;
	

	/**
	 * @var boolean indicates whether dropdowns should be dropups instead.
	 */
	public $dropup = false;

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init() {
		
		parent::init();

		$classes = array('nav');

		$validTypes = array(self::TYPE_TABS, self::TYPE_PILLS, self::TYPE_LIST, self::TYPE_NAVBAR);

		if (isset($this->type) && in_array($this->type, $validTypes)) {
			$classes[] = $this->type === self::TYPE_NAVBAR ? 'navbar-nav' : 'nav-' . $this->type;
		}

		if ($this->stacked && $this->type !== self::TYPE_LIST) {
			$classes[] = 'nav-stacked';
		}
		
		if ($this->justified && $this->type !== self::TYPE_LIST) {
			$classes[] = 'nav-justified';
		}

		if ($this->dropup === true) {
			$classes[] = 'dropup';
		}

		if (isset($this->scrollspy)) {
			$scrollspy = is_string($this->scrollspy) ? array('target' => $this->scrollspy) : $this->scrollspy;
			$this->widget('booster.widgets.TbScrollSpy', $scrollspy);
		}

		if (!empty($classes)) {
			$classes = implode(' ', $classes);
			if (isset($this->htmlOptions['class'])) {
				$this->htmlOptions['class'] .= ' ' . $classes;
			} else {
				$this->htmlOptions['class'] = $classes;
			}
		}
		$this->registerClientScript();
	}

	/**
	 *### .getDividerCssClass()
	 *
	 * Returns the divider css class.
	 *
	 * @return string the class name
	 */
	public function getDividerCssClass() {
		
		return (isset($this->type) && $this->type === self::TYPE_LIST) ? 'nav-divider' : 'divider-vertical';
	}

	/**
	 *### .getDropdownCssClass()
	 *
	 * Returns the dropdown css class.
	 *
	 * @return string the class name
	 */
	public function getDropdownCssClass() {
		
		return 'dropdown';
	}

	/**
	 *### .isVertical()
	 *
	 * Returns whether this is a vertical menu.
	 *
	 * @return boolean the result
	 */
	public function isVertical() {
		
		return isset($this->type) && $this->type === self::TYPE_LIST;
	}

	protected function registerClientScript()
	{
		$assets = Booster::getBooster()->cs;

		$assets->registerCss(__CLASS__ . '#menu-collapse','
					.caretright{
					    float: right;
					    margin-top: 8px;
					}
					 .nav-list li {
					    display: block;
					    width: 100%;
					 /* 
					    border-bottom: 1px solid #ACACAC;
					   background: #F4F4F4;*/
					}
					 .nav-list > li > ul > li{
					  /*  background: #fff;*/
					}
					.nav-list > li > ul{
						 background: none repeat scroll 0 0 #fff;
   						 box-shadow: 0 0 8px -2px #4b4b4a inset;
					}

					.nav-list > li > a {
					    color: #777;
					}

					.nav-sidebar > .nav-header {
					    background: none repeat scroll 0 0 #3b3b3b;
					    color: #e8e8e8 !important;
					    
					}

					.nav-list > li > a:hover {
					    background-color: #dedede;
					    color: #000;
					    border-left: 5px solid #777;
					}

					.nav-list > .active > a, .nav-list > .active > a {
					     border-left: 5px solid #67b0ef;
					     color: #000;
					}

					a, a:focus, a:active{
					outline: medium none !important;
					}
					');

		$assets->registerScript(
			__CLASS__ . '#menu-collapse' , '
                currentController = $(location).attr("href").split("/")[5].toLowerCase();
			    obj = $(".nav-list > li > a");
			    $.each( obj, function( key, value ) {
			        if(currentController==value.toString().split("/")[5].toLowerCase() && $(this).attr("data-toggle")!="collapse"){
			           $(this).parent().addClass("active");
			        }
			    });
				$("li.active").parents("ul").siblings("a").css("color", "black");
				$("li.active").parents("ul").siblings("a").css("border-left", "5px solid #777");

				$(".nav-list li .active").parent().addClass("in");
	    		$(".nav-list li .active").parent().css("height","auto");
	   		    $(".nav-list li .active").parent().siblings().removeClass("collapsed");
            ', CClientScript::POS_LOAD
		);
	}
	
}
