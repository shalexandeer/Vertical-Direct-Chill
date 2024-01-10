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
        background-color: #01579b;
      }
    }

    @keyframes bulbAnimation {
      0% {
        background-color: #dd2c00;
      }

      75% {
        background-color: #b71c1c;
      }

      100% {
        background-color: #01579b;
      }
    }
  </style>

  <div class="container grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-5">
    @php
      // Initializing variables
      $total_billet = 0;
      $total_defected = 0;
      $total_diameter = 0;
      $produksi_berjalan = 0;
      $produksi_gagal = 0;
      $produksi_selesai = 0;
      $mercury_height = 190;
      $mercury_bottom = 100;
      $initial_color = '#dd2c00';
      $suhu = 25;
      // variable estimated time with format days hours minutes
      $total_time_remaining = \Carbon\CarbonInterval::create(0, 0, 0, 0, 0, 0)
    @endphp

    @foreach ($billets as $billet)
      @php
        // Updating variables based on billet data
        $total_billet += $billet->total_billet;
        $total_diameter += $billet->diameter;
        $total_defected += $billet->total_defected;

        // Calculate the estimated time
        $targetTime = $billet->date;
        $currentTime = \Carbon\Carbon::now('Asia/Bangkok');

        $targetDateTime = \Carbon\Carbon::parse($targetTime);
        $currentDateTime = \Carbon\Carbon::parse($currentTime);

        $timeRemaining = $currentDateTime->diff($targetDateTime);
        // add estimated time to with time reainin variable
        $total_time_remaining = $total_time_remaining->add($timeRemaining);
        // Update production variables based on billet status
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
      $percentage_berjalan = $total_produksi > 0 ? number_format(($produksi_berjalan / $total_produksi) * 100, 1) : 0;
      $percentage_gagal = $total_produksi > 0 ? number_format(($produksi_gagal / $total_produksi) * 100, 1) : 0;
      $percentage_selesai = $total_produksi > 0 ? number_format(($produksi_selesai / $total_produksi) * 100, 1) : 0;
    @endphp

    <!-- Displaying production information -->
    <div class="grid gap-5">
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="text-lg tracking-tight text-gray-900 dark:text-white">Total Produksi Billet</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $total_billet }}</h5>
        </div>
      </div>
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="text-lg tracking-tight text-gray-900 dark:text-white">Total Defected</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $total_defected }}</h5>
        </div>
      </div>
    </div>

    <div class="grid gap-5">
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="text-lg tracking-tight text-gray-900 dark:text-white">Diameter</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $total_diameter }}</h5>
        </div>
      </div>
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="text-lg tracking-tight text-gray-900 dark:text-white">Produksi Berjalan</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $produksi_berjalan }}</h5>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-5">
      <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="text-lg tracking-tight text-gray-900 dark:text-white">Estimasi</h5>
        <div class="flex items-center h-full">
          <h5 class="mb-6 text-5xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $total_time_remaining->format('%d days %h hours %i minutes') }}</h5>
        </div>
      </div>
      <div class="h-full"></div>
    </div>

    <!-- Displaying progress chart -->
    <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 max-h-[450px]">
      <div class="flex justify-between items-start w-full">
        <div class="flex-col items-center">
          <div class="flex flex-col mb-1">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Progress Produksi</h5>
            <div class="py-6 w-full" id="pie-chart"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Displaying thermometer -->
    <div class="grid gap-5 max-h-[450px]">
      <div
        class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 max-h-[450px]">
        <div class="flex justify-between">
          <h5 class="text-lg tracking-tight text-gray-900 dark:text-white">Suhu</h5>
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
    // Function to cool down the temperature
    function coolItDown() {
      var mercuryHeight = {{ $mercury_height }};
      var mercuryBottom = {{ $mercury_bottom }};

      mercuryHeight = 25;
      mercuryBottom = -80;
      var suhu = 3;

      document.getElementById('suhu').innerText = suhu + ' C';
      document.getElementById('mercury').style.animation = 'mercuryAnimation 1s forwards';
      document.getElementById('bulb').style.animation = 'bulbAnimation 1s forwards';

      setTimeout(function() {
        document.getElementById('mercury').style.height = mercuryHeight + 'px';
        document.getElementById('mercury').style.bottom = mercuryBottom + '%';
        document.getElementById('mercury').style.animation = 'none';
        document.getElementById('bulb').style.animation = 'none';
        document.getElementById('mercury').style.backgroundColor = '#01579b';
        document.getElementById('bulb').style.backgroundColor = '#01579b';
      }, 500);
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
                offset: -25,
              },
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
                return value + "%";
              },
            },
          },
          xaxis: {
            labels: {
              formatter: function(value) {
                return value + "%";
              },
            },
            axisTicks: {
              show: false,
            },
            axisBorder: {
              show: false,
            },
          },
        };
      };

      if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
        chart.render();
      }
    });
  </script>
@endsection
