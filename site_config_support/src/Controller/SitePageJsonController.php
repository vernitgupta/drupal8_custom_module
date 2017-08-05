<?php
/**
 * @file
 * Contains \Drupal\site_config_support\Controller\PageJsonController.
 */
namespace Drupal\site_config_support\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Controller routines for site_config_support routes.
 */
class SitePageJsonController extends ControllerBase {
  public function sitePageJson($siteapikey, $nid) {
    $apiKey = \Drupal::state()->get('siteapikey');	 //Get siteapikey
	$nodeData = Node::load($nid);
	
	if (($siteapikey != $apiKey) || !isset($nodeData) || $nodeData->getType() != 'page') {
	  // Invalid site API key , so deny access. The parameters will be in
      // the watchdog's URL for the administrator to check.
      throw new AccessDeniedHttpException();
	} else {
	  $serializer = \Drupal::service('serializer');
	  return array(
        '#markup' => $serializer->serialize($nodeData, 'json', ['plugin_id' => 'entity']),
      );
	}
  }
}