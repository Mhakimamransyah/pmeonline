<script>
    $.get(dataSourceUrl, function(data, status) {
        $('#cycle-laboratory-list-table').DataTable({
            "language" : {
                "url" : "{{ asset('data-tables/Indonesian.json') }}"
            },
            "pageLength": 50,
            "ordering": false,
            "data": data,
            "columns": [
                {
                    "data": "name",
                    "createdCell": setupLaboratoryNameCell,
                },
                {
                    "data": "id",
                    "class": "center aligned",
                    "createdCell": setupInvoiceCell,
                },
            ],
        });
        $('.custom-progress-layout').each(function () {
            $(this).remove();
        });
        $('.hide-on-loading').each(function () {
            $(this).removeClass('hide-on-loading');
        });
    });

    function setupLaboratoryNameCell(td, cellData, rowData, row, col) {
        let laboratoryNameHtml = '<a href="/administrator/laboratory/item?id=' + rowData.id + '">' + rowData.name  + '</a><br/>';
        let ordersHtml = '<div class="ui labels" style="margin-top: 6px;">';
        let packageIds = [];
        $.each(rowData.selected_invoices, function (id, item) {
            $.each(item.orders, function (id, item) {
                if (item.package.cycle_id.toString() === cycleId && $.inArray(item.package.id, packageIds) === -1) {
                    packageIds.push(item.package.id);
                    if (listType !== 'participant') {
                        ordersHtml += '<a class="ui label">'+ item.package.label + '<div class="detail"></div></a>';
                        return;
                    }
                    if (item.submit != null) {
                        if (item.submit.sent) {
                            ordersHtml += '<a target="_blank" href="/administrator/submit/show?order_id=' + item.id + '" class="ui blue image label" style="margin-top: 6px">'+ item.package.label + '<div class="detail"><i class="check icon"></i></div></a>'
                        } else {
                            ordersHtml += '<a target="_blank" href="/administrator/submit/show?order_id=' + item.id + '" class="ui orange image label" style="margin-top: 6px">'+ item.package.label + '<div class="detail"><i class="check icon"></i></div></a>'
                        }
                    } else {
                        ordersHtml += '<a target="_blank" href="/administrator/submit/show?order_id=' + item.id + '" class="ui red image label" style="margin-top: 6px">'+ item.package.label + '<div class="detail"><i class="exclamation icon"></i></div></a>'
                    }
                }
            })
        });
        ordersHtml += '</div>';
        $(td).html(laboratoryNameHtml + ordersHtml);
    }

    function setupInvoiceCell(td, cellData, rowData, row, col) {
        let labels = '';
        if (rowData.selected_invoices.length === 1) {
            $.each(rowData.selected_invoices, function (id, item) {
                let itemLabel = '';
                if (item.is_payment_waiting_verification) {
                    itemLabel += '<a href="/administrator/payment/show?id=' + item.payment.id + '" class="ui label">Menunggu Konfirmasi</a>';
                }
                if (item.is_unpaid) {
                    itemLabel += '<span class="ui yellow label">Belum Dibayar</span>';
                }
                if (item.is_payment_in_debt) {
                    itemLabel += '<a href="/administrator/payment/show?id=' + item.payment.id + '" class="ui purple label">Terhutang</span>';
                }
                if (item.is_payment_rejected) {
                    itemLabel += '<a href="/administrator/payment/show?id=' + item.payment.id + '"  class="ui red label">Ditolak</a>';
                }
                if (item.is_payment_verified) {
                    itemLabel += '<a href="/administrator/payment/show?id=' + item.payment.id + '"  class="ui green label">Terverifikasi</a>';
                }
                labels += itemLabel;
            });
        } else {
            labels += '<span class="ui orange label"><i class="exclamation icon"></i>' + rowData.selected_invoices.length + ' Tagihan' + '<span>';
        }
        $(td).html(labels);
    }
</script>