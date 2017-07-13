<?php 

namespace codelearn\controllers\api;

use m4\m4mvc\core\Controller;
use m4\m4mvc\helper\Session;
use m4\m4mvc\helper\Response;
use m4\m4mvc\helper\Request;

class Learn extends Controller
{
	public function index()
	{
		echo 'aaa';
	}

	public function load ()
	{
		$topic = $this->getModel('Topic');
		$topics = $topic->getTopics('id, title');

		$solution = $this->getModel('Solution');

		$newTopics = [];

		foreach ($topics as $topic) {
			$lesson = $this->getModel('Lesson');
			$lessons = $lesson->getByTopicId($topic['id']);

			$newLessons = [];
			foreach ((array) $lessons as $key => $l) {
				$l['solutions'] = $solution->getForLesson($l['id']);
				$l['completed']	=	$lesson->isLessonFinished(Session::get('user_id'), $lessons[$key]['id']);

				$newLessons[$l['id']] = $l;

			}

			$topic['lessons'] = $newLessons;

			$newTopics[$topic['id']] = $topic;
		}

		Response::success('Topics loaded successfully', ['topics' => $newTopics]);
	}

	public function lessonNotCompleted () {
		Request::forceMethod('post');
		Request::required('lessonId');

		$lessonId = $_POST['lessonId'];
		$userId = Session::get('user_id');

		$model = $this->getModel('Lesson');
		$result = $model->lessonNotFinished($userId, $lessonId);
		if ($result) {
			return $this->data = [
				'status'	=>	'SUCCESS',
				'message'	=>	'Lesson is again uncompleted'
			];
		}
	}

	public function lessonCompleted () {
		Request::forceMethod('post');
		Request::required('lessonId');

		$lessonId = $_POST['lessonId'];
		$userId = Session::get('user_id');

		$model = $this->getModel('Lesson');
		$result = $model->lessonFinished($userId, $lessonId);
		if ($result) {
			return $this->data = [
				'status'	=>	'SUCCESS',
				'message'	=>	'Lesson was marked as completed'
			];
		}
	}
}