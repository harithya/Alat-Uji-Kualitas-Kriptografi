@extends('layout')

@section('content')

    <div class="container mt-5">
        <form method="POST" action="{{ url('store') }}">
            @csrf
            <div class="form-group mb-4">
                <label>Plaintext</label>
                <textarea class="form-control" rows="5" name="plaintext"></textarea>
            </div>
            <div class="form-group mb-4">
                <label>Chippertext</label>
                <textarea class="form-control" rows="5" name="chippertext"></textarea>
            </div>
            <button class="btn btn-primary">Hitung Sekarang</button>
        </form>
    </div>
@endsection
