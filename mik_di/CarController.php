<?php

class CarController {
	/**
	 * @Inject
	 * @var CarManager	-name of the class to inject
	 */ 
	public $carManager;
	
	public function printCars() {
		$cars=$this->carManager->getCars();
		echo "cnt: ".count($cars);
		foreach ($cars as $car) {
			echo "$car, ";
		}
	}
}