@extends('layout.layout')

@section('content')
<div class="container">
  <form action="/billet/store" method="POST">
    @csrf
    <label for="total_billet">Total Billet</label>
    <input type="number" name="total_billet" placeholder="Total Billet" class="form-control">
    <label for="diameter">Diameter Billet</label>
    <input type="number" name="diameter" placeholder="Diameter Billet" class="form-control">
    <label for="status">Status</label>
    <input type="text" name="status" placeholder="Status" class="form-control">
    <label for="total_defected">Billet Defected</label>
    <input type="number" name="total_defected" placeholder="Billet Defected" class="form-control">
    <label for="date">Target Tanggal</label>
    <input type="datetime-local" name="date" placeholder="Target Tanggal" class="form-control">
    <button class="btn btn-primary">Create</button>
  </form>
</div>
@endsection