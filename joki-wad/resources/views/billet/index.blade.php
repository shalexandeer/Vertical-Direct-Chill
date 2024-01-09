@extends('layout.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Billet</h1>
                <a href="/billet/create" class="btn btn-primary">Create</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Total Billet</th>
                            <th>Diameter Billet</th>
                            <th>Status</th>
                            <th>Billet Defected</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($billets as $billet)
                            <tr>
                                <td>{{ $billet->date }}</td>
                                  <td>{{ $billet->created_at }}</td>
                                <td>{{ $billet->total_billet }}</td>
                                <td>{{ $billet->diameter }}</td>
                                <td>{{ $billet->status }}</td>
                                <td>{{ $billet->total_defected }}</td>
                                <td>
                                    <a href="/billet/{{$billet->id}}/edit" class="btn btn-warning">Edit</a>
                                    <form action="/billet/{{$billet->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection