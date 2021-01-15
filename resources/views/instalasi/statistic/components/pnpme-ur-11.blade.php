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
                    { title: "#", width: "5%" },
                    { title: "Nama Instansi / Lab.", width: "45%" },
                    { title: "Kode Peserta", width: "10%" },
                    { title: "Kode Metode", width: "10%" },
                    { title: "Kode Alat", width: "10%" },
                    { title: "Kode Pemeriksa", width: "10%" },
                    { title: "Hasil", width: "10%" }
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
                if (item.value != null) {
                    let value = JSON.parse(item.value);
                    let parameterIdOnJson = getKeyByValue(value, parameterLabel).split("_").slice(-1)[0];
                    result.push([
                        item.id,
                        item.order.invoice.laboratory.name,
                        item.order.invoice.laboratory.participant_number,
                        value[`method_${parameterIdOnJson}_bottle_${bottle}`],
                        value[`equipment_${parameterIdOnJson}_bottle_${bottle}`],
                        value[`kualifikasi_pemeriksa_${parameterIdOnJson}_bottle_${bottle}`],
                        value[`hasil_pemeriksaan_${parameterIdOnJson}_bottle_${bottle}`],
                    ])
                } else {
                    result.push([
                        item.id,
                        item.order.invoice.laboratory.name,
                        item.order.invoice.laboratory.participant_number,
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