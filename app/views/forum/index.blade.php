@extends('layouts.master')

@section('head')
			
	@parent
	<title>Forums</title>
	<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

	<!-- Scripts needed to be loaded (bootstrap and jquery modals) -->
	<script>
	$(document).ready(function ()
{
	$("#form_submit").click(function()
	{
		$("#target_form").submit();
	});

	$("#category_submit").click(function()
	{
		$("#category_form").submit();
	});

	$(".new_category").click(function()
	{
		var id = event.target.id;
		var pieces = id.split("-");
		$("#category_form").prop('action', 'forum/category/' + pieces[2] + '/new');
	});

	$(".delete_group").click(function(event)
	{
		
		$("#btn_delete_group").prop('href', 'https://sep.altairsl.us/forum/public/forum/group/' + event.target.id + '/delete');
	});

	$(".delete_category").click(function(event)
	{
		$("#btn_delete_category").prop('href', 'https://sep.altairsl.us/forum/public/forum/category/' + event.target.id + '/delete');
	});
});
	</script>
@stop

@section('content')
<center>

<!-- Search -->
<input type="text" class="st-default-search-input" value="" width="100000px" placeholder="Search the Forum..">
					
<script type="text/javascript">
  (function(w,d,t,u,n,s,e){w['SwiftypeObject']=n;w[n]=w[n]||function(){
  (w[n].q=w[n].q||[]).push(arguments);};s=d.createElement(t);
  e=d.getElementsByTagName(t)[0];s.async=1;s.src=u;e.parentNode.insertBefore(s,e);
  })(window,document,'script','//s.swiftypecdn.com/install/v2/st.js','_st');
  
  _st('install','DcpnrEtyffBAKBscxxnA','2.0.0');
</script>


</center>




@if(Auth::check() && Auth::user()->isAdmin())
	<a href="#" class="btn btn-default" data-toggle="modal" data-target="#group_form">Add Group</a>
@endif

@foreach($groups as $group)
	<div class="panel panel-primary">
		<div class="panel-heading">
			@if(Auth::check() && Auth::user()->isAdmin())
			<div class="clearfix">
				<h3 class="panel-title pull-left">{{ $group->title }}</h3>
				<a id="add-category-{{ $group->id }}" href="#" data-toggle="modal" data-target="#category_modal" class="btn btn-success btn-xs pull-right new_category">New Category</a>
				<a id="{{ $group->id }}" href="#" data-toggle="modal" data-target="#group_delete" class="btn btn-danger btn-xs pull-right delete_group">Delete</a>
			</div>
			@else
			<h3 class="panel-title">{{ $group->title }}</h3>
			@endif
		</div>
		<div class="panel-body panel-list-group">
			<div class="list-group">
				@foreach($categories as  $category)
					@if($category->group_id == $group->id)
					<a href="{{ URL::route('forum-category', $category->id) }}" class="list-group-item">{{ $category->title }}</a>
					@endif
				@endforeach
			</div>
			
		</div>
	</div>
@endforeach

@if(Auth::check() && Auth::user()->isAdmin())
<div class="modal fade" id="group_form" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-dissen="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">New Group</h4>
			</div>
			<div class="modal-body">
				<form id="target_form" method="post" action="{{ URL::route('forum-store-group') }}">
					<div class="form-group {{ ($errors->has('group_name')) ? ' has-error' : ''}}">
						<label for="group_name">Group Name:</label>
						<input type="text" id="group_name" name="group_name" class="form-control">
						@if($errors->has('group_name'))
							<p>{{ $errors->first('group_name') }}</p>
						@endif
					</div>
					{{ Form::token() }}
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="form_submit">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-dissen="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">New Category</h4>
			</div>
			<div class="modal-body">
				<form id="category_form" method="post">
					<div class="form-group {{ ($errors->has('category_name')) ? ' has-error' : ''}}">
						<label for="category_name">Category Name:</label>
						<input type="text" id="category_name" name="category_name" class="form-control">
						@if($errors->has('category_name'))
							<p>{{ $errors->first('category_name') }}</p>
						@endif
					</div>
					{{ Form::token() }}
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" id="category_submit">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="group_delete" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-dissen="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Delete Group</h4>
			</div>
			<div class="modal-body">
				<h3>Are you sure you want to delete this group.</h3>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a href="#" type="button" class="btn btn-primary" id="btn_delete_group">Delete</a>
			</div>
		</div>
	</div>
</div>
@endif

@stop

@section('javascript')
	@parent
	<!--script type="text/javascript" src="/js/app.js"></script-->
	@if(Session::has('modal'))
		<script type="text/javascript">
			$("{{ Session::get('modal') }}").modal('show');
		</script>
	@endif

	@if(Session::has('category-modal') && Session::has('group-id'))
		<script type="text/javascript">
			$("#category_form").prop('action', "/forum/category/{{ Session::get('group-id') }}/new");
			$("{{ Session::get('category-modal') }}").modal('show');
		</script>
	@endif
@stop