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

@includeIf('instalasi.rekap-isian.patologi-table')

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
                    { title: "#", width: "3%", class: "center aligned" },
                    { title: "Nama Instansi / Lab.", width: "11%", class: "center aligned"  },
                    { title: "Kode Peserta", width: "3%", class: "center aligned"  },
                    { title: "Kode Metode", width: "3%", class: "center aligned"  },
                    { title: "Kode Alat", width: "3%", class: "center aligned"  },
                    { title: "Hasil", width: "5%", class: "center aligned"  },
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
            rawData.forEach(function (item, index) {
                let blank = [
                    index + 1,
                    item.order.invoice.laboratory.name,
                    item.order.invoice.laboratory.participant_number,
                    '-',
                    '-',
                    '-',
                ];

                if (item.value != null) {
                    let value = JSON.parse(item.value);
                    let parameterIdOnJson = getKeyByValue(value, parameterLabel).split("_").slice(-1)[0];

                    let hasil = value[`hasil_${parameterIdOnJson}_bottle_${bottle}`];

                    if (hasil != null && hasil !== "") {

                        let metode = value[`method_${parameterIdOnJson}_bottle_${bottle}`];

                        let alat = value[`equipment_${parameterIdOnJson}_bottle_${bottle}`];

                        result.push([
                            index + 1,
                            item.order.invoice.laboratory.name,
                            item.order.invoice.laboratory.participant_number,
                            metode,
                            alat,
                            hasil,
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
