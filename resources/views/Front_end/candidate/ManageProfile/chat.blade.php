@extends('Front_end.layouts.home.homeindex')
@section('pagetitle', 'Chat')
@section('pageheader', 'Chat')
@section('content')

<div id="content">
	<div class="container">
		<div class="row">
			@include('Front_end.candidate.ManageProfile.left_menu')
			<div class="col-lg-9 col-md-9 col-xs-12">
				<iframe src="{{ route('chatify') }}" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe>
			</div>
		</div>
	</div>
</div>
@endsection
