@extends('layout')

@section('content')

    <div class="container mt-5">
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>X</th>
                <th>Y</th>
            </tr>
            @for ($i = 0; $i < max(count($result['plainText']), count($result['chipperText'])); $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $result['plainText'][$i]['value'] }}</td>
                    <td>{{ $result['chipperText'][$i]['value'] }}</td>
                </tr>
            @endfor
        </table>
    </div>
@endsection
