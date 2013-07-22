<?php
// module/Filesystem/config/module.config.php:

namespace Filesystem;

return array(
		'controllers' => array(
				'invokables' => array(
						'Filesystem\Controller\Filesystem' => 'Filesystem\Controller\FilesystemController',
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'filesystem' => __DIR__ . '/../view',
				),
				'strategies' => array(
						'ViewJsonStrategy',
				),
		),
		'router' => array(
				'routes' => array(
						'filesystem' => array(
								'type'    => 'literal',
								'options' => array(
										'route'    => '/filesystem',
										'defaults' => array(
												'controller' => 'Filesystem\Controller\Filesystem',
												'action'     => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'upload' => array(
												'type' => 'segment',
												'options' => array(
														'route' => '/upload',
														'constraints' => array(
														),
														'defaults' => array(
																'action' => 'upload'
														)
												)
										),
								)
						),
				),
		),
);