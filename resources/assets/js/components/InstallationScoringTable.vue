<template>
    <table class="ui table celled"></table>
</template>

<script>
    export default {
        name: "InstallationScoringTable",
        props: ['orderList'],
        data() {
            return {
                headers: [
                    { title: '#', class: 'center aligned', width: '8%' },
                    { title: 'Provinsi', class: 'center aligned', width: '20%' },
                    { title: 'Kode Peserta', class: 'center aligned', width: '17%' },
                    { title: 'Nama Laboratorium' },
                ],
                rows: [] ,
                dtHandle: null,
            }
        },
        watch: {
            orderList(orderList, oldVal) {
                this.rows = [];
                // You should _probably_ check that this is changed data... but we'll skip that for this example.
                orderList.forEach(item => {

                    if (item.invoice === null) {
                        return;
                    }

                    // Fish out the specific column data for each item in your data set and push it to the appropriate place.
                    // Basically we're just building a multi-dimensional array here. If the data is _already_ in the right format you could
                    // skip this loop...
                    let row = [];

                    row.push(item.id);
                    row.push(item.invoice.laboratory.province.name);
                    row.push(item.invoice.laboratory.participant_number);

                    let cell3 = item.invoice.laboratory.name;

                    // Labels
                    cell3 += '<div class="ui labels" style="margin-top: 4px">';
                    if (item.submit != null && item.submit.sent === true) {
                        cell3 += '<div class="ui green label">Peserta Telah Mengirim</div>';
                    } else if (item.submit != null && item.submit.sent === false) {
                        cell3 += '<div class="ui orange label">Peserta Belum Mengirim</div>';
                    } else if (item.submit === null) {
                        cell3 += '<div class="ui red label">Peserta Belum Mengisi</div>'
                    }
                    cell3 += '</div>';

                    // Button
                    if (item.submit != null && item.submit.sent === true) {
                        cell3 +=
                            '<div class="ui right floated primary button order-item" data-order-id="' + item.id + '">\n' +
                            '    Evaluasi\n' +
                            '    <i class="right chevron icon"></i>\n' +
                            '</div>';
                    } else if (item.submit != null && item.submit.sent === false) {
                        cell3 +=
                            '<div class="ui right floated primary button disabled">\n' +
                            '    Evaluasi\n' +
                            '    <i class="right chevron icon"></i>\n' +
                            '</div>';
                    } else if (item.submit === null) {
                        cell3 +=
                            '<div class="ui right floated primary button disabled">\n' +
                            '    Evaluasi\n' +
                            '    <i class="right chevron icon"></i>\n' +
                            '</div>';
                    }
                    row.push(cell3);
                    this.rows.push(row);
                });

                // Here's the magic to keeping the DataTable in sync.
                // It must be cleared, new rows added, then redrawn!
                this.dtHandle.clear();
                this.dtHandle.rows.add(this.rows);
                this.dtHandle.draw();

                let vm = this;

                $(this.$el).on('draw.dt', function() {
                    $('.order-item').unbind().on('click', function () {
                        let orderId = $(this).data('order-id');
                        let selectedOrder = vm.orderList.filter(order => order.id === orderId)[0];
                        vm.$emit('order-selected', selectedOrder);
                    });
                });
            }
        },
        mounted() {
            let vm = this;
            // Instantiate the datatable and store the reference to the instance in our dtHandle element.
            vm.dtHandle = $(this.$el).DataTable({
                // Specify whatever options you want, at a minimum these:
                columns: vm.headers,
                data: vm.rows,
                pageLength: 25,
            });
        },
    }
</script>

<style scoped>

</style>