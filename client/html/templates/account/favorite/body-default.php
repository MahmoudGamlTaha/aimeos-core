<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2014
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

$enc = $this->encoder();
$favParams = $this->get( 'favoriteParams', array() );
$listItems = $this->get( 'favoriteListItems', array() );
$productItems = $this->get( 'favoriteProductItems', array() );

/** client/html/account/favorite/url/target
 * Destination of the URL where the controller specified in the URL is known
 *
 * The destination can be a page ID like in a content management system or the
 * module of a software development framework. This "target" must contain or know
 * the controller that should be called by the generated URL.
 *
 * @param string Destination of the URL
 * @since 2014.09
 * @category Developer
 * @see client/html/account/favorite/url/controller
 * @see client/html/account/favorite/url/action
 * @see client/html/account/favorite/url/config
 */
$favTarget = $this->config( 'client/html/account/favorite/url/target' );

/** client/html/account/favorite/url/controller
 * Name of the controller whose action should be called
 *
 * In Model-View-Controller (MVC) applications, the controller contains the methods
 * that create parts of the output displayed in the generated HTML page. Controller
 * names are usually alpha-numeric.
 *
 * @param string Name of the controller
 * @since 2014.09
 * @category Developer
 * @see client/html/account/favorite/url/target
 * @see client/html/account/favorite/url/action
 * @see client/html/account/favorite/url/config
 */
$favController = $this->config( 'client/html/account/favorite/url/controller', 'account' );

/** client/html/account/favorite/url/action
 * Name of the action that should create the output
 *
 * In Model-View-Controller (MVC) applications, actions are the methods of a
 * controller that create parts of the output displayed in the generated HTML page.
 * Action names are usually alpha-numeric.
 *
 * @param string Name of the action
 * @since 2014.09
 * @category Developer
 * @see client/html/account/favorite/url/target
 * @see client/html/account/favorite/url/controller
 * @see client/html/account/favorite/url/config
 */
$favAction = $this->config( 'client/html/account/favorite/url/action', 'favorite' );

/** client/html/account/favorite/url/config
 * Associative list of configuration options used for generating the URL
 *
 * You can specify additional options as key/value pairs used when generating
 * the URLs, like
 *
 *  client/html/<clientname>/url/config = array( 'absoluteUri' => true )
 *
 * The available key/value pairs depend on the application that embeds the e-commerce
 * framework. This is because the infrastructure of the application is used for
 * generating the URLs. The full list of available config options is referenced
 * in the "see also" section of this page.
 *
 * @param string Associative list of configuration options
 * @since 2014.09
 * @category Developer
 * @see client/html/account/favorite/url/target
 * @see client/html/account/favorite/url/controller
 * @see client/html/account/favorite/url/action
 * @see client/html/url/config
 */
$favConfig = $this->config( 'client/html/account/favorite/url/config', array() );

$detailTarget = $this->config( 'client/html/catalog/detail/url/target' );
$detailController = $this->config( 'client/html/catalog/detail/url/controller', 'catalog' );
$detailAction = $this->config( 'client/html/catalog/detail/url/action', 'detail' );
$detailConfig = $this->config( 'client/html/catalog/detail/url/config', array() );

?>
<section class="aimeos account-favorite">
<?php if( ( $errors = $this->get( 'favoriteErrorList', array() ) ) !== array() ) : ?>
	<ul class="error-list">
<?php	foreach( $errors as $error ) : ?>
			<li class="error-item"><?php echo $enc->html( $error ); ?></li>
<?php	endforeach; ?>
	</ul>
<?php endif; ?>

<?php if( !empty( $listItems ) ) : ?>
	<h2 class="header"><?php echo $this->translate( 'client', 'Favorite products' ); ?></h2>
<?php	if( $this->get( 'favoritePageLast', 1 ) > 1 ) : ?>
	<nav class="pagination">
		<div class="sort">
			<span>&nbsp;</span>
		</div>
		<div class="browser">
			<a class="first" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePageFirst ) + $favParams, array(), $favConfig ) ); ?>"><?php echo $enc->html( $this->translate( 'client', '◀◀' ), $enc::TRUST ); ?></a>
			<a class="prev" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePagePrev ) + $favParams, array(), $favConfig ) ); ?>" rel="prev"><?php echo $enc->html( $this->translate( 'client', '◀' ), $enc::TRUST ); ?></a>
			<span><?php echo $enc->html( sprintf( $this->translate( 'client', 'Page %1$d of %2$d' ), $this->get( 'favoritePageCurr', 1 ), $this->get( 'favoritePageLast', 1 ) ) ); ?></span>
			<a class="next" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePageNext ) + $favParams, array(), $favConfig ) ); ?>" rel="next"><?php echo $enc->html( $this->translate( 'client', '▶' ), $enc::TRUST ); ?></a>
			<a class="last" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePageLast ) + $favParams, array(), $favConfig ) ); ?>"><?php echo $enc->html( $this->translate( 'client', '▶▶' ), $enc::TRUST ); ?></a>
		</div>
	</nav>
<?php	endif; ?>

	<ul class="favorite-items">
<?php	foreach( $listItems as $listItem ) : $id = $listItem->getRefId(); ?>
<?php		if( isset( $productItems[$id] ) ) : $productItem = $productItems[$id]; ?>
		<li class="favorite-item">
<?php			$params = array( 'd_name' => $productItem->getName( 'url' ), 'd_prodid' => $productItem->getId() ); ?>
			<a class="modify" href="<?php echo $this->url( $favTarget, $favController, $favAction, array( 'fav_action' => 'delete', 'fav_id' => $id ) + $favParams, array(), $favConfig ); ?>"><?php echo $this->translate( 'client', 'X' ); ?></a>
			<a href="<?php echo $enc->attr( $this->url( $detailTarget, $detailController, $detailAction, $params, array(), $detailConfig ) ); ?>">
<?php			$mediaItems = $productItem->getRefItems( 'media', 'default', 'default' ); ?>
<?php			if( ( $mediaItem = reset( $mediaItems ) ) !== false ) : ?>
				<div class="media-item" style="background-image: url('<?php echo $this->content( $mediaItem->getPreview() ); ?>')"></div>
<?php			else : ?>
				<div class="media-item"></div>
<?php			endif; ?>
				<h3 class="name"><?php echo $enc->html( $productItem->getName(), $enc::TRUST ); ?></h3>
				<div class="price-list">
<?php			echo $this->partial( $this->config( 'client/html/common/partials/price', 'common/partials/price-default.php' ), array( 'prices' => $productItem->getRefItems( 'price', null, 'default' ) ) ); ?>
				</div>
			</a>
		</li>
<?php		endif; ?>
<?php	endforeach; ?>
	</ul>

<?php	if( $this->get( 'favoritePageLast', 1 ) > 1 ) : ?>
	<nav class="pagination">
		<div class="sort">
			<span>&nbsp;</span>
		</div>
		<div class="browser">
			<a class="first" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePageFirst ) + $favParams, array(), $favConfig ) ); ?>"><?php echo $enc->html( $this->translate( 'client', '◀◀' ), $enc::TRUST ); ?></a>
			<a class="prev" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePagePrev ) + $favParams, array(), $favConfig ) ); ?>" rel="prev"><?php echo $enc->html( $this->translate( 'client', '◀' ), $enc::TRUST ); ?></a>
			<span><?php echo $enc->html( sprintf( $this->translate( 'client', 'Page %1$d of %2$d' ), $this->get( 'favoritePageCurr', 1 ), $this->get( 'favoritePageLast', 1 ) ) ); ?></span>
			<a class="next" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePageNext ) + $favParams, array(), $favConfig ) ); ?>" rel="next"><?php echo $enc->html( $this->translate( 'client', '▶' ), $enc::TRUST ); ?></a>
			<a class="last" href="<?php echo $enc->attr( $this->url( $favTarget, $favController, $favAction, array( 'fav_page' => $this->favoritePageLast ) + $favParams, array(), $favConfig ) ); ?>"><?php echo $enc->html( $this->translate( 'client', '▶▶' ), $enc::TRUST ); ?></a>
		</div>
	</nav>
<?php	endif; ?>
<?php endif; ?>
<?php echo $this->get( 'favoriteBody' ); ?>
</section>