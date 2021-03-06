<?php
// module/Modules/config/module.config.php:

namespace Modules;

return array(
		'controllers' => array(
				'invokables' => array(
						'Modules\Controller\Modules' => 'Modules\Controller\ModulesController',
						'Modules\Controller\ModulesManager' => 'Modules\Controller\ModulesManagerController',
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'modules' => __DIR__ . '/../view',
				),
				'strategies' => array(
						'ViewJsonStrategy',
				),
		),
		'router' => array(
				'routes' => array(
						'modules-manager' => array(
								'type'    => 'literal',
								'options' => array(
										'route'    => '/modules-manager',
										'defaults' => array(
												'controller' => 'Modules\Controller\ModulesManager',
												'action'     => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'add' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/add',
														'constraints' => array(
														),
														'defaults' => array(
																'action' => 'add'
														)
												)
										),
										'add-repository' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/add-repository',
														'constraints' => array(
														),
														'defaults' => array(
																'action' => 'add-repository'
														)
												)
										),
										'edit-repository' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/edit-repository/:name',
														'constraints' => array(
																'name'     => '[a-zA-Z0-9_-]+'
														),
														'defaults' => array(
																'action' => 'edit-repository'
														)
												)
										),
								)
						),
						'modules' => array(
								'type'    => 'literal',
								'options' => array(
										'route'    => '/modules',
										'defaults' => array(
												'controller' => 'Modules\Controller\Modules',
												'action'     => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'add' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/add/[:name]',
														'constraints' => array(
																'name'     => '[a-zA-Z0-9_-]+'
														),
														'defaults' => array(
																'action' => 'add'
														)
												)
										),
										'show' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/show/[:name]',
														'constraints' => array(
																'name'     => '[a-zA-Z0-9_-]+'
														),
														'defaults' => array(
																'action' => 'show'
														)
												)
										),
										'edit' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/edit/:name/:id',
														'constraints' => array(
																'name'     => '[a-zA-Z0-9_-]+',
																'id'     => '[0-9]+'
														),
														'defaults' => array(
																'action' => 'edit'
														)
												),
												'may_terminate' => true,
												'child_routes' => array(
														'sheet' => array(
																'type' => 'segment',
																'options' => array(
																		'route' => '/sheet/[:sheet_name]',
																		'constraints' => array(
																				'name'     => '[a-zA-Z0-9_-]+'
																		),
																		'defaults' => array(
																				'action' => 'sheet'
																		)
																)
														),
												)
										),
										'delete' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/delete/:name/:id',
														'constraints' => array(
																'name'     => '[a-zA-Z0-9_-]+',
																'id'     => '[0-9]+'
														),
														'defaults' => array(
																'action' => 'delete'
														)
												),
												'may_terminate' => true,
										),
								),
						),
				),
		),
);