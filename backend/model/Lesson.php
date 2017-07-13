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

	public function lessonFinished ($userId, $lessonId) 
	{
		$query = $this->query->insert('user_id', 'lesson_id')
												 ->into('finishedlessons')
												 ->build();
		return $this->save($query, ['user_id' => $userId, 'lesson_id' => $lessonId]);
	}

	public function lessonNotFinished ($userId, $lessonId)
	{
	  $query = $this->query->delete('finishedlessons')
	  									   ->where('user_id = :user_id AND lesson_id = :lesson_id')
	  									   ->build();
	  return $this->save($query, ['user_id' => $userId, 'lesson_id' => $lessonId]);
	}

	public function isLessonFinished ($userId, $lessonId)
	{
		$query = "SELECT COUNT(id) as x FROM finishedlessons WHERE user_id = :user_id AND lesson_id = :lesson_id";
		$x = $this->fetch($query, ['user_id' => $userId, 'lesson_id' => $lessonId])['x'];

		return $x ? true : false;
	}

}