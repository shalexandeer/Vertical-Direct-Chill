@extends('layout.layout')

@section('content')
  <style>
    /* New keyframes for animations */
    @keyframes mercuryAnimation {
      0% {
        background-color: #dd2c00;
        height: 190px;
        bottom: 100%;
      }

      75% {
        background-color: #b71c1c;
        height: 25px;
        bottom: -80%;
      }

      100% {
        background-color: #01579b
      }
    }

    @keyframes bulbAnimation {
      0% {
        background-color: #dd2c00
      }

      75% {
        background-color: #b71c1c
      }

      100% {
        background-color: #01579b
      }
    }
  </style>
  <div class="container grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">
    @php
      $total_billet = 0; // Initialize the total variable
      $total_defected = 0; // Initialize the total defected variable
      $total_diameter = 0; // Initialize the diameter variable
      $produksi_berjalan = 0; //initialize produksi billet berjalan
      $produksi_gagal = 0; //initialize produksi billet gagal
      $produksi_selesai = 0; //initialize produksi billet selesai
      $mercury_height = 190; //initialize mercury height
      $mercury_bottom = 100; //initialize mercury bottom
      $initial_color = '#dd2c00'; //initialize mercury color
      $suhu = 25; //initialize suhu
      $estimatedTime = '00:00:00'; //initialize estimated time

    @endphp

    @foreach ($billets as $billet)
      @php
        $total_billet += $billet->total_billet;
        $total_diameter += $billet->diameter;
        $total_defected += $billet->total_defected;

        // Calculate the estimated time
        $targetTime = $billet->date; // Assuming $billet->date is in the format 'H:i'
        $currentTime = \Carbon\Carbon::now('Asia/Bangkok')->format('H:i:s');

        $targetDateTime = \Carbon\Carbon::parse($targetTime);
        $currentDateTime = \Carbon\Carbon::parse($currentTime);

        $timeRemaining = $currentDateTime->diff($targetDateTime);

        if ($billet->status == 'jalan') {
            $produksi_berjalan += $billet->total_billet;
        }
        if ($billet->status == 'cacat') {
            $produksi_gagal += $billet->total_billet;
        }
        if ($billet->status == 'selesai') {
            $produksi_selesai += $billet->total_billet;
        }
      @endphp
    @endforeach
    <!-- Calculate percentages -->
    @php
    
      $total_produksi = $produksi_berjalan + $produksi_gagal + $produksi_selesai;
      $percentage_berjalan = number_format(($produksi_berjalan / $total_produksi) * 100, 1);
      $percentage_gagal = number_format(($produksi_gagal / $total_produksi) * 100, 1);
      $percentage_selesai = number_format(($produksi_selesai / $total_produksi) * 100, 1);
    @endphp
    <div class="grid gap-5">
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class=" text-lg tracking-tight text-gray-900 dark:text-white">Total Produksi Billet</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $total_billet }}</h5>
        </div>
      </div>
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class=" text-lg tracking-tight text-gray-900 dark:text-white">Total Defected</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $total_defected }}</h5>
        </div>
      </div>
    </div>

    <div class="grid gap-5">
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class=" text-lg tracking-tight text-gray-900 dark:text-white">Diameter</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $total_diameter }}</h5>
        </div>
      </div>
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class=" text-lg tracking-tight text-gray-900 dark:text-white">Produksi Berjalan</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $produksi_berjalan }}</h5>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-5">
      {{-- <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class=" text-lg tracking-tight text-gray-900 dark:text-white">Suhu</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">20 C</h5>
        </div>
      </div> --}}
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class=" text-lg tracking-tight text-gray-900 dark:text-white">Estimasi</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $estimatedTime }}</h5>
        </div>
      </div>
      <div class="h-full"></div>
    </div>

    <div class="w-full  bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 max-h-[450px]">
      <div class="flex justify-between items-start w-full">
        <div class="flex-col items-center">
          <div class="flex flex-col  mb-1">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Progress Produksi</h5>
            <div class="py-6 w-full" id="pie-chart"></div>
          </div>
        </div>
      </div>
    </div>
    {{-- thermometer --}}
    <div class="grid gap-5  max-h-[450px]">
      <div
        class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 max-h-[450px]">
        <div class="flex justify-between">
          <h5 class=" text-lg tracking-tight text-gray-900 dark:text-white">Suhu</h5>
          <button onclick="coolItDown()"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cool
            it down</button>
        </div>
        <h1 id="suhu">{{ $suhu }} C</h1>
        <div id="main" class="container">
          <div id="thermometer">
            <div>
              <div id="stem"></div>
              <div id="marks">
                <div id="line"></div>
              </div>
              <div id="merc-stem">
                <div id="mercury" class="animated"
                  style="height: {{ $mercury_height }}px; bottom: {{ $mercury_bottom }}%;"></div>
              </div>
              <div id="bulb" class="animated"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script>
    function coolItDown() {
      // Get the existing mercury height and bottom values
      var mercuryHeight = {{ $mercury_height }};
      var mercuryBottom = {{ $mercury_bottom }};

      // Modify the values as needed
      mercuryHeight = 25;
      mercuryBottom = -80;
      var suhu = 3;
      // Update the displayed temperature
      document.getElementById('suhu').innerText = suhu + ' C';
      // Apply the animation class to the mercury and bulb elements
      document.getElementById('mercury').style.animation = 'mercuryAnimation 1s forwards';
      document.getElementById('bulb').style.animation = 'bulbAnimation 1s forwards';

      // After the animation duration, reset the mercury height and bottom
      setTimeout(function() {
        document.getElementById('mercury').style.height = mercuryHeight + 'px';
        document.getElementById('mercury').style.bottom = mercuryBottom + '%';
        document.getElementById('mercury').style.animation = 'none'; // Remove animation class
        document.getElementById('bulb').style.animation = 'none'; // Remove animation class
        document.getElementById('mercury').style.backgroundColor = '#01579b';
        document.getElementById('bulb').style.backgroundColor = '#01579b';
      }, 1000);
    }
    // ApexCharts options and config
    window.addEventListener("load", function() {
      const getChartOptions = () => {
        return {
          series: [{{ $percentage_berjalan }}, {{ $percentage_gagal }}, {{ $percentage_selesai }}],
          colors: ["#1C64F2", "#16BDCA", "#9061F9"],
          chart: {
            height: 420,
            width: "100%",
            type: "pie",
          },
          stroke: {
            colors: ["white"],
            lineCap: "",
          },
          plotOptions: {
            pie: {
              labels: {
                show: true,
              },
              size: "100%",
              dataLabels: {
                offset: -25
              }
            },
          },
          labels: ["Produksi Berjalan", "Produksi Cacat", "Produksi Selesai"],
          dataLabels: {
            enabled: true,
            style: {
              fontFamily: "Inter, sans-serif",
            },
          },
          legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
          },
          yaxis: {
            labels: {
              formatter: function(value) {
                return value + "%"
              },
            },
          },
          xaxis: {
            labels: {
              formatter: function(value) {
                return value + "%"
              },
            },
            axisTicks: {
              show: false,
            },
            axisBorder: {
              show: false,
            },
          },
        }
      }

      if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
        chart.render();
      }
    });
  </script>
@endsection
