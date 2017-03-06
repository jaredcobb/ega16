<?php
/**
 * A walker for the foundation topbar
 *
 * @package ega16
 */

/**
 * Foundation_Topbar_Walker
 *
 * @uses Walker_Nav_Menu
 */
class EGA16_Foundation_Topbar_Walker extends Walker_Nav_Menu {

	/**
	 * Flag child elements that have children
	 *
	 * Setting the children to true or false. if there are child
	 * elements then we are going to call the method below and
	 * make sure to add class of menu
	 *
	 * @param object $element           Data object.
	 * @param array  $children_elements List of elements to continue traversing.
	 * @param int    $max_depth         Max depth to traverse.
	 * @param int    $depth             Depth of current element.
	 * @param array  $args              An array of arguments.
	 * @param string $output            Passed by reference. Used to append additional content.
	 * @access public
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$GLOBALS['dd_children'] = ( isset( $children_elements[ $element->ID ] ) ) ? 1 : 0;
		$GLOBALS['dd_depth'] = (int) $depth;
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * The $args parameter holds additional values that may be used with the child
	 * class methods. This method finishes the list at the end of output of the elements.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of the item.
	 * @param array  $args   An array of additional arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= $indent . '<ul class="menu">';
	}
}
