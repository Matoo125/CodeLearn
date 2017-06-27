<?php 
namespace codelearn\model;

use m4\m4mvc\core\Model;
use m4\m4mvc\helper\Str;

class Solution extends Model 
{
  public static $table = 'solutions';

  public function getForLesson ($lesson_id, $items = '*') 
  {
    $query = $this->query->select($items)->from(self::$table)->where('lesson_id = :lesson_id')->build();
    return $this->fetchAll($query, ['lesson_id' => $lesson_id]);
  }
}