<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use \lithium\net\http\Router;
use \lithium\core\Environment;
use lithium\action\Response;

/**
 * Uncomment the line below to enable routing for admin actions.
 * @todo Implement me.
 */
// Router::namespace('/admin', array('admin' => true));

$base = MINERVA_BASE_URL;
$admin_prefix = MINERVA_ADMIN_PREFIX;


/**
 * Handles broken URL parsers by matching method URLs with no closing ) and redirecting.
 */
Router::connect("{$base}/{:args}\(", array(), function($request) {
	return new Response(array('location' => "{$request->url})"));
});

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'view', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.html.php)...
*/
Router::connect("{$base}", array('library' => 'minerva', 'controller' => 'pages', 'action' => 'view', 'home'));

// and this is for the other static pages
Router::connect("{$base}/page/{:args}", array('controller' => 'pages', 'action' => 'view'));

Router::connect("{$base}/{$admin_prefix}", array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'pages', 'action' => 'view', 'home'));


/**
 * Connect the user stuff so people can login, logout, and register
*/
Router::connect("{$base}/register", array('library' => 'minerva', 'controller' => 'users', 'action' => 'register'));
Router::connect("{$base}/login", array('library' => 'minerva', 'controller' => 'users', 'action' => 'login'));
Router::connect("{$base}/logout", array('library' => 'minerva', 'controller' => 'users', 'action' => 'logout'));
Router::connect("{$base}/users/register", array('library' => 'minerva', 'controller' => 'users', 'action' => 'register'));
Router::connect("{$base}/users/login", array('library' => 'minerva', 'controller' => 'users', 'action' => 'login'));
Router::connect("{$base}/users/logout", array('library' => 'minerva', 'controller' => 'users', 'action' => 'logout'));
/**
 * Also, the admin routes for users controller
*/
Router::connect("{$base}/{$admin_prefix}/register", array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'users', 'action' => 'register'));
Router::connect("{$base}/{$admin_prefix}/login", array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'users', 'action' => 'login'));
Router::connect("{$base}/{$admin_prefix}/logout", array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'users', 'action' => 'logout'));
Router::connect("{$base}/{$admin_prefix}/users/register", array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'users', 'action' => 'register'));
Router::connect("{$base}/{$admin_prefix}/users/login", array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'users', 'action' => 'login'));
Router::connect("{$base}/{$admin_prefix}/users/logout", array('admin' => 'admin', 'library' => 'minerva', 'controller' => 'users', 'action' => 'logout'));


/**
 * Connect the static blocks
*/
/*
Router::connect("{$base}/block/{:args}", array(
    //'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'view'
));
// the rest for blocks, admin stuff
Router::connect("{$base}/blocks/read/{:url}", array(
    'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'read'
));
Router::connect("{$base}/blocks/create/{:document_type}", array(
    'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'create'
));
Router::connect("{$base}/blocks/update/{:url}", array(
    'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'update'
));
Router::connect("{$base}/blocks/delete/{:id}", array(
    'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'delete'
));
// and for index pages
Router::connect("{$base}/blocks/index/{:document_type}", array(
    'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'index',
    'page' => 1,
    'limit' => 10
));
Router::connect("{$base}/blocks/index/{:document_type}/page:{:page:[0-9]+}", array(
    'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'index',
    'page' => 1
));
Router::connect("{$base}/blocks/index/{:document_type}/page:{:page}/limit:{:limit}", array(
    'admin' => true,
    'controller' => 'minerva.blocks',
    'action' => 'index',
    'page' => 1,
    'limit' => 10
));
Router::connect("{$base}/blocks/{:action}/{:args}", array(
    'admin' => true,
    'controller' => 'minerva.blocks'
));


*/

/*
 // an example using 'layoute' and 'template'
Router::connect('/custom', array(
    'admin' => 'admin',
    'library' => 'minerva',
    'controller' => 'pages',
    'action' => 'index',
    'layout' => 'minerva.default',
    'template' => 'minerva.create'
));
*/

// Admin create routes.
// The routes below won't work for create, it must see {:document_type} as {:url} (because it comes first), which we want for read, update, delete... and normally "create" wouldn't have anything after it in a typical app... we don't want to call the param "url" when it comes to "create" so we need these routes to give it the name of "document_type"
Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/create/{:document_type}", array(
    'library' => 'minerva',
    'action' => 'create'
));

Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/create", array(
    'library' => 'minerva',
    'action' => 'create'
));

// Default Admin Routes
Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}/{:document_type}/page:{:page:[0-9]+}/limit:{:limit:[0-9]+}", array(
    'library' => 'minerva'
));

Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}/{:document_type}/page:{:page:[0-9]+}", array(
    'library' => 'minerva'
));

// the following two routes are for pagination of anything else really, but notably a URL like: /minerva/pages/page:1/limit:1 or /minerva/pages/page:1
Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}/page:{:page:[0-9]+}/limit:{:limit:[0-9]+}", array(
    'library' => 'minerva'
));
Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}/page:{:page:[0-9]+}", array(
    'library' => 'minerva'
));

// all documents will have a unique URL even if it's the MongoId just copied over into that field
Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}/{:url}", array(
    'library' => 'minerva'
));

Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}/{:document_type}", array(
    'library' => 'minerva'
));

Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}/{:args}", array(
    'library' => 'minerva'
));

// ending with the least sepcific
Router::connect("{$base}/{:admin:$admin_prefix}/{:controller}/{:action}", array(
    'library' => 'minerva'
));

// Non-admin Default Routes
Router::connect("{$base}/{:controller}/{:action}/{:url}", array(
    'library' => 'minerva'
));
Router::connect("{$base}/{:controller}/{:action}/{:id}", array(
    'library' => 'minerva'
));
Router::connect("{$base}/{:controller}/{:action}/{:args}", array(
    'library' => 'minerva'
));
Router::connect("{$base}/{:controller}/{:action}", array(
    'library' => 'minerva'
));

/**
 * Connect the testing routes.
 */
/* TODO: specific minerva test dashboard?
//if (!Environment::is('production')) {
	Router::connect('/test/{:args}', array('controller' => '\lithium\test\Controller'));
	Router::connect('/test', array('controller' => '\lithium\test\Controller'));
//}
*/
?>