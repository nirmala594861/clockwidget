<?php

namespace Drupal\clockwidget\Plugin\rest\resource;

/* this service is for calling timezone */
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "core1activity_webrest",
 *   label = @Translation("Coreoneactivity POST API"),
 *   uri_paths = {
 *     "canonical" = "/coreoneactivityrest",
 *     "create" = "/coreoneactivityrest/createcoreoneactivity"
 *   }
 * )
 */
class GetUserTimezone extends ResourceBase {


  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */

  protected $currentUser;

  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $config
   *   A configuration array which contains the information about the plugin instance.
   * @param string $module_id
   *   The module_id for the plugin instance.
   * @param mixed $module_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   A currently logged user instance.
   *    * Responds to entity GET requests.
   * @param string $uid
   *   The API name from where to get the data.
   *
   * @return \Drupal\rest\ModifiedResourceResponse
   *   Return all API versions.
   */

  /**
   * Responds to entity GET requests.
   *
   * @param string $uid
   *   The API name from where to get the data.
   *
   * @return \Drupal\rest\ModifiedResourceResponse
   *   Return all API versions.
   */
  public function __construct(array $config, $module_id, $module_definition, array $serializer_formats, LoggerInterface $logger, AccountProxyInterface $currentUser) {
    parent::__construct($config, $module_id, $module_definition, $serializer_formats, $logger);
    $this->currentUser = $currentUser;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $config, $module_id, $module_definition) {
    return new static(
     $config,
     $module_id,
     $module_definition,
     $container->getParameter('serializer.formats'),
     $container->get('logger.factory')->get('chapters'),
     $container->get('current_user')
    );
  }

  /**
   * Responds to GET request.
   * Returns a list of taxonomy terms.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   * Throws exception expected.
   */

  /**
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response objects
   */
  public function post(Request $request) {

    try {
      $the_json = json_decode($request->getContent(), TRUE);

      return new JsonResponse($response, 200);

    }

    catch (EntityStorageException $e) {
      throw new HttpException(500, 'Internal Server Error', $e);
    }
  }

}
