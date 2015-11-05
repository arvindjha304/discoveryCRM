<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
 
class RouteHelper extends AbstractHelper
{
    protected $serviceLocator;
	public function __construct(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
	
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
	
    public function getPlugin($pluginName)
    {
        $plugin = $this->getServiceLocator()->get('ControllerPluginManager')->get($pluginName);
        return $plugin;
    }
	
	// public function common_functions()
	// {
			// $plugin = $this->getServiceLocator()->get('ControllerPluginManager')->get('CommonFunctions');
			// return $plugin;
	// }
	
	// public function acl()
	// {
		// $plugin = $this->getServiceLocator()->get('ControllerPluginManager')->get('Acl2');
		// return $plugin;
	// }
	
	public function indexmodel()
	{
		$plugin = $this->getServiceLocator()->get('Application\Model\Index');
		return $plugin;
	}
}
?>