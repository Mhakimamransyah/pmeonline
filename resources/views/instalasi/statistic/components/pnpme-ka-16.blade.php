<div class="medium-form" style="margin-top: 24px">

    <div class="medium-form-content">

        <div class="ui raised green segment">

            <a class="ui green ribbon label">{{ 'Pilih Parameter dan Botol' }}</a>

            <div class="ui grid">
                <div class="ui ten wide column">
                    @includeIf('instalasi.statistic.input-parameter')
                </div>
                <div class="ui six wide column">
                    <div class="ui form" style="margin-top: 16px;">

                        <div class="ui field">
                            <label for="input-bottle">Botol</label>
                            <select id="input-bottle" class="ui search fluid dropdown">
                                <option selected value="1">Botol 1</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@includeIf('instalasi.statistic.patologi-table')

@section('statistic-content-script')
    <script>
        let rawData = @json($submits);
        let rawScore = @json($score);
        $inputParameter = $('#input-parameter');
        $inputBottle = $('#input-bottle');

        $inputParameter.on('change', function () {
            displayData();
        });

        $inputBottle.on('change', function () {
            displayData();
        });

        function displayData() {
            let parameterId = $inputParameter.val();
            let parameterLabel = $inputParameter.find(':selected').data('parameter-label');

            let data = createData(parameterId, parameterLabel);

            $('#patologi-table').dataTable({
                destroy: true,
                data: data,
                pageLength: 300,
                lengthMenu: [[100, 200, 300, 400, 500, -1], [100, 200, 300, 400, 500, "Semua"]],
                columns: [
                    { title: "#", width: "5%" },
                    { title: "Nama Instansi / Lab.", width: "45%" },
                    { title: "Kode Peserta", width: "10%" },
                    { title: "Kode Kemasan", width: "10%" },
                    { title: "Hasil", width: "10%" },
                    { title: "U* (Ketidakpastian)", width: "10%" },
                    { title: "Metode", width: "10%" },
                    { title: "Nilai Evaluasi", width: "10%" },
                    { title: "SDPA", width: "10%" },
                    { title: "ZScore", width: "10%" },
                    { title: "Kategori", width: "10%" },
                    { title: "Kesimpulan", width: "10%" }
                ]
            });
        }

        function createData(parameterId, parameterLabel) {
            let result = [];
            let bottle = $inputBottle.val();
            if (bottle == null || bottle === "") {
                toastr.error("Silakan pilih botol terlebih dahulu.");
                return result;
            }
            if (parameterId == null || parameterId === "") {
                toastr.error("Silakan pilih parameter terlebih dahulu.");
                return result;
            }

            let scoreValue = JSON.parse(rawScore.value).filter(function (item) {
                return item.parameter.label === parameterLabel;
            })[0].results.filter(function (item) {
                return item.bottleNumber === bottle;
            })[0];

            let byParameters = scoreValue.byParameters;

            console.log(rawData);
            rawData.forEach(function (item, index) {
                if (item.value != null) {
                    let value = JSON.parse(item.value);
                    let hasil = value[`hasil_pengujian_${parameterLabel.replace(" ", "_")}`];
                    let zScore = 0;
                    if (byParameters.resultByHorwitz === 0.0) {
                        zScore = (hasil - byParameters.mean) / byParameters.standardDeviation;
                    } else {
                        zScore = (hasil - byParameters.mean) / byParameters.resultByHorwitz;
                    }
                    let absZScore = Math.abs(zScore);
                    let $kategori = "";
                    let $keterangan = "";
                    if (absZScore < 2.0 && hasil != null) {
                        $kategori = "OK";
                        $keterangan = "Memuaskan";
                    } else if (absZScore < 3.0 && hasil != null) {
                        $kategori = "$";
                        $keterangan = "Meragukan";
                    } else if (hasil != null) {
                        $kategori = "$$";
                        $keterangan = "Kurang Memuaskan";
                    }
                    result.push([
                        index + 1,
                        item.order.invoice.laboratory.name,
                        item.order.invoice.laboratory.participant_number,
                        value[`kode_bahan_kontrol`],
                        hasil,
                        value[`ketidakpastian_${parameterLabel.replace(" ", "_")}`],
                        value[`metode_${parameterLabel.replace(" ", "_")}`],
                        byParameters.mean.toFixed(3),
                        byParameters.resultByHorwitz.toFixed(3),
                        zScore.toFixed(3),
                        $kategori,
                        $keterangan,
                    ])
                } else {
                    result.push([
                        index + 1,
                        item.order.invoice.laboratory.name,
                        item.order.invoice.laboratory.participant_number,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                        '',
                    ])
                }
            });
            return result;
        }

        function getKeyByValue(object, value) {
            return Object.keys(object).find(key => object[key] === value);
        }
    </script>
@endsection
