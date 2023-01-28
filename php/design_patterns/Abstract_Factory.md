```php

<?php
// Abstract Factory Design Pattern
interface Interviewer 
{
	public function askQuestion();
}
class Developer implements Interviewer
{
	public function askQuestion()
	{
		echo "Расскажите о SOLID";
	}
}

abstract class HiringManager
{
	abstract public function makeInterviewer(): Interviewer;
	public function takeInterview()
	{
		$interviewer = $this->makeInterviewer();
		$interviewer->askQuestion();
	}
}

class DeveloperManager extends HiringManager
{
	public function makeInterviewer(): Interviewer
	{
		return new Developer();
	}
}

$developer = new DeveloperManager();
$developer->takeInterview();
```
