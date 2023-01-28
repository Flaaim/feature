```php
//Simple Factory Design Pattern

interface Door {
	public function getHeight(): int;
	public function getWidth(): int;
}

class WoodenDoor implements Door {
	protected $height;
	protected $width;
	
	public function __construct($height, $width)
	{
		$this->height = $height;
		$this->width = $width;
	}
	public function getHeight(): int
	{
		return $this->height;
	}
	public function getWidth(): int
	{
		return $this->width;
	}
}

class DoorFactory {
	static public function makeDoor($height, $width): Door
	{
		return new WoodenDoor($height, $width);
	}
}

$woodenDoor = DoorFactory::makeDoor(10,10);
$reflection = new ReflectionClass(WoodenDoor::class);
print_r($reflection->getProperties());
```
