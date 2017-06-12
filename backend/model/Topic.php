<?php 
namespace codelearn\model;

use m4\m4mvc\core\Model;
use m4\m4mvc\helper\Str;

class Topic extends Model 
{
	public static $table = 'topics';
	public function getTopics ($items = '*') 
	{
		$query = $this->query->select($items)->from(self::$table)->build();
		return $this->fetchAll($query);
	}
}