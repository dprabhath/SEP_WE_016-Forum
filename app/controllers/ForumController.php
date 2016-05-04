<?php

class ForumController extends BaseController
{
	//Forum home page, Displaying groups with categories
	public function index()
	{
		$groups = ForumGroup::all();
		$categories = ForumCategory::all();
		
		return View::make('forum.index')->with('groups', $groups)->with('categories', $categories);
	}
//Once a user click on a category then redirects here and displaying threds under that category
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
//Once user click on a thread, redirects to the particular thread.
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
//Storing new groups to the database, Validating group name
	public function storeGroup()
	{
		$validator = Validator::make(Input::all(), array(
			'group_name' => 'required|unique:forum_groups,title'
		));
		if ($validator->fails())
		{
			return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('modal', '#group_form');
		}
		else
		{
			$group = new ForumGroup;
			$group->title = Input::get('group_name');
			$group->author_id = Auth::user()->id;

			if($group->save())
			{
				return Redirect::route('forum-home')->with('success', 'The group was created');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail', 'An error occured while saving the new group.');
			}
		}
	}
//deleting a group. If categories count is greater than 0, categories should be deleted.
// Samething happens to threads and comments. Before deleting a group that needed to be verified.
	public function deleteGroup($id)
	{
		$group = ForumGroup::find($id);
		if($group == null)
		{
			return Redirect::route('forum-home')->with('fail', 'That group doesn\'t exist.');
		}

		$categories = $group->categories();
		$threads = $group->threads();
		$comments = $group->comments();

		$delCa = true;
		$delT = true;
		$delCo = true;

		if($categories->count() > 0)
		{
			$delCa = $categories->delete();
		}
		if($threads->count() > 0)
		{
			$delT = $threads->delete();
		}
		if($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}


		if ($delCa && $delT && $delCo && $group->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The group was deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the group.');
		}
	}
//deleting category. Needs to check whether threads and commnets are available under that category
	public function deleteCategory($id)
	{
		$category = ForumCategory::find($id);
		if($category == null)
		{
			return Redirect::route('forum-home')->with('fail', 'That category doesn\'t exist.');
		}

		$threads = $category->threads();
		$comments = $category->comments();

		$delT = true;
		$delCo = true;

		if($threads->count() > 0)
		{
			$delT = $threads->delete();
		}
		if($comments->count() > 0)
		{
			$delCo = $comments->delete();
		}


		if ($delT && $delCo && $category->delete())
		{
			return Redirect::route('forum-home')->with('success', 'The category was deleted.');
		}
		else
		{
			return Redirect::route('forum-home')->with('fail', 'An error occured while deleting the category.');
		}
	}
//storing categories
	public function storeCategory($id)
	{
		$validator = Validator::make(Input::all(), array(
			'category_name' => 'required|unique:forum_categories,title'
		));
		if ($validator->fails())
		{
			return Redirect::route('forum-home')->withInput()->withErrors($validator)->with('category-modal', '#category_modal')->with('group-id', $id);
		}
		else
		{
			$group = ForumGroup::find($id);
			if ($group == null)
			{
				return Redirect::route('forum-home')->with('fail', "That group doesn't exist.");
			}

			$category = new ForumCategory;
			$category->title = Input::get('category_name');
			$category->author_id = Auth::user()->id;
			$category->group_id = $id;

			if($category->save())
			{
				return Redirect::route('forum-home')->with('success', 'The category was created');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail', 'An error occured while saving the new category.');
			}
		}
	}
//Adding a new thread
	public function newThread($id)
	{
		return View::make('forum.newthread')->with('id', $id);
	}

	public function storeThread($id)
	{
		$category = ForumCategory::find($id);
		if ($category == null)
			Redirect::route('forum-get-new-thread')->with('fail', "You posted to an invalid category.");

		$validator = Validator::make(Input::all(), array(
			'title' => 'required|min:3|max:255',
			'body'  => 'required|min:10|max:65000'
		));

		if ($validator->fails())
		{
			return Redirect::route('forum-get-new-thread', $id)->withInput()->withErrors($validator)->with('fail', "Your input doesn't match the requirements");
		}
		else
		{
			$thread = new ForumThread;
			$thread->title = Input::get('title');
			$thread->body = Input::get('body');
			$thread->category_id = $id;
			$thread->group_id = $category->group_id;
			$thread->author_id = Auth::user()->id;

			if ($thread->save())
			{
				return Redirect::route('forum-thread', $thread->id)->with('success', "Your thread has been saved.");
			}
			else
			{
				return Redirect::route('forum-get-new-thread', $id)->with('fail', "An error occured while saving your thread.")->withInput();
			}
		}
	}
//deleting a thread
	public function deleteThread($id)
	{
		$thread = ForumThread::find($id);
		if ($thread == null)
			return Redirect::route('forum-home')->with('fail', "That thread doesn't exist");

		$category_id = $thread->category_id;
		$comments = $thread->comments;
		if ($comments->count() > 0)
		{
			if ($comments->delete() && $thread->delete())
				return Redirect::route('forum-category', $category_id)->with('success', "The thread was deleted.");
			else
				return Redirect::route('forum-category', $category_id)->with('fail', "An error occured while deleting the thread.");
		}
		else
		{
			if ($thread->delete())
				return Redirect::route('forum-category', $category_id)->with('success', "The thread was deleted.");
			else
				return Redirect::route('forum-category', $category_id)->with('fail', "An error occured while deleting the thread.");
		}
	}
//storing comments
	public function storeComment($id)
	{
		$thread = ForumThread::find($id);
		if ($thread == null)
			Redirect::route('forum')->with('fail', "That thread does not exist.");

		$validator = Validator::make(Input::all(), array(
			'body' => 'required|min:5'
		));

		if ($validator->fails())
			return Redirect::route('forum-thread', $id)->withInput()->withErrors($validator)->with('fail', "Please fill in the form correctly.");
		else
		{
			$comment = new ForumComment();
			$comment->body = Input::get('body');
			$comment->author_id = Auth::user()->id;
			$comment->thread_id = $id;
			$comment->category_id = $thread->category->id;
			$comment->group_id = $thread->group->id;

			if ($comment->save())
				return Redirect::route('forum-thread', $id)->with('success', "The comment was saved.");
			else
				return Redirect::route('forum-thread', $id)->with('fail', "An error occured wile saving.");
		}
	}
//deling comments
	public function deleteComment($id)
	{
		$comment = ForumComment::find($id);
		if ($comment == null)
			return Redirect::route('forum')->with('fail', "That comment does not exist.");

		$threadid = $comment->thread->id;
		if ($comment->delete())
			return Redirect::route('forum-thread', $threadid)->with('success', "The comment was deleted.");
		else
			return Redirect::route('forum-thread', $threadid)->with('fail', "An error occured while deleting the comment.");
	}
}
