<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  @vite('resources/css/app.css')
  @vite('resources/css/app.scss')
  @vite('resources/js/app.js')
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>

<body class="dark:bg-[#374151]">
  @include('partials.sidebar')
  <div class="p-4 sm:ml-64">
    @yield('content')
  </div>
</body>

</html>
