<?php

/**
 * @license LGPLv3, http://www.gnu.org/licenses/lgpl.html
 * @copyright Aimeos (aimeos.org), 2015
 * @package Client
 * @subpackage Html
 */


/**
 * Default implementation of the checkout confirm order HTML client.
 *
 * @package Client
 * @subpackage Html
 */
class Client_Html_Checkout_Confirm_Order_Default
	extends Client_Html_Abstract
{
	/** client/html/checkout/confirm/order/default/subparts
	 * List of HTML sub-clients rendered within the checkout confirm order section
	 *
	 * The output of the frontend is composed of the code generated by the HTML
	 * clients. Each HTML client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain HTML clients themselves and therefore a
	 * hierarchical tree of HTML clients is composed. Each HTML client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the HTML code generated by the parent is printed, then
	 * the HTML code of its sub-clients. The order of the HTML sub-clients
	 * determines the order of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the order of the output by reordering the subparts:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural HTML, the layout defined via CSS
	 * should support adding, removing or reordering content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2015.02
	 * @category Developer
	 */
	private $_subPartPath = 'client/html/checkout/confirm/order/default/subparts';

	/** client/html/checkout/confirm/order/address/name
	 * Name of the address part used by the checkout confirm order client implementation
	 *
	 * Use "Myname" if your class is named "Client_Html_Checkout_Confirm_Details_Address_Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2015.02
	 * @category Developer
	 */

	/** client/html/checkout/confirm/order/service/name
	 * Name of the service part used by the checkout confirm order client implementation
	 *
	 * Use "Myname" if your class is named "Client_Html_Checkout_Confirm_Details_Service_Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2015.02
	 * @category Developer
	 */

	/** client/html/checkout/confirm/order/coupon/name
	 * Name of the coupon part used by the checkout confirm order client implementation
	 *
	 * Use "Myname" if your class is named "Client_Html_Checkout_Confirm_Details_Coupon_Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2014.05
	 * @category Developer
	 */

	/** client/html/checkout/confirm/order/detail/name
	 * Name of the detail part used by the checkout confirm order client implementation
	 *
	 * Use "Myname" if your class is named "Client_Html_Checkout_Confirm_Details_Detail_Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the client class name
	 * @since 2015.02
	 * @category Developer
	 */
	private $_subPartNames = array( 'address', 'service', 'coupon', 'detail' );

	private $_cache;


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string HTML code
	 */
	public function getBody( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->getView();
		$view = $this->_setViewParams( $view, $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getBody( $uid, $tags, $expire );
		}
		$view->orderBody = $html;

		/** client/html/checkout/confirm/order/default/template-body
		 * Relative path to the HTML body template of the checkout confirm order client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the layouts directory (usually in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page body
		 * @since 2015.02
		 * @category Developer
		 * @see client/html/checkout/confirm/order/default/template-header
		 */
		$tplconf = 'client/html/checkout/confirm/order/default/template-body';
		$default = 'checkout/confirm/order-body-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the HTML string for insertion into the header.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return string String including HTML tags for the header
	 */
	public function getHeader( $uid = '', array &$tags = array(), &$expire = null )
	{
		$view = $this->getView();
		$view = $this->_setViewParams( $view, $tags, $expire );

		$html = '';
		foreach( $this->_getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->getHeader( $uid, $tags, $expire );
		}
		$view->orderHeader = $html;

		/** client/html/checkout/confirm/order/default/template-header
		 * Relative path to the HTML header template of the checkout confirm order client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the HTML code that is inserted into the HTML page header
		 * of the rendered page in the frontend. The configuration string is the
		 * path to the template file relative to the layouts directory (usually
		 * in client/html/layouts).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page head
		 * @since 2015.02
		 * @category Developer
		 * @see client/html/checkout/confirm/order/default/template-body
		 */
		$tplconf = 'client/html/checkout/confirm/order/default/template-header';
		$default = 'checkout/confirm/order-header-default.html';

		return $view->render( $this->_getTemplate( $tplconf, $default ) );
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return Client_Html_Interface Sub-client object
	 */
	public function getSubClient( $type, $name = null )
	{
		return $this->_createSubClient( 'checkout/confirm/order/' . $type, $name );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of HTML client names
	 */
	protected function _getSubClientNames()
	{
		return $this->_getContext()->getConfig()->get( $this->_subPartPath, $this->_subPartNames );
	}


	/**
	 * Sets the necessary parameter values in the view.
	 *
	 * @param MW_View_Interface $view The view object which generates the HTML output
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return MW_View_Interface Modified view object
	 */
	protected function _setViewParams( MW_View_Interface $view, array &$tags = array(), &$expire = null )
	{
		if( !isset( $this->_cache ) )
		{
			if( isset( $view->confirmOrderItem ) )
			{
				$context = $this->_getContext();
				$manager = MShop_Factory::createManager( $context, 'order/base' );

				$view->summaryBasket = $manager->load( $view->confirmOrderItem->getBaseId() );
			}

			$this->_cache = $view;
		}

		return $this->_cache;
	}
}