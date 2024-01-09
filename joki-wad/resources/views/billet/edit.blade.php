@extends('layout.layout')

@section('content')
<div class="container">
  <form action="/billet/{{$billet->id}}" method="POST">
    @csrf
    @method('PUT')
    <label for="total_billet">Total Billet</label>
    <input type="number" name="total_billet" placeholder="Total Billet" class="form-control" value="{{$billet->total_billet}}">
    <label for="diameter">Diameter Billet</label>
    <input type="number" name="diameter" placeholder="Diameter Billet" class="form-control" value="{{$billet->diameter}}">
    <label for="status">Status</label>
    <input type="text" name="status" placeholder="Status" class="form-control" value="{{$billet->status}}">
    <label for="total_defected">Billet Defected</label>
    <input type="number" name="total_defected" placeholder="Billet Defected" class="form-control" value="{{$billet->total_defected}}">
    <button class="btn btn-primary">Update</button>
  </form>
</div>
@endsection