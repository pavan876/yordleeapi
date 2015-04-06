<?php
return array (
  'router' => 
  array (
    'routes' => 
    array (
      'home' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/',
          'defaults' => 
          array (
            'controller' => 'Application\\Controller\\Index',
            'action' => 'index',
          ),
        ),
      ),
      'application' => 
      array (
        'type' => 'Literal',
        'options' => 
        array (
          'route' => '/application',
          'defaults' => 
          array (
            '__NAMESPACE__' => 'Application\\Controller',
            'controller' => 'Index',
            'action' => 'index',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'default' => 
          array (
            'type' => 'Segment',
            'options' => 
            array (
              'route' => '/[:controller[/:action]]',
              'constraints' => 
              array (
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
              ),
              'defaults' => 
              array (
              ),
            ),
          ),
        ),
      ),
      'zf-apigility' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/apigility',
        ),
        'may_terminate' => false,
        'child_routes' => 
        array (
          'documentation' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Segment',
            'options' => 
            array (
              'route' => '/documentation[/:api[-v:version][/:service]]',
              'constraints' => 
              array (
                'api' => '[a-zA-Z][a-zA-Z0-9_]+',
              ),
              'defaults' => 
              array (
                'controller' => 'ZF\\Apigility\\Documentation\\Controller',
                'action' => 'show',
              ),
            ),
          ),
        ),
      ),
      'oauth' => 
      array (
        'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
        'options' => 
        array (
          'route' => '/oauth',
          'defaults' => 
          array (
            'controller' => 'ZF\\OAuth2\\Controller\\Auth',
            'action' => 'token',
          ),
        ),
        'may_terminate' => true,
        'child_routes' => 
        array (
          'authorize' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/authorize',
              'defaults' => 
              array (
                'action' => 'authorize',
              ),
            ),
          ),
          'resource' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/resource',
              'defaults' => 
              array (
                'action' => 'resource',
              ),
            ),
          ),
          'code' => 
          array (
            'type' => 'Zend\\Mvc\\Router\\Http\\Literal',
            'options' => 
            array (
              'route' => '/receivecode',
              'defaults' => 
              array (
                'action' => 'receiveCode',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'service_manager' => 
  array (
    'abstract_factories' => 
    array (
      0 => 'Zend\\Cache\\Service\\StorageCacheAbstractServiceFactory',
      1 => 'Zend\\Db\\Adapter\\AdapterAbstractServiceFactory',
      2 => 'Zend\\Log\\LoggerAbstractServiceFactory',
      3 => 'Zend\\Db\\Adapter\\AdapterAbstractServiceFactory',
      4 => 'ZF\\Apigility\\DbConnectedResourceAbstractFactory',
      5 => 'ZF\\Apigility\\TableGatewayAbstractFactory',
    ),
    'aliases' => 
    array (
      'translator' => 'MvcTranslator',
      'mime_resolver' => 'AssetManager\\Service\\MimeResolver',
      'ZF\\ApiProblem\\ApiProblemListener' => 'ZF\\ApiProblem\\Listener\\ApiProblemListener',
      'ZF\\ApiProblem\\RenderErrorListener' => 'ZF\\ApiProblem\\Listener\\RenderErrorListener',
      'ZF\\ApiProblem\\ApiProblemRenderer' => 'ZF\\ApiProblem\\View\\ApiProblemRenderer',
      'ZF\\ApiProblem\\ApiProblemStrategy' => 'ZF\\ApiProblem\\View\\ApiProblemStrategy',
      'authentication' => 'ZF\\MvcAuth\\Authentication',
      'authorization' => 'ZF\\MvcAuth\\Authorization\\AuthorizationInterface',
      'ZF\\MvcAuth\\Authorization\\AuthorizationInterface' => 'ZF\\MvcAuth\\Authorization\\AclAuthorization',
    ),
    'invokables' => 
    array (
      'ZF\\Apigility\\MvcAuth\\UnauthenticatedListener' => 'ZF\\Apigility\\MvcAuth\\UnauthenticatedListener',
      'ZF\\Apigility\\MvcAuth\\UnauthorizedListener' => 'ZF\\Apigility\\MvcAuth\\UnauthorizedListener',
      'AssetManager\\Service\\MimeResolver' => 'AssetManager\\Service\\MimeResolver',
      'ZF\\MvcAuth\\Authentication\\DefaultAuthenticationPostListener' => 'ZF\\MvcAuth\\Authentication\\DefaultAuthenticationPostListener',
      'ZF\\MvcAuth\\Authorization\\DefaultAuthorizationPostListener' => 'ZF\\MvcAuth\\Authorization\\DefaultAuthorizationPostListener',
      'ZF\\Rest\\RestParametersListener' => 'ZF\\Rest\\Listener\\RestParametersListener',
      'ZF\\Versioning\\VersionListener' => 'ZF\\Versioning\\VersionListener',
    ),
    'factories' => 
    array (
      'AssetManager\\Service\\AssetManager' => 'AssetManager\\Service\\AssetManagerServiceFactory',
      'AssetManager\\Service\\AssetFilterManager' => 'AssetManager\\Service\\AssetFilterManagerServiceFactory',
      'AssetManager\\Service\\AssetCacheManager' => 'AssetManager\\Service\\AssetCacheManagerServiceFactory',
      'AssetManager\\Service\\AggregateResolver' => 'AssetManager\\Service\\AggregateResolverServiceFactory',
      'AssetManager\\Resolver\\MapResolver' => 'AssetManager\\Service\\MapResolverServiceFactory',
      'AssetManager\\Resolver\\PathStackResolver' => 'AssetManager\\Service\\PathStackResolverServiceFactory',
      'AssetManager\\Resolver\\PrioritizedPathsResolver' => 'AssetManager\\Service\\PrioritizedPathsResolverServiceFactory',
      'AssetManager\\Resolver\\CollectionResolver' => 'AssetManager\\Service\\CollectionResolverServiceFactory',
      'AssetManager\\Resolver\\ConcatResolver' => 'AssetManager\\Service\\ConcatResolverServiceFactory',
      'AssetManager\\Resolver\\AliasPathStackResolver' => 'AssetManager\\Service\\AliasPathStackResolverServiceFactory',
      'ZF\\ApiProblem\\Listener\\ApiProblemListener' => 'ZF\\ApiProblem\\Factory\\ApiProblemListenerFactory',
      'ZF\\ApiProblem\\Listener\\RenderErrorListener' => 'ZF\\ApiProblem\\Factory\\RenderErrorListenerFactory',
      'ZF\\ApiProblem\\Listener\\SendApiProblemResponseListener' => 'ZF\\ApiProblem\\Factory\\SendApiProblemResponseListenerFactory',
      'ZF\\ApiProblem\\View\\ApiProblemRenderer' => 'ZF\\ApiProblem\\Factory\\ApiProblemRendererFactory',
      'ZF\\ApiProblem\\View\\ApiProblemStrategy' => 'ZF\\ApiProblem\\Factory\\ApiProblemStrategyFactory',
      'ZF\\MvcAuth\\Authentication' => 'ZF\\MvcAuth\\Factory\\AuthenticationServiceFactory',
      'ZF\\MvcAuth\\Authentication\\DefaultAuthenticationListener' => 'ZF\\MvcAuth\\Factory\\DefaultAuthenticationListenerFactory',
      'ZF\\MvcAuth\\Authentication\\AuthHttpAdapter' => 'ZF\\MvcAuth\\Factory\\DefaultAuthHttpAdapterFactory',
      'ZF\\MvcAuth\\Authorization\\AclAuthorization' => 'ZF\\MvcAuth\\Factory\\AclAuthorizationFactory',
      'ZF\\MvcAuth\\Authorization\\DefaultAuthorizationListener' => 'ZF\\MvcAuth\\Factory\\DefaultAuthorizationListenerFactory',
      'ZF\\MvcAuth\\Authorization\\DefaultResourceResolverListener' => 'ZF\\MvcAuth\\Factory\\DefaultResourceResolverListenerFactory',
      'ZF\\OAuth2\\Adapter\\PdoAdapter' => 'ZF\\OAuth2\\Factory\\PdoAdapterFactory',
      'ZF\\OAuth2\\Adapter\\MongoAdapter' => 'ZF\\OAuth2\\Factory\\MongoAdapterFactory',
      'ZF\\OAuth2\\Service\\OAuth2Server' => 'ZF\\OAuth2\\Factory\\OAuth2ServerFactory',
      'Request' => 'ZF\\ContentNegotiation\\Factory\\RequestFactory',
      'ZF\\ContentNegotiation\\AcceptListener' => 'ZF\\ContentNegotiation\\Factory\\AcceptListenerFactory',
      'ZF\\ContentNegotiation\\AcceptFilterListener' => 'ZF\\ContentNegotiation\\Factory\\AcceptFilterListenerFactory',
      'ZF\\ContentNegotiation\\ContentTypeFilterListener' => 'ZF\\ContentNegotiation\\Factory\\ContentTypeFilterListenerFactory',
      'ZF\\ContentValidation\\ContentValidationListener' => 'ZF\\ContentValidation\\ContentValidationListenerFactory',
      'ZF\\Rest\\OptionsListener' => 'ZF\\Rest\\Factory\\OptionsListenerFactory',
    ),
  ),
  'translator' => 
  array (
    'locale' => 'en_US',
    'translation_file_patterns' => 
    array (
      0 => 
      array (
        'type' => 'gettext',
        'base_dir' => '/var/www/Intuit/module/Application/config/../language',
        'pattern' => '%s.mo',
      ),
    ),
  ),
  'controllers' => 
  array (
    'invokables' => 
    array (
      'Application\\Controller\\Index' => 'Application\\Controller\\IndexController',
      'ZF\\DevelopmentMode\\DevelopmentModeController' => 'ZF\\DevelopmentMode\\DevelopmentModeController',
    ),
    'factories' => 
    array (
      'ZF\\Apigility\\Documentation\\Controller' => 'ZF\\Apigility\\Documentation\\ControllerFactory',
      'AssetManager\\Controller\\Console' => 'AssetManager\\Controller\\ConsoleControllerFactory',
      'ZF\\OAuth2\\Controller\\Auth' => 'ZF\\OAuth2\\Factory\\AuthControllerFactory',
    ),
    'abstract_factories' => 
    array (
      0 => 'ZF\\Rest\\Factory\\RestControllerFactory',
      1 => 'ZF\\Rpc\\Factory\\RpcControllerFactory',
    ),
  ),
  'view_manager' => 
  array (
    'display_not_found_reason' => true,
    'display_exceptions' => false,
    'doctype' => 'HTML5',
    'not_found_template' => 'error/404',
    'exception_template' => 'error/index',
    'template_map' => 
    array (
      'layout/layout' => '/var/www/Intuit/module/Application/config/../view/layout/layout.phtml',
      'application/index/index' => '/var/www/Intuit/module/Application/config/../view/application/index/index.phtml',
      'error/404' => '/var/www/Intuit/module/Application/config/../view/error/404.phtml',
      'error/index' => '/var/www/Intuit/module/Application/config/../view/error/index.phtml',
      'oauth/authorize' => '/var/www/Intuit/vendor/zfcampus/zf-oauth2/config/../view/zf/auth/authorize.phtml',
      'oauth/receive-code' => '/var/www/Intuit/vendor/zfcampus/zf-oauth2/config/../view/zf/auth/receive-code.phtml',
    ),
    'template_path_stack' => 
    array (
      0 => '/var/www/Intuit/module/Application/config/../view',
      1 => '/var/www/Intuit/vendor/zfcampus/zf-apigility-documentation/config/../view',
      2 => '/var/www/Intuit/vendor/zfcampus/zf-oauth2/config/../view',
    ),
    'strategies' => 
    array (
      0 => 'ViewJsonStrategy',
    ),
  ),
  'console' => 
  array (
    'router' => 
    array (
      'routes' => 
      array (
        'development-disable' => 
        array (
          'options' => 
          array (
            'route' => 'development disable',
            'defaults' => 
            array (
              'controller' => 'ZF\\DevelopmentMode\\DevelopmentModeController',
              'action' => 'disable',
            ),
          ),
        ),
        'development-enable' => 
        array (
          'options' => 
          array (
            'route' => 'development enable',
            'defaults' => 
            array (
              'controller' => 'ZF\\DevelopmentMode\\DevelopmentModeController',
              'action' => 'enable',
            ),
          ),
        ),
        'AssetManager-warmup' => 
        array (
          'options' => 
          array (
            'route' => 'assetmanager warmup [--purge] [--verbose|-v]',
            'defaults' => 
            array (
              'controller' => 'AssetManager\\Controller\\Console',
              'action' => 'warmup',
            ),
          ),
        ),
      ),
    ),
  ),
  'asset_manager' => 
  array (
    'resolver_configs' => 
    array (
      'paths' => 
      array (
        0 => '/var/www/Intuit/vendor/zfcampus/zf-apigility/config/../asset',
      ),
    ),
    'clear_output_buffer' => true,
    'resolvers' => 
    array (
      'AssetManager\\Resolver\\MapResolver' => 3000,
      'AssetManager\\Resolver\\ConcatResolver' => 2500,
      'AssetManager\\Resolver\\CollectionResolver' => 2000,
      'AssetManager\\Resolver\\PrioritizedPathsResolver' => 1500,
      'AssetManager\\Resolver\\AliasPathStackResolver' => 1000,
      'AssetManager\\Resolver\\PathStackResolver' => 500,
    ),
  ),
  'zf-apigility' => 
  array (
    'db-connected' => 
    array (
    ),
  ),
  'zf-content-negotiation' => 
  array (
    'controllers' => 
    array (
      'ZF\\Apigility\\Documentation\\Controller' => 'Documentation',
    ),
    'accept_whitelist' => 
    array (
      'ZF\\Apigility\\Documentation\\Controller' => 
      array (
        0 => 'application/vnd.swagger+json',
        1 => 'application/json',
      ),
    ),
    'selectors' => 
    array (
      'Documentation' => 
      array (
        'Zend\\View\\Model\\ViewModel' => 
        array (
          0 => 'text/html',
          1 => 'application/xhtml+xml',
        ),
        'ZF\\Apigility\\Documentation\\JsonModel' => 
        array (
          0 => 'application/json',
        ),
      ),
      'HalJson' => 
      array (
        'ZF\\Hal\\View\\HalJsonModel' => 
        array (
          0 => 'application/json',
          1 => 'application/*+json',
        ),
      ),
      'Json' => 
      array (
        'ZF\\ContentNegotiation\\JsonModel' => 
        array (
          0 => 'application/json',
          1 => 'application/*+json',
        ),
      ),
    ),
    'ZF\\OAuth2\\Controller\\Auth' => 
    array (
      'ZF\\ContentNegotiation\\JsonModel' => 
      array (
        0 => 'application/json',
        1 => 'application/*+json',
      ),
      'Zend\\View\\Model\\ViewModel' => 
      array (
        0 => 'text/html',
        1 => 'application/xhtml+xml',
      ),
    ),
    'content_type_whitelist' => 
    array (
    ),
  ),
  'view_helpers' => 
  array (
    'invokables' => 
    array (
      'agacceptheaders' => 'ZF\\Apigility\\Documentation\\View\\AgAcceptHeaders',
      'agcontenttypeheaders' => 'ZF\\Apigility\\Documentation\\View\\AgContentTypeHeaders',
      'agservicepath' => 'ZF\\Apigility\\Documentation\\View\\AgServicePath',
      'agstatuscodes' => 'ZF\\Apigility\\Documentation\\View\\AgStatusCodes',
    ),
  ),
  'zf-api-problem' => 
  array (
  ),
  'zf-configuration' => 
  array (
    'config_file' => 'config/autoload/development.php',
  ),
  'zf-mvc-auth' => 
  array (
    'authentication' => 
    array (
    ),
    'authorization' => 
    array (
      'deny_by_default' => false,
    ),
  ),
  'zf-oauth2' => 
  array (
  ),
  'zf-hal' => 
  array (
    'renderer' => 
    array (
    ),
    'metadata_map' => 
    array (
    ),
  ),
  'filters' => 
  array (
    'aliases' => 
    array (
      'Zend\\Filter\\File\\RenameUpload' => 'filerenameupload',
    ),
    'factories' => 
    array (
      'filerenameupload' => 'ZF\\ContentNegotiation\\Factory\\RenameUploadFilterFactory',
    ),
  ),
  'validators' => 
  array (
    'aliases' => 
    array (
      'Zend\\Validator\\File\\UploadFile' => 'fileuploadfile',
    ),
    'factories' => 
    array (
      'fileuploadfile' => 'ZF\\ContentNegotiation\\Factory\\UploadFileValidatorFactory',
      'ZF\\ContentValidation\\Validator\\DbRecordExists' => 'ZF\\ContentValidation\\Validator\\Db\\RecordExistsFactory',
      'ZF\\ContentValidation\\Validator\\DbNoRecordExists' => 'ZF\\ContentValidation\\Validator\\Db\\NoRecordExistsFactory',
    ),
  ),
  'controller_plugins' => 
  array (
    'invokables' => 
    array (
      'routeParam' => 'ZF\\ContentNegotiation\\ControllerPlugin\\RouteParam',
      'queryParam' => 'ZF\\ContentNegotiation\\ControllerPlugin\\QueryParam',
      'bodyParam' => 'ZF\\ContentNegotiation\\ControllerPlugin\\BodyParam',
      'routeParams' => 'ZF\\ContentNegotiation\\ControllerPlugin\\RouteParams',
      'queryParams' => 'ZF\\ContentNegotiation\\ControllerPlugin\\QueryParams',
      'bodyParams' => 'ZF\\ContentNegotiation\\ControllerPlugin\\BodyParams',
    ),
  ),
  'input_filter_specs' => 
  array (
  ),
  'input_filters' => 
  array (
    'abstract_factories' => 
    array (
      0 => 'ZF\\ContentValidation\\InputFilter\\InputFilterAbstractServiceFactory',
    ),
  ),
  'zf-content-validation' => 
  array (
  ),
  'zf-rest' => 
  array (
  ),
  'zf-rpc' => 
  array (
  ),
  'zf-versioning' => 
  array (
    'content-type' => 
    array (
    ),
    'default_version' => 1,
    'uri' => 
    array (
    ),
  ),
);