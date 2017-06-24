<?php 
namespace codelearn\model;

use m4\m4mvc\core\Model;
use m4\m4mvc\helper\Str;

class Lesson extends Model 
{
	public static $table = 'lessons';
	public function getAll ($items = '*') 
	{
		$query = $this->query->select($items)->from(self::$table)->build();
		return $this->fetchAll($query);
	}

	public function getByTopicId ($topic_id, $items = '*') 
	{
		$query = $this->query->select($items)->from(self::$table)->where('topic_id = :topic_id')->build();
		return $this->fetchAll($query, ['topic_id' => $topic_id]);
	}
}