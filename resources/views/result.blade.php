@extends('layout')

@section('content')

    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Uji Korelasi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link " id="entropi-tab" data-bs-toggle="tab" data-bs-target="#entropi" type="button"
                    role="tab" aria-controls="entropi" aria-selected="true">Entropi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                    role="tab" aria-controls="contact" aria-selected="false">Analisis Histogram</button>
            </li>
        </ul>
        <div class="tab-content " id="myTabContent">
            <div class="tab-pane fade  show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="mt-5">
                    <p>Untuk hasil akhirnya adalah <b>{{ number_format($result['correlation'], 4) }}</b></p>
                </div>
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
                            <td>{{ $result['plainText'][$i]['value'] ?? '-' }}</td>
                            <td>{{ $result['chipperText'][$i]['value'] ?? '-' }}</td>
                            <td>{{ pow($result['plainText'][$i]['value'] ?? 0, 2) }}</td>
                            <td>{{ pow($result['chipperText'][$i]['value'] ?? 0, 2) }}</td>
                            <td>{{ ($result['plainText'][$i]['value'] ?? 0) * ($result['chipperText'][$i]['value'] ?? 0) }}
                            </td>
                            @php
                                $x += $result['plainText'][$i]['value'] ?? 0;
                                $y += $result['chipperText'][$i]['value'] ?? 0;
                                $x2 += pow($result['plainText'][$i]['value'] ?? 0, 2);
                                $y2 += pow($result['chipperText'][$i]['value'] ?? 0, 2);
                                $xy += ($result['plainText'][$i]['value'] ?? 0) * ($result['chipperText'][$i]['value'] ?? 0);
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
            <div class="tab-pane fade " id="entropi" role="tabpanel" aria-labelledby="entropi-tab">
                <div class="row mt-5">
                    <div class="col-4">
                        <h5>Plaintext</h5>
                        <p class="mb-4">Untuk hasil dari entropi plaintext adalah
                            <b>{{ number_format($result['entropyPlainText']['result'], 4) }}</b>
                        </p>
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Huruf</th>
                                <th>Jumlah</th>
                            </tr>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($result['entropyPlainText']['data'] as $key => $row)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $row['char'] }}</td>
                                    <td>{{ $row['total'] }}</td>
                                </tr>
                                @php
                                    $i += 1;
                                @endphp
                            @endforeach
                        </table>
                    </div>
                    <div class="col-4">
                        <h5>ChipperText</h5>
                        <p class="mb-4">Untuk hasil dari entropi chippertext adalah
                            <b>{{ number_format($result['entropyChipperText']['result'], 4) }}</b>
                        </p>
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Huruf</th>
                                <th>Jumlah</th>
                            </tr>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($result['entropyChipperText']['data'] as $key => $row)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $row['char'] }}</td>
                                    <td>{{ $row['total'] }}</td>
                                </tr>
                                @php
                                    $i += 1;
                                @endphp
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade " id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="mt-5 row">
                    <div class="col-6">
                        <div id="c1"></div>
                    </div>
                    <div class="col-6">
                        <div id="c2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            const chart = Highcharts.chart('c1', {
                title: {
                    text: 'Data Analisa Histogram Plain Text'
                },
                subtitle: {
                    text: 'Karakter huruf yang sering banyak muncul pada data tersebut'
                },
                xAxis: {
                    categories: {!! json_encode(collect($result['chartPlainText'])->pluck('char')) !!}
                },
                series: [{
                    type: 'column',
                    colorByPoint: true,
                    data: {!! json_encode(collect($result['chartPlainText'])->pluck('total')) !!},
                    showInLegend: false
                }]
            });

            Highcharts.chart('c2', {
                title: {
                    text: 'Data Analisa Histogram Chipper Text'
                },
                subtitle: {
                    text: 'Karakter huruf yang sering banyak muncul pada data tersebut'
                },
                xAxis: {
                    categories: {!! json_encode(collect($result['chartChipperText'])->pluck('char')) !!}
                },
                series: [{
                    type: 'column',
                    colorByPoint: true,
                    data: {!! json_encode(collect($result['chartChipperText'])->pluck('total')) !!},
                    showInLegend: false
                }]
            });
        </script>
    @endpush
@endsection
