@extends('layout.layout')
@php
  $currentDateTime = now()->format('Y-m-d\TH:i'); // Format compatible with datetime-local input
@endphp
@section('content')
  <div class="grid gap-4">
    <div class="flex justify-start items-center gap-5">
      <a href="/billet">
        <button
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          back
        </button>
      </a>

      <h1 class="text-3xl font-semibold dark:text-white">Edit Billet</h1>
    </div>
    <div
      class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
      <form class="grid gap-6" action="/billet/{{ $billet->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-2 gap-6 items-center">
          <div>
            <label for="total_billet" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah
              Billet</label>
            <input value="{{ $billet->total_billet }}"
              class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              placeholder="Masukkan jumlah billet" type="text" pattern="[0-9]*"
              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="nik"
              name="total_billet" required />
          </div>
          <div>
            <label for="diameter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diameter
              Billet</label>
            <input value="{{ $billet->diameter }}"
              class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              placeholder="Masukkan diameter billet" type="text" pattern="[0-9]*"
              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="nik"
              name="diameter" required />
          </div>
          <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status
              Billet</label>
            <select id="status" name="status" value="{{ $billet->status }}"
              class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option selected="" value="jalan">Sedang Berjalan</option>
              <option value="cacat">Ditemukan Kecacatan</option>
              <option value="selesai">Selesai</option>
            </select>
          </div>
          <div>
            <label for="total_defected" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Defected
              Billet</label>
            <input value="{{ $billet->total_defected }}"
              class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              placeholder="Masukkan jumlah defected billet" type="text" pattern="[0-9]*"
              oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="nik"
              name="total_defected" required />
          </div>
          <div>
            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Target
              Selesai</label>
            <input value="{{ $billet->date }}"
              class=" form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              type="datetime-local" name="date" placeholder="Target Tanggal" required min="{{ $currentDateTime }}" />
          </div>
        </div>
        <button type="submit"
          class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
      </form>
    </div>
  </div>
@endsection
