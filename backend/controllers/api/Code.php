<?php 

namespace codelearn\controllers\api;

use m4\m4mvc\core\Controller;
use m4\m4mvc\helper\Session;

class Code extends Controller
{
	public function index ()
	{

	}

	public function save ()
	{

       $css = isset($_GET['css']) ? $_GET['css'] : null;
       $html = isset($_GET['html']) ? $_GET['html'] : null;
       $htmlbody = isset($_GET['htmlbody']) ? $_GET['htmlbody'] : null;
       $js = isset($_GET['js']) ? $_GET['js'] : null;
       $title = isset($_GET['title']) ? $_GET['title'] : null;
       $action = isset($_GET['action']) ? $_GET['action'] : null;

       if (!$title) {
       	 return $this->data = [
       	 	'status'=>'ERROR', 
       	 	'message'=>'Project name is missing'
       	 ];
       }

       // create users project folder if not exists
	   $dir = dirname(ROOT) . DS . 'data' . DS . 'projects' . DS . Session::get('user_id');
	   $project = $dir . DS . $title;

	   if (!file_exists($dir)) {
	     	mkdir($dir, 0777);
	     }  

       // update or create project
       if ($action == 'update') {
       	if (!file_exists($project)) {
       		return $this->data = [
       			'status'	=>	'ERROR',
       			'message'	=>	'This project does not exists'
       		];
       	}

       	$this->data = [
       		'status'	=>	'SUCCESS',
       		'message'	=>	'Project has been updated'
       	];

       } 

       elseif ($action == 'create') {

       	if (file_exists($project)) {
       		return $this->data = [
       			'status'	=>	'ERROR',
       			'message'	=>	'You already have project with this name'
       		];
       	}

       	mkdir($project, 0777);
       	$this->data = [
       		'status'	=>	'SUCCESS',
       		'message'	=>	'Project ' . $title . ' has been created'  
       	];

       } 

       else {
       	return $this->data = [
       		'status'	=>	'ERROR',
       		'message'	=>	'No action specified'
       	];
       }

       // save files
       $file = fopen($project . DS . 'index.html', 'w');
       fwrite($file, $html);
       fclose($file);

       $file = fopen($project . DS . 'body.html', 'w');
       fwrite($file, $htmlbody);
       fclose($file);

       $file = fopen($project . DS . 'style.css', 'w');
       fwrite($file, $css);
       fclose($file);

       $file = fopen($project . DS . 'script.js', 'w');
       fwrite($file, $js);
       fclose($file);
	}

	public function getProjects ()
	{
    $id = Session::get('user_id');
    $path = dirname(ROOT) . DS . 'data' . DS . 'projects' . DS . $id;
    return $this->data = [
     'status'     =>    'SUCCESS',
     'projects'   =>    array_slice(scandir($path), 2)
    ];
	}

  public function getProject ()
  {
    $id = Session::get('user_id');
    $path = dirname(ROOT) . DS . 'data' . DS . 'projects' . DS . $id . DS . $_GET['title'];
    $html = file_get_contents($path . DS . 'body.html');
    $css = file_get_contents($path . DS . 'style.css');
    $js = file_get_contents($path. DS . 'script.js');

    return $this->data = [
      'status'  =>  'SUCCESS',
      'message' =>  'Project has been loaded',
      'code' => [
        'css'   =>  $css,
        'html'  =>  $html,
        'js'    =>  $js
      ]
    ];
  }
}