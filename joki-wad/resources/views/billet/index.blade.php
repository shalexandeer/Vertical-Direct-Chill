@extends('layout.layout')

@section('content')
  <div class="grid gap-4">
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-semibold dark:text-white">Laporan Penjualan Billet</h1>
      <div>
        <a href="/billet/create"><button type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Tambah
            Billet</button></a>
        <button id="btnExport"
          class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
          onclick="ExportToExcel('xlsx')">Print to Excel</button>

      </div>
    </div>
    <div class="relative overflow-x-auto">
      <table id="tableExport" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-600 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Waktu
            </th>
            <th scope="col" class="px-6 py-3">
              Time Remaining
            </th>
            <th scope="col" class="px-6 py-3">
              Total Billet
            </th>
            <th scope="col" class="px-6 py-3">
              Diameter
            </th>
            <th scope="col" class="px-6 py-3">
              Status
            </th>
            <th scope="col" class="px-6 py-3">
              Total Defected
            </th>
            <th scope="col" class="px-6 py-3">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
            @php
             $totalTimeRemaining = 0;
            @endphp

          @forelse ($billets as $billet)
            @php
              $targetTime = $billet->date; // Assuming $billet->date is in the format 'H:i'
              $currentTime = \Carbon\Carbon::now('Asia/Bangkok')->format('H:i:s');

              $targetDateTime = \Carbon\Carbon::parse($targetTime);
              $currentDateTime = \Carbon\Carbon::parse($currentTime);

              $timeRemaining = $currentDateTime->diff($targetDateTime);
              
              //   if current time is passed the target time, then set time remaining to 0
              if ($currentDateTime->gt($targetDateTime)) {
                  // set time remaining to 0 string
                  $formattedTimeRemaining = '0';
              } else {
                  $formattedTimeRemaining = \Carbon\Carbon::now()
                      ->add($timeRemaining)
                      ->diffForHumans();
              }

            @endphp
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <td scope="row" class="px-6 py-4">
                {{ $billet->date }}
              </td>
              <td class="px-6 py-4">
                {{ $formattedTimeRemaining }}
              </td>
              <td class="px-6 py-4">
                {{ $billet->total_billet }}
              </td>
              <td class="px-6 py-4">
                {{ $billet->diameter }}
              </td>
              <td class="px-6 py-4">
                {{ $billet->status }}
              </td>
              <td class="px-6 py-4">
                {{ $billet->total_defected }}
              </td>
              <td>
                <div class="flex gap-2 items-center h-full">
                  <a href="/billet/{{ $billet->id }}/edit" class="btn btn-warning">
                    <button type="button"
                      class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Edit</button>
                  </a>
                  <form action="/billet/{{ $billet->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                      class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                  </form>
                </div>
              </td>
              {{-- if $billet no data then return heading with text no data found --}}
            @empty
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <td scope="row" class="px-6 py-4 text-center" colspan="7">
                No Data Found
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <script>
    function ExportToExcel(type, fn, dl) {
      var elt = document.getElementById('tableExport');
      var wb = XLSX.utils.table_to_book(elt, {
        sheet: "sheet1"
      });
      return dl ?
        XLSX.write(wb, {
          bookType: type,
          bookSST: true,
          type: 'base64'
        }) :
        XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
  </script>
@endsection
