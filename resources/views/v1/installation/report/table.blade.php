<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic-ui/semantic.min.css') }}">
    <script
            src="https://code.jquery.com/jquery-3.1.1.min.js"
            integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    <script src="{{ asset('semantic-ui/semantic.min.js') }}"></script>
</head>

<body>

<div class="ui container">

    <br/>

    <form class="ui form" method="get">
        <div class="fields">
            <div class="twelve wide field">
                <label>Parameter</label>
                <select class="ui fluid search dropdown" name="parameter">
                    <option value="">Parameter</option>
                    @foreach($parameters as $item)
                        <option value="{{ $item->name }}" @if($item->name == $parameter) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="four wide field">
                <label>Botol</label>
                <select class="ui fluid search dropdown" name="bottle">
                    <option value="">Botol</option>
                    <option value="0" @if($bottle == 0) selected @endif>1 (Satu)</option>
                    <option value="1" @if($bottle == 1) selected @endif>2 (Dua)</option>
                </select>
            </div>
        </div>

        <button class="ui button" type="submit">Hitung</button>
    </form>

    <br/>

    {{--<button class="ui button" id="calculate_overall">--}}
        {{--Hitung--}}
    {{--</button>--}}
</div>

<table class="ui selectable celled table">

    <thead>
    <tr>
        <th class="center aligned">No</th>
        <th class="center aligned">Laboratorium</th>
        <th class="center aligned">Kode Peserta</th>
        <th class="center aligned">Kode Metode</th>
        <th class="center aligned">Kode Alat</th>
        <th class="center aligned">Kode Pemeriksa</th>
        <th class="center aligned">{{ $parameter }}</th>
        <th class="center aligned">Target</th>
        <th class="center aligned">SDPA</th>
        <th class="center aligned">Z-Score</th>
        <th class="center aligned">abs</th>
        <th class="center aligned">Kategori</th>
        <th class="center aligned">Kesimpulan</th>
    </tr>
    </thead>

    <tbody>
    @php
    $report_index = 1;
    @endphp
    @foreach($reports as $report)
        @php
            $p = \Illuminate\Support\Collection::make($report->bottles[$bottle]->parameters)->first(function ($item) use ($parameter) {
                return $item->name == $parameter;
            });
        @endphp
        @if ($p->hasil != null)
            <tr class="data-items">
                <td class="center aligned">{{ $report_index }}</td>
                <td>{{ $report->laboratory->name }}</td>
                <td class="center aligned">{{ $report->participant_number }}</td>
                <td class="center aligned">{{ $p->metode }}</td>
                <td class="center aligned">{{ $p->alat }}</td>
                <td class="center aligned">{{ $p->kualifikasi_pemeriksa }}</td>
                <td class="hasil center aligned">{{ $p->hasil }}</td>
                <td class="target center aligned">{{ '' }}</td>
                <td class="sdpa center aligned">{{ '' }}</td>
                <td class="z-score center aligned">{{ '' }}</td>
                <td class="abs center aligned">{{ '' }}</td>
                <td class="kategori center aligned">{{ '' }}</td>
                <td class="kesimpulan center aligned">{{ '' }}</td>
            </tr>
            @php
                $report_index += 1;
            @endphp
        @endif
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        calculate();
        $("#calculate_overall").click( function() {
            calculate();
        });
        $('.ui.dropdown')
            .dropdown()
        ;
    });

    function calculate() {
        let items = [];
        let hasilLabels = document.getElementsByClassName('hasil');
        [].forEach.call(hasilLabels, function (hasilLabel) {
            items.push(parseFloat(hasilLabel.innerHTML))
        });
        $.ajax({
            type: 'POST',
            url: 'https://algorithm-a.appspot.com/calculate',
            data: JSON.stringify({
                items: items,
            }),
            contentType: "application/json; charset=utf-8",
            dataType: 'json',
            success: function (data) {
                console.log(data);
                let sdpaLabels = document.getElementsByClassName('sdpa');
                [].forEach.call(sdpaLabels, function (sdpaLabel) {
                    sdpaLabel.innerHTML = data.resultByQuartile.toFixed(3);
                });

                let dataItems = document.getElementsByClassName('data-items');
                [].forEach.call(dataItems, function (dataItem) {
                    let hasil = parseFloat(dataItem.getElementsByClassName('hasil')[0].innerHTML);
                    let sdpa = parseFloat(dataItem.getElementsByClassName('sdpa')[0].innerHTML);
                    let zscore = (hasil - data.mean) / sdpa;
                    if (sdpa === 0 || sdpa === 0.0) {
                        zscore = (hasil - data.mean) / 0.01;
                    }
                    let abs = Math.abs(zscore.toFixed(3));
                    dataItem.getElementsByClassName('z-score')[0].innerHTML = zscore.toFixed(3);
                    dataItem.getElementsByClassName('abs')[0].innerHTML = abs.toFixed(3);
                    dataItem.getElementsByClassName('target')[0].innerHTML = data.mean.toFixed(2);
                    if (abs < 2.0) {
                        dataItem.getElementsByClassName('kategori')[0].innerHTML = 'OK';
                        dataItem.getElementsByClassName('kesimpulan')[0].innerHTML = 'Memuaskan';
                        dataItem.getElementsByClassName('kategori')[0].className += ' positive';
                        dataItem.getElementsByClassName('kesimpulan')[0].className += ' positive';
                    } else if (abs < 3.0) {
                        dataItem.getElementsByClassName('kategori')[0].innerHTML = '$';
                        dataItem.getElementsByClassName('kesimpulan')[0].innerHTML = 'Meragukan';
                        dataItem.getElementsByClassName('kategori')[0].className += ' warning';
                        dataItem.getElementsByClassName('kesimpulan')[0].className += ' warning';
                    } else {
                        dataItem.getElementsByClassName('kategori')[0].innerHTML = '$$';
                        dataItem.getElementsByClassName('kesimpulan')[0].innerHTML = 'Kurang Memuaskan';
                        dataItem.getElementsByClassName('kategori')[0].className += ' error';
                        dataItem.getElementsByClassName('kesimpulan')[0].className += ' error';
                    }
                });
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
</script>

</body>