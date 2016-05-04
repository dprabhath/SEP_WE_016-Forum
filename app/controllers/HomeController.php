<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
//displaying the forum home
	public function hello()
	{
		return View::make('hello');
	}
	
//displaying categories
public function category($id)
	{
		$category = ForumCategory::find($id);
		if ($category == null)
		{
			return Redirect::route('forum-home')->with('fail', "That category doesn't exist.");
		}
		$threads = $category->threads()->get();

		return View::make('forum.category')->with('category', $category)->with('threads', $threads);
	}
	
	//displaying threads
	public function thread($id)
	{
		$thread = ForumThread::find($id);
		if ($thread == null)
		{
			return Redirect::route('forum-home')->with('fail', "That thread doesn't exist.");
		}
		$author = $thread->author()->first()->username;

		return View::make('forum.thread')->with('thread', $thread)->with('author', $author);
	}
}
