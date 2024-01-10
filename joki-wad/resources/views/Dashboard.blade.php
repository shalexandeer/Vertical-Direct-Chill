@extends('layout.layout')

@section('content')
  <div class="container flex gap-5    ">
    @php
      $total_billet = 0; // Initialize the total variable
      $total_defected = 0; // Initialize the total defected variable
    @endphp
    @foreach ($billets as $billet)
      {{-- sum total billet --}}
      @php
        $total_billet += $billet->total_billet;
      @endphp
      {{-- sum total billet --}}
      {{-- sum total defected --}}
      @php
        $total_defected += $billet->total_defected;
      @endphp
    @endforeach
    <h1>Total Billet: {{ $total_billet }}</h1>
    <h1>Total Billet: {{ $total_billet }}</h1>
  </div>
@endsection
