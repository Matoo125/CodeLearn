<?php 

namespace codelearn\controllers\api;

use m4\m4mvc\core\Controller;
use m4\m4mvc\helper\Response;

class Learn extends Controller
{
	public function index()
	{
		//echo LESSONS; 
		$topics = array_slice(scandir(LESSONS), 2);
		// print_r($topics);
		$response = [];

		foreach ($topics as $topic) {
			$numbers = array_slice(scandir(LESSONS.DS.$topic), 2);
			// print_r($numbers);

			foreach ($numbers as $number) {
				$lecture = array_slice(scandir(LESSONS.DS.$topic.DS.$number), 2);
				array_push($response, [$number => $lecture[0]]);
			}
		}
		Response::success('Lessons are loaded', [$response]);

	}

	public function load ()
	{
		$topic = $this->getModel('Topic');
		$topics = $topic->getTopics('id, title');

		foreach ($topics as $topic) {
			$lesson = $this->getModel('Lesson');
			$lessons = $lesson->getByTopicId($topic['id']);

			$topics[$topic['id'] - 1]['lessons'] = $lessons;
		}

		Response::success('Topics loaded successfully', ['topics' => $topics]);
	}
}