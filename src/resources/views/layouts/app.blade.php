<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'MasterRO') }} - Mail Viewer</title>

	<link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('vendor/mail-viewer/css/app.css') }}">
</head>
<body>
<div id="app" class="mx-auto">
	@include('mail-viewer::partials.header')

	@yield('content')
</div>
<script src="{{ asset('vendor/mail-viewer/js/app.js') }}"></script>
</body>
</html>
