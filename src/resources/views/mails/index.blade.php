<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta
    name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
  >
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    {{ config('app.name', 'Laravel') }} - Mail Viewer
  </title>

  <link rel="stylesheet" href="{{ asset('vendor/mail-viewer/css/app.css') }}">
  <link
    href="https://fonts.googleapis.com/css2?family=Tangerine&family=Nunito+Sans:ital,wght@0,400;0,600;0,800;1,400&family=Rajdhani:wght@400;500;600;700&display=swap"
    rel="stylesheet"
  >
</head>
<body class="box-border bg-gray-200 scroll-smooth">
<div
  id="app"
  data-app-name="{{ config('app.name', 'Laravel') }}"
  data-site-url="{{ value(config('mail-viewer.site_url', url('/'))) }}"
></div>
<script src="{{ asset('vendor/mail-viewer/js/app.js') }}"></script>
</body>
</html>
