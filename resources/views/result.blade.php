@extends('layout')

@section('content')

    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Uji Korelasi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                    role="tab" aria-controls="contact" aria-selected="false">Analisis Histogram</button>
            </li>
        </ul>
        <div class="tab-content " id="myTabContent">
            <div class="tab-pane fade  show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-bordered mt-5">
                    <tr>
                        <th>No</th>
                        <th>X</th>
                        <th>Y</th>
                        <th>X<sup>2</sup></th>
                        <th>Y<sup>2</sup></th>
                        <th>X*Y</th>
                    </tr>
                    @php
                        $x = 0;
                        $y = 0;
                        $x2 = 0;
                        $y2 = 0;
                        $xy = 0;
                    @endphp
                    @for ($i = 0; $i < max(count($result['plainText']), count($result['chipperText'])); $i++)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $result['plainText'][$i] ?? '-' }}</td>
                            <td>{{ $result['chipperText'][$i] ?? '-' }}</td>
                            <td>{{ pow($result['plainText'][$i] ?? 0, 2) }}</td>
                            <td>{{ pow($result['chipperText'][$i] ?? 0, 2) }}</td>
                            <td>{{ ($result['plainText'][$i] ?? 0) * ($result['chipperText'][$i] ?? 0) }}</td>
                            @php
                                $x += $result['plainText'][$i] ?? 0;
                                $y += $result['chipperText'][$i] ?? 0;
                                $x2 += pow($result['plainText'][$i] ?? 0, 2);
                                $y2 += pow($result['chipperText'][$i] ?? 0, 2);
                                $xy += ($result['plainText'][$i] ?? 0) * ($result['chipperText'][$i] ?? 0);
                            @endphp
                        </tr>
                    @endfor
                    <tr>
                        <th>Jumlah</th>
                        <th>{{ $x }}</th>
                        <th>{{ $y }}</th>
                        <th>{{ $x2 }}</th>
                        <th>{{ $y2 }}</th>
                        <th>{{ $xy }}</th>
                    </tr>
                </table>
            </div>
            <div class="tab-pane fade mb-5" id="contact" role="tabpanel" aria-labelledby="contact-tab">

            </div>
        </div>
    </div>
@endsection
