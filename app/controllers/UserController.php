<?php

class UserController extends BaseController
{
	//gets the view for the register page
	public function getCreate()
	{
		return View::make('user.register');
	}

	//gets the view for the login page
	public function getLogin()
	{
		return View::make('user.login');
	}
//validating new user creation
	public function postCreate()
	{
		$validate = Validator::make(Input::all(), array(
			'username' => 'required|unique:users|min:4',
			'pass1' => 'required|min:6',
			'pass2' => 'required|same:pass1',
		));

		if ($validate->fails())
		{
			return Redirect::route('getCreate')->withErrors($validate)->withInput();
		}
		else
		{
			$user = new User();
			$user->username = Input::get('username');
			$user->password = Hash::make(Input::get('pass1'));

			if ($user->save())
			{
				return Redirect::route('forum-home')->with('success', 'You registed successfully. You can now login.');
			}
			else
			{
				return Redirect::route('forum-home')->with('fail', 'An error occured while creating the user. Please try again.');
			}
		}
	}
//validating user login
	public function postLogin()
	{
		$validator = Validator::make(Input::all(), array(
		'username' => 'required',
		'pass1' => 'required'
		));
		
		if($validator->fails())
		{
			return Redirect::route('getLogin')->withErrors($validator)->withInput();
		}
		else
		{
			$remember = (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('pass1')
				), $remember);

			if($auth)
			{
				return Redirect::intended('/forums');
			}
			else
			{
				return Redirect::route('getLogin')->with('fail', 'You entered the wrong login credentials, please try again!');
			}
		}
	}
//handling the logout
	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('forum-home');
	}
	//handling Facebook login requests 
	public function getLoginFacebook($auth=NULL)
{
				if($auth=='auth') {
				try {
				Hybrid_Endpoint::process();
				} catch (Exception $e) {
				return Redirect::to("fbAuth");
				}
				return;
				}
				 
				$config= array(
				"base_url" => "https://sep.altairsl.us/forum/public/forum/fbAuth/auth",
				"providers" => array (
				"Facebook" => array (
				"enabled" => true,
				"keys" => array ( "id" => "209639499392874", "secret" => "36178e70b37f81a91905b2cd4738b27b" ),
				"scope" => "public_profile,email", // optional
				"display" => "popup" // optional
				)
				)
				);
				 
				$oauth=new \Hybrid_Auth($config);
				$provider=$oauth->authenticate("Facebook");
				$profile=$provider->getUserProfile();
				var_dump($profile);
				echo "FirstName:".$profile->firstName."<br>";
				echo "Email:".$profile->email;
				echo "<br><a href='logout'>Logout</a> ";
}
	
	public function logout()
{
			$oauth=new \Hybrid_Auth(base_path().'/app/config/fb_Auth.php');
			$oauth->logoutAllProviders();
			Session::flush();
			\Auth::logout();
			return Redirect::to("/user/login");
}
	
	
	
}