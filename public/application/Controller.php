<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Controller {

	static function admin($path_parts) {
		ob_end_clean();
		$action = $path_parts[2];

		switch ($action) {
			case 'cache':
				Cache::clear();
				break;
			case 'new':
				Carbon::template('post');
				break;
		}
		printf("<a href='%s'>Return</a><br>",Theming::root());
	}

	static function errors($path_parts) {
		$controller = __FUNCTION__;
		$model = 'pages';

		header("HTTP/1.0 404 Not Found");
		$error_type = $path_parts[2];
		switch ($error_type) {
			case '404':
				$file_path = Filesystem::url_to_path("/content/$controller/$error_type." . Configuration::CONTENT_EXT);
				$data =  (file_exists($file_path)) ? call_user_func ("Model::$model",array(
					'file_path' => $file_path,
				)) : "Sorry, this page does not exists (404). Customise this page by adding a /content/errors/404.md.";
				View::template($data, array(
						'layout'     => 'single.php',
						'controller' => $controller,
						'model'      => $model,
				));
			break;
		}
 	}


	static function index() {
		$controller = __FUNCTION__;
		$model = 'posts';

		$data = array();
		$i = 0;
		$max = Configuration::POSTS_HOMEPAGE;
		foreach (Filesystem::list_files( Filesystem::url_to_path("/content/$model"), 'md') as $key => $value) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $value, 
			));	
			if (++$i == $max) break;
		}
		usort ( $data, "Carbon::compare_published");
		View::template($data, array(
			'layout'     => 'layout.php',
			'controller' => $controller,
			'model'      => $model,
		));
	}

	static function archive() {
		$controller = __FUNCTION__;
		$model = 'posts';

		$data = array();
		foreach (Filesystem::list_files( Filesystem::url_to_path("/content/$model"), 'md') as $key => $value) {
			$data[] = call_user_func ("Model::$model",array(
				'file_path' => $value, 
			));	
		}
		usort ( $data, "Carbon::compare_published");
		View::template($data, array(
			'layout'     => 'layout.php',
			'controller' => $controller,
			'model'      => 'model'
		));
	}

	
	static function pages($path_parts) {
		$controller = __FUNCTION__;
		$model = $controller;

		$item     = $path_parts[2];
		$file_path = Filesystem::url_to_path("/content/$model/$item." . Configuration::CONTENT_EXT);
		$data     = call_user_func ("Model::$model",array(
				'file_path' => $file_path, 
		));	

		View::template($data, array(
			'layout'     => 'layout.php',
			'controller' => $controller,
			'model'      => $model,
		));
	}

	static function posts($path_parts) {
		$controller = __FUNCTION__;
		$model = $controller;

		$path_parts  = array_slice($path_parts, 2);
		$item     = implode('/', $path_parts);
		$file_path = Filesystem::url_to_path("/content/$model/$item." . Configuration::CONTENT_EXT);
		$data     = call_user_func ("Model::$model",array(
				'file_path' => $file_path, 
		));	

		View::template($data, array(
			'layout' => 'layout.php',
			'controller' => $controller,
			'model' => $model,
		));
	}
}