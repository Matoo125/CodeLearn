<?php 

namespace codelearn\controllers\api;

use m4\m4mvc\core\Controller;
use m4\m4mvc\helper\Session;
use m4\m4mvc\helper\Request;

class Code extends Controller
{
	public function index ()
	{

	}

	public function save ()
	{

    Request::forceMethod('post');
    Request::required('title', 'type');
    $data = Request::select('css', 'html', 'htmlbody', 'js', 'title', 'action', 'type');

       // create users project folder if not exists
	   $dir = dirname(ROOT) . DS . 'data' . DS . $data['type'] . DS . Session::get('user_id');
	   $project = $dir . DS . $data['title'];

	   if (!file_exists($dir)) {
	     	mkdir($dir, 0777);
	   }  

    if ($data['type'] == 'projects') {
      // update or create project
      if ($data['action'] == 'update') {
        if (!file_exists($project)) {
          return $this->data = [
            'status'  =>  'ERROR',
            'message' =>  'This project does not exists'
          ];
        }

        $this->data = [
          'status'  =>  'SUCCESS',
          'message' =>  'Project has been updated'
        ];

      } 

      elseif ($data['action'] == 'create') {

        if (file_exists($project)) {
          return $this->data = [
            'status'  =>  'ERROR',
            'message' =>  'You already have project with this name'
          ];
        }

        mkdir($project, 0777);
        $this->data = [
          'status'  =>  'SUCCESS',
          'message' =>  'Project ' . $data['title'] . ' has been created'  
        ];

      } 

      else {
        return $this->data = [
          'status'  =>  'ERROR',
          'message' =>  'No action specified'
        ];
      }
    } 
    elseif ($data['type'] == 'exercises') {
      if (!file_exists($project)) {
        mkdir($project, 0777);
      }
      $this->data = [
        'status'  =>  'SUCCESS',
        'message' =>  'Exercise have been saved'
      ];
    } 
    else {
      return $this->data = [
        'status'  => 'ERROR',
        'message' =>  'No type specified, only those are allowed: exercises, projects'
      ];
    }

     // save files
     $file = fopen($project . DS . 'index.html', 'w');
     fwrite($file, $data['html']);
     fclose($file);

     $file = fopen($project . DS . 'body.html', 'w');
     fwrite($file, $data['htmlbody']);
     fclose($file);

     $file = fopen($project . DS . 'style.css', 'w');
     fwrite($file, $data['css']);
     fclose($file);

     $file = fopen($project . DS . 'script.js', 'w');
     fwrite($file, $data['js']);
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

  public function load ()
  {
    Request::forceMethod('get');
    Request::required('folder', 'title');
    $folder = $_GET['folder'];

    $id = Session::get('user_id');
    $path = dirname(ROOT) . DS . 'data' . DS . $folder . DS . $id  . DS . $_GET['title'];
    if (file_exists($path)) {
      $html = file_get_contents($path . DS . 'body.html');
      $css = file_get_contents($path . DS . 'style.css');
      $js = file_get_contents($path. DS . 'script.js');

      return $this->data = [
        'status'  =>  'SUCCESS',
        'message' =>  'Code has been loaded',
        'code' => [
          'css'   =>  $css,
          'html'  =>  $html,
          'js'    =>  $js
        ]
      ];
    } else {
      return $this->data = [
        'status' => 'ERROR',
        'message'=> 'This code does not exists'
      ];
    }

  }
}