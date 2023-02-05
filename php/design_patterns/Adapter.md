```<?php
//Adapter
interface Door {
	public function getDescription();
}

class WoodenDoor implements Door {
	public function getDescription(){
		echo 'It is a wooden door';
	}
}
class MetalDoor implements Door {
		public function getDescription(){
		echo 'It is a metal door';
	}
}


interface DoorFittingExpert{
	public function getDescription();
}

class Carpenter implements DoorFittingExpert{
	public function getDescription()
	{
		echo "I am fitting a wooden door";
	}
}


abstract class Factory{
	abstract public function makeDoor(): Door;
	abstract public function makeFittingExpert(): DoorFittingExpert;
}

class WoodenFactory extends Factory {
	public function makeDoor(): Door
	{
		return new WoodenDoor();
	}
	public function makeFittingExpert(): DoorFittingExpert
	{
		return new Carpenter();
	}
}

$woodenFactory = new WoodenFactory();
$woodenDoor = $woodenFactory->makeDoor();
$woodenDoor->getDescription();
$woodenExpert = $woodenFactory->makeFittingExpert();
$woodenExpert->getDescription();
```
