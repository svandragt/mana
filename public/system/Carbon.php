<?php

class Carbon {

	static function router() {
		if (Cache::has_cache()) {
			include(Cache::cache_file()); 
			exit();
		} 
		Setup::environment_start();
		Cache::start();

		$actions = explode("/", Carbon::page_path());
		$function = $actions[1];
		if ( is_callable ( "Controller::$function")) {
			call_user_func ( "Controller::$function",$actions);
		} else {
			Log::info("not callable '$function' or missing parameter.");
			header('Location: ' . Theming::root() . '/error/404');
			exit();
		}
		Cache::end();
		
		Setup::environment_end();
	}

	



	static function page_path() {
		if (is_null(Http::server('PATH_INFO'))) {
			header('Location: ' . Theming::root() . Configuration::HOME_PAGE);
			exit();
		} else {
			$path_info = Http::server('PATH_INFO');
			$ends_with_slash = !substr(strrchr($path_info, "/"), 1);
			if ($ends_with_slash) {
				header('Location: ' . Theming::root() . substr($path_info, 0, -1));
				exit();
			}
			else{ 
				return $path_info;
			}
		}
	}
}