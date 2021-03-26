<?php
namespace Mik\DIC;

class DIcontainer
{
    private $services = [];
	
	public function addService($service)
	{
		$key = get_class($service);
		$this->services[$key] = $service;
	}
	public function getInstance($className)
	{
		// create instance if not set
		if (!isset($this->services[$className]))
		{
			$instance = new $className;

			$this->services[$className] = $instance;
			// Injection of dependecies
			$reflexion = new \ReflectionClass($instance);
			$this->putDependency($reflexion, $instance);
			return $instance;
		}
		return $this->services[$className];
	}
	private function putDependency($reflexion, $instance)
	{
		$properties = $reflexion->getProperties();
		foreach ($properties as $property)
		{
			$comment = $property->getDocComment();
			// if property needs injecting
			if (strpos($comment, '@Inject') !== false)
			{
				// parse property type
				$matches = [];
				if (!preg_match('~@var\s+([A-Za-z0-9\\\_\-]+)~u', $comment, $matches))
					throw new Exception('Could not find data type of property ' . $property->getName());
				$type = $matches[1];
				$property->setValue($instance, $this->getInstance($type)); // Do the injection
			}
		}
	}

}