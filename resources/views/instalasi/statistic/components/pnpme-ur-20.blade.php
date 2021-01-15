<div class="medium-form" style="margin-top: 24px">

    <div class="medium-form-content">

        <div class="ui raised green segment">

            <a class="ui green ribbon label">{{ 'Pilih Parameter dan Botol' }}</a>

            <div class="ui grid">
                <div class="ui ten wide column">
                    @includeIf('instalasi.statistic.input-parameter')
                </div>
                <div class="ui six wide column">
                    @includeIf('instalasi.statistic.input-botol')
                </div>
            </div>

        </div>

    </div>

</div>

@includeIf('instalasi.statistic.patologi-table')

@section('statistic-content-script')
    <style>
        .parameter-result {
            background: #e1f5fe;
        }

        .metode-result {
            background: #fff8e1;
        }

        .alat-result {
            background: #fce4ec;
        }
    </style>

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

            $patologiTable = $('#patologi-table');
            $urinalisaTable = $('#alt-urinalisa-table');

            if (["Berat Jenis", "PH"].includes(parameterLabel)) {
                let data = createData(parameterId, parameterLabel);
                $patologiTable.removeAttr("hidden");
                $urinalisaTable.attr("hidden", true);
                $patologiTable.dataTable({
                    destroy: true,
                    data: data,
                    pageLength: 300,
                    lengthMenu: [[100, 200, 300, 400, 500, -1], [100, 200, 300, 400, 500, "Semua"]],
                    columns: [
                        { title: "#", width: "3%", class: "center aligned" },
                        { title: "Nama Instansi / Lab.", width: "11%", class: "center aligned"  },
                        { title: "Kode Peserta", width: "3%", class: "center aligned"  },
                        { title: "Kode Metode", width: "3%", class: "center aligned"  },
                        { title: "Kode Alat", width: "3%", class: "center aligned"  },
                        { title: "Hasil", width: "5%", class: "center aligned"  },

                        { title: "n", width: "3%", class: "parameter-result center aligned"},
                        { title: "Target", width: "5%", class: "parameter-result center aligned"},
                        { title: "SDPA", width: "5%", class: "parameter-result center aligned"},
                        { title: "ZScore", width: "5%", class: "parameter-result center aligned"},
                        { title: "Kategori", width: "5%", class: "parameter-result center aligned"},
                        { title: "Keterangan", width: "5%", class: "parameter-result center aligned"},

                        { title: "n", width: "3%", class: "metode-result center aligned"},
                        { title: "Target", width: "5%", class: "metode-result center aligned"},
                        { title: "SDPA", width: "5%", class: "metode-result center aligned"},
                        { title: "ZScore", width: "5%", class: "metode-result center aligned"},
                        { title: "Kategori", width: "5%", class: "metode-result center aligned"},
                        { title: "Keterangan", width: "5%", class: "metode-result center aligned"},

                        { title: "n", width: "3%", class: "alat-result center aligned"},
                        { title: "Target", width: "5%", class: "alat-result center aligned"},
                        { title: "SDPA", width: "5%", class: "alat-result center aligned"},
                        { title: "ZScore", width: "5%", class: "alat-result center aligned"},
                        { title: "Kategori", width: "5%", class: "alat-result center aligned"},
                        { title: "Keterangan", width: "5%", class: "alat-result center aligned"},
                    ]
                });
            } else {
                $urinalisaTable.removeAttr('hidden');
                $patologiTable.attr("hidden", true);
                $urinalisaTable.dataTable({
                    destroy: true,
                    data: createDataUrinalisa(parameterId, parameterLabel),
                    pageLength: 300,
                    lengthMenu: [[100, 200, 300, 400, 500, -1], [100, 200, 300, 400, 500, "Semua"]],
                    columns: [
                        { title: "#", width: "3%", class: "center aligned" },
                        { title: "Nama Instansi / Lab.", width: "11%", class: "center aligned"  },
                        { title: "Kode Peserta", width: "3%", class: "center aligned"  },
                        { title: "Metode", width: "3%", class: "center aligned"  },
                        { title: "Alat", width: "3%", class: "center aligned"  },
                        { title: "Hasil", width: "5%", class: "center aligned"  },

                        { title: "n", width: "3%", class: "parameter-result center aligned"},
                        { title: "Target", width: "5%", class: "parameter-result center aligned"},
                        { title: "Score", width: "5%", class: "parameter-result center aligned"},
                        { title: "Kriteria", width: "5%", class: "parameter-result center aligned"},
                    ]
                });
            }
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
            rawData.forEach(function (item, index) {
                let blank = [
                    index + 1,
                    item.order.invoice.laboratory.name,
                    item.order.invoice.laboratory.participant_number,
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                ];

                if (item.value != null) {
                    let value = JSON.parse(item.value);
                    let scoreValue = JSON.parse(rawScore.value);
                    let parameterIdOnJson = getKeyByValue(value, parameterLabel).split("_").slice(-1)[0];

                    console.log(value);

                    scoreValue = scoreValue.filter(function (item) {
                        return item.parameter.label === parameterLabel;
                    })[0].results.filter(function (item) {
                        return item.bottleNumber === bottle;
                    })[0];

                    let hasil = value[`hasil_pemeriksaan_${parameterIdOnJson}_bottle_${bottle}`];

                    if (hasil != null && hasil !== "") {

                        let byParameters = scoreValue.byParameters;

                        let byParametersZScore = 0.0;
                        if (byParameters.standardDeviation === 0.0) {
                            byParametersZScore = (hasil - byParameters.mean) / byParameters.resultByHorwitz;
                        } else {
                            byParametersZScore = (hasil - byParameters.mean) / byParameters.standardDeviation;
                        }

                        let byParametersZScoreAbs = Math.abs(byParametersZScore);
                        let byParametersKategori = "";
                        let byParametersKeterangan = "";
                        if (byParametersZScoreAbs < 2.0) {
                            byParametersKategori = "OK";
                            byParametersKeterangan = "Memuaskan";
                        } else if (byParametersZScoreAbs < 3.0) {
                            byParametersKategori = "$";
                            byParametersKeterangan = "Meragukan";
                        } else {
                            byParametersKategori = "$$";
                            byParametersKeterangan = "Kurang Memuaskan";
                        }

                        let metode = value[`method_${parameterIdOnJson}_bottle_${bottle}`];

                        let byMetode = scoreValue.byMethods.find(function (item) {
                            return item.first === metode;
                        });

                        let byMetodeN = null;
                        let byMetodeTarget = null;
                        let byMetodeZScore = null;
                        let byMetodeKategori = null;
                        let byMetodeKeterangan = null;
                        let byMetodeHorwitz = null;
                        if (byMetode && byMetode.second.n >= 6) {
                            byMetodeN = byMetode.second.n;
                            byMetodeTarget = byMetode.second.mean;
                            byMetodeHorwitz = byMetode.second.resultByHorwitz.toFixed(4);
                            if (byMetode.second.standardDeviation === 0.0) {
                                byMetodeZScore = (hasil - byMetodeTarget) / byMetode.second.resultByHorwitz;
                            } else {
                                byMetodeZScore = (hasil - byMetodeTarget) / byMetode.second.standardDeviation;
                            }
                            let byMetodeZScoreAbs = Math.abs(byMetodeZScore);
                            if (byMetodeZScoreAbs < 2.0) {
                                byMetodeKategori = "OK";
                                byMetodeKeterangan = "Memuaskan";
                            } else if (byMetodeZScoreAbs < 3.0) {
                                byMetodeKategori = "$";
                                byMetodeKeterangan = "Meragukan";
                            } else {
                                byMetodeKategori = "$$";
                                byMetodeKeterangan = "Kurang Memuaskan";
                            }

                            byMetodeTarget = byMetodeTarget.toFixed(2);
                            byMetodeZScore = byMetodeZScore.toFixed(2);
                        }

                        let alat = value[`equipment_${parameterIdOnJson}_bottle_${bottle}`];

                        let byAlat = scoreValue.byEquipments.find(function (item) {
                            return item.first === alat;
                        });
                        let byAlatN = null;
                        let byAlatTarget = null;
                        let byAlatZScore = null;
                        let byAlatKategori = null;
                        let byAlatKeterangan = null;
                        let byAlatHorwitz = null;
                        if (byAlat && byAlat.second.n >= 6) {
                            byAlatN = byAlat.second.n;
                            byAlatTarget = byAlat.second.mean;
                            byAlatHorwitz = byAlat.second.resultByHorwitz.toFixed(4);
                            if (byAlat.second.standardDeviation === 0.0) {
                                byAlatZScore = (hasil - byAlatTarget) / byAlat.second.resultByHorwitz;
                            } else {
                                byAlatZScore = (hasil - byAlatTarget) / byAlat.second.standardDeviation;
                            }
                            let byAlatZScoreAbs = Math.abs(byAlatZScore);
                            if (byAlatZScoreAbs < 2.0) {
                                byAlatKategori = "OK";
                                byAlatKeterangan = "Memuaskan";
                            } else if (byAlatZScoreAbs < 3.0) {
                                byAlatKategori = "$";
                                byAlatKeterangan = "Meragukan";
                            } else {
                                byAlatKategori = "$$";
                                byAlatKeterangan = "Kurang Memuaskan";
                            }

                            byAlatTarget = byAlatTarget.toFixed(2);
                            byAlatZScore = byAlatZScore.toFixed(2);
                        }

                        result.push([
                            index + 1,
                            item.order.invoice.laboratory.name,
                            item.order.invoice.laboratory.participant_number,
                            metode,
                            alat,
                            hasil,
                            byParameters.n,
                            byParameters.mean.toFixed(2),
                            byParameters.resultByHorwitz.toFixed(4),
                            byParametersZScore.toFixed(2),
                            byParametersKategori,
                            byParametersKeterangan,
                            printNullable(byMetodeN),
                            printNullable(byMetodeTarget),
                            printNullable(byMetodeHorwitz),
                            printNullable(byMetodeZScore),
                            printNullable(byMetodeKategori),
                            printNullable(byMetodeKeterangan),
                            printNullable(byAlatN),
                            printNullable(byAlatTarget),
                            printNullable(byAlatHorwitz),
                            printNullable(byAlatZScore),
                            printNullable(byAlatKategori),
                            printNullable(byAlatKeterangan),
                        ])
                    } else {
                        result.push(blank);
                    }
                } else {
                    result.push(blank);
                }
            });
            return result;
        }

        function createDataUrinalisa(parameterId, parameterLabel) {
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
            rawData.forEach(function (item, index) {
                let blank = [
                    index + 1,
                    item.order.invoice.laboratory.name,
                    item.order.invoice.laboratory.participant_number,
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                    '-',
                ];

                if (item.value != null) {
                    let value = JSON.parse(item.value);
                    let scoreValue = JSON.parse(rawScore.value);
                    let parameterIdOnJson = getKeyByValue(value, parameterLabel).split("_").slice(-1)[0];

                    console.log(value);

                    scoreValue = scoreValue.filter(function (item) {
                        return item.parameter.label === parameterLabel;
                    })[0].results.filter(function (item) {
                        return item.bottleNumber === bottle;
                    })[0];

                    let hasil = value[`hasil_pemeriksaan_${parameterIdOnJson}_bottle_${bottle}`];

                    if (hasil != null && hasil !== "") {

                        let byParameters = scoreValue.byParameters;

                        let score = 0;
                        let kriteria = "";
                        if(byParameters.mode === hasil) {
                            score = 4;
                            kriteria = "Baik"
                        } else {
                            let posValuePeserta = hasil[hasil.length - 1];
                            let posValueTarget = 0;
                            if (byParameters.mode !== "negatif") {
                                posValueTarget = byParameters.mode[byParameters.mode.length - 1]
                            }
                            let selisih = Math.abs(posValuePeserta - posValueTarget);
                            if (selisih === 1) {
                                score = 3;
                                kriteria = "Cukup"
                            } else if (selisih === 2) {
                                score = 2;
                                kriteria = "Kurang"
                            } else {
                                score = 1;
                                kriteria = "Buruk"
                            }
                        }

                        let metode = value[`method_${parameterIdOnJson}_bottle_${bottle}`];

                        let alat = value[`equipment_${parameterIdOnJson}_bottle_${bottle}`];

                        result.push([
                            index + 1,
                            item.order.invoice.laboratory.name,
                            item.order.invoice.laboratory.participant_number,
                            metode,
                            alat,
                            hasil,
                            byParameters.nRaw,
                            byParameters.mode,
                            score,
                            kriteria,
                        ])
                    } else {
                        result.push(blank);
                    }
                } else {
                    result.push(blank);
                }
            });
            return result;
        }

        function getKeyByValue(object, value) {
            return Object.keys(object).find(key => object[key] === value);
        }

        function printNullable(nullable) {
            if (nullable === null) {
                return "-";
            }
            return nullable;
        }
    </script>
@endsection
