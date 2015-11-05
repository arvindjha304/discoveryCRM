<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
		'modules'=>array(
				'Application',
		),

		'router' => array(
				'routes' => array(
						'home' => array(
							'type' => 'Zend\Mvc\Router\Http\Literal',
							'options' => array(
								'route'    => '/',
								'defaults' => array(
										'controller' => 'Application\Controller\Index',
										'action'     => 'index',
								),
							),
						),
                        'login' => array(
                            'type'    => 'Literal',
                            'options' => array(
                                'route'    => '/login',
                                'defaults' => array(
                                    '__NAMESPACE__' => 'Application\Controller',
                                    'controller'    => 'Index',
                                    'action'        => 'index',
                                ),
                            ),
                        ),
                    
                        'blog' => array(
                           'type'    => 'Segment',
                            'options' => array(
                                'route'    => '/[:controller[/:action]]',
                                'defaults' => array(
                                        '__NAMESPACE__' => 'Application\Controller',
                                        'controller'    => 'Index',
                                        'action'        => 'index',
                                ),
                            ),
                        ),
                    
						// The following is a route to simplify getting started creating
						// new controllers and actions without needing to create a new
						// module. Simply drop new controllers in, and you can access them
						// using the path /application/:controller/:action
						'any_cont_act' => array(			//use this route to redirect to any controller or action
								'type'    => 'Segment',
								'options' => array(
									'route'    => '/[:controller[/:action]]',
									'defaults' => array(
											'__NAMESPACE__' => 'Application\Controller',
											'controller'    => 'Index',
											'action'        => 'index',
									),
								),
								'may_terminate' => true,
								'child_routes' => array(
									'default' => array(
										'type'    => 'Segment',
										'options' => array(
											'route'    => '/[:id1][/][:value1][/][:id2][/][:value2][/][:id3][/][:value3][/][:id4][/][:value4][/][:id5][/][:value5][/][:id6][/][:value6][/][:id7][/][:value7]',
											// 'constraints' => array(
											//'id' => '[a-zA-Z][a-zA-Z0-9_-]*',//defining rules for id, same can be done for others
											//'more_id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
											// ),
											'defaults' => array(
                                                'id1'   =>'',
                                                'id2'   =>'',
                                                'id3'   =>'',
                                                'id4'   =>'',
                                                'id5'   =>'',
                                                'id6'   =>'',
                                                'id7'   =>'',
                                                'value1'=>'',
                                                'value2'=>'',
                                                'value3'=>'',
                                                'value4'=>'',
                                                'value5'=>'',
                                                'value6'=>'',
                                                'value7'=>'',
											),	
										),
								),
							),
						),

						'application' => array(
								'type'    => 'Segment',
								'options' => array(
                                    'route'    => '/application[/:controller[/:action]]',
                                    'defaults' => array(
                                            '__NAMESPACE__' => 'Application\Controller',
                                            'controller'    => 'Index',
                                            'action'        => 'index',
                                    ),
								),
								'may_terminate' => true,
								'child_routes' => array(
                                    'default' => array(
                                        'type'    => 'Segment',
                                        'options' => array(
                                            'route'    => '[/:id][/:id_value]',
                                            'constraints' => array(
                                                'id'            => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                'id_value'      => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            ),
                                            'defaults' => array(
                                            ),
                                        ),
                                    ),
								),
						),

						'pagination' => array(
                            'type'    => 'Segment',
                            'options' => array(
                                'route'    => '/[:controller[/:action]]',
                                'defaults' => array(
                                    '__NAMESPACE__' => 'Application\Controller',
                                    'controller'    => 'Index',
                                    'action'        => 'index',
                                ),
                            ),
                            'may_terminate' => true,
                            'child_routes' => array(
                                'default' => array(
                                    'type'    => 'Segment',
                                    'options' => array(
                                        'route'    => '/[:id1][/][:value1][/][:id2][/][:value2]',
                                        'constraints' => array(
                                            'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                            'id_value'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                        ),
                                        'defaults' => array(
                                            'id1'   =>'',
                                            'value1'   =>'',
                                            'id2'   =>'',
                                            'value2'   =>''
                                        ),
                                    ),
                                ),
                            ),
						),


				),
		),
		'service_manager' => array(
				'abstract_factories' => array(
						'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
						'Zend\Log\LoggerAbstractServiceFactory',
				),
				'aliases' => array(
						'translator' => 'MvcTranslator',
				),
		),
		'translator' => array(
				'locale' => 'en_US',
				'translation_file_patterns' => array(
						array(
								'type'     => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern'  => '%s.mo',
						),
				),
		),
		'controllers' => array(
				'invokables' => array(
					'Application\Controller\Index' 			=> 'Application\Controller\IndexController',
					'Application\Controller\Admin' 			=> 'Application\Controller\AdminController',
				),
		),

		'controller_plugins' => array(
            'invokables' => array(
                    /* 'HelperAuth' 				=> 'Application\Controller\Plugin\HelperAuth',
                    'CommonFunctions' 				=> 'Application\Controller\Plugin\CommonFunctions',
                    'Acl2' 							=> 'Application\Controller\Plugin\Acl2',
                    'csvUserExport' 				=> 'Application\Controller\Plugin\csvUserExport',
                    'Trainingcatelogallplace'		=> 'Application\Controller\Plugin\Trainingcatelogallplace',
                    'ElearningMedia'				=> 'Application\Controller\Plugin\ElearningMedia',
                    'Enrolleduserfromallplace' 		=> 'Application\Controller\Plugin\Enrolleduserfromallplace',
                    'Mailnotification'				=> 'Application\Controller\Plugin\Mailnotification',
                    'Mylearningfunctions'			=> 'Application\Controller\Plugin\Mylearningfunctions',
                    'Coursecreditfunctions'			=> 'Application\Controller\Plugin\Coursecreditfunctions',
                    'TrainingItemsFunctions'		=> 'Application\Controller\Plugin\TrainingItemsFunctions',
                    'Assignmentfunctions'			=> 'Application\Controller\Plugin\Assignmentfunctions', */
            )
		),

		'view_manager' => array(
            'display_not_found_reason' => true,
            'display_exceptions'       => true,
            'doctype'                  => 'HTML5',
            'not_found_template'       => 'error/404',
            'exception_template'       => 'error/index',
            'template_map' => array(
                'layout/layout'            	=> __DIR__ . '/../view/layout/layout.phtml',
                /* 'adminheader'              	=> __DIR__ . '/../view/layout/scripts/adminheader.phtml',
                'standard/adminheader'     	=> __DIR__ . '/../view/layout/scripts/standard/adminheader.phtml',
                'header'           			=> __DIR__ . '/../view/layout/scripts/header.phtml',
                'leftnav'           		=> __DIR__ . '/../view/layout/scripts/leftnav.phtml',
                'footer'           			=> __DIR__ . '/../view/layout/scripts/footer.phtml',
                'application/index/index'  	=> __DIR__ . '/../view/application/index/index.phtml', */
                'error/404'                	=> __DIR__ . '/../view/error/404.phtml',
                'error/index'              	=> __DIR__ . '/../view/error/index.phtml',
            ),
            'template_path_stack' => array(
                    'application'=> __DIR__ . '/../view',
            ),
		),

		'service_manager'=>array(
            'initializers' => array(
                function ($instance, $sm) {
                    if ($instance instanceof \Zend\Db\Adapter\AdapterAwareInterface) {
                        $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    }
                }
            ),
            // 'invokables' => array(
            // 'Application\Model\UserTable' => 'Application\Model\UserTable'
            // )
		),

);
