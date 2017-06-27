<?php 

namespace codelearn\controllers\api;

use m4\m4mvc\core\Controller;
use m4\m4mvc\helper\Response;

class Learn extends Controller
{
	public function index()
	{

	}

	public function load ()
	{
		$topic = $this->getModel('Topic');
		$topics = $topic->getTopics('id, title');

		$solution = $this->getModel('Solution');

		foreach ($topics as $topic) {
			$lesson = $this->getModel('Lesson');
			$lessons = $lesson->getByTopicId($topic['id']);

			foreach ((array) $lessons as $key => $lesson) {
				$lessons[$key]['solutions'] = $solution->getForLesson($lesson['id']);

			}

			$topics[$topic['id'] - 1]['lessons'] = $lessons;
		}

		Response::success('Topics loaded successfully', ['topics' => $topics]);
	}
}