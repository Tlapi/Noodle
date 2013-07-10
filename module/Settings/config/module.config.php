<?php
// module/Settings/config/module.config.php:

namespace Settings;

return array(
		'controllers' => array(
				'invokables' => array(
						'Settings\Controller\Settings' => 'Settings\Controller\SettingsController',
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'settings' => __DIR__ . '/../view',
				),
				'strategies' => array(
						'ViewJsonStrategy',
				),
		),
		'router' => array(
				'routes' => array(
						'settings' => array(
								'type'    => 'literal',
								'options' => array(
										'route'    => '/settings',
										'defaults' => array(
												'controller' => 'Settings\Controller\Settings',
												'action'     => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										
								),
						),
				),
		),
);