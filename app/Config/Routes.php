<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/documentation', 'Home::documentation');
$routes->get('/download', 'Home::download');
$routes->get('/explore', 'Home::explore');
$routes->get('/explore/data', 'Home::exploreData');
$routes->get('/advanced-search', 'Home::advancedSearch');
$routes->get('/advanced-search/data', 'Home::advancedSearchData');
$routes->get('/advanced-search/export', 'Home::advancedSearchExport');
$routes->get('/blast', 'Home::blast');
$routes->get('/entry/(:any)', 'Home::entry/$1');
$routes->get('/assembly/(:any)', 'Home::biologicalAssembly/$1');
$routes->post('/run', 'Project::create');
$routes->get('/project/(:any)', 'Project::id/$1');
$routes->get('/export/pymol/(:any)', 'Export::pymol/$1');
$routes->get('/export/pdb-to-pymol/(:any)', 'Export::pdb_to_pymol/$1');