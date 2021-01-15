<script>

    $.get(dataSourceUrl, function(data, status) {
        let columns = [
            {
                "data": "id",
                "createdCell": setupNumberCell,
            },
            {
                "data": "id",
                "createdCell": setupProvinceNameCell,
            },
            {
                "data": "id",
                "createdCell": setupCityNameCell,
            },
            {
                "data": "id",
                "createdCell": setupDistrictNameCell,
            },
            {
                "data": "id",
                "createdCell": setupVillageNameCell,
            },
            {
                "data": "id",
                "createdCell": setupLaboratoryNameCell,
            },
            {
                "data": "id",
                "createdCell": setupPemerintahCell,
            },
            {
                "data": "id",
                "createdCell": setupSwastaCell,
            },
            {
                "data": "id",
                "createdCell": setupType1Cell,
            },
            {
                "data": "id",
                "createdCell": setupType2Cell,
            },
            {
                "data": "id",
                "createdCell": setupType3Cell,
            },
            {
                "data": "id",
                "createdCell": setupType4Cell,
            },
            {
                "data": "id",
                "createdCell": setupType5Cell,
            },
            {
                "data": "id",
                "createdCell": setupLaboratoryAddressCell,
            },
            {
                "data": "id",
                "createdCell": setupKodePesertaCell,
            },
            {
                "data": "id",
                "createdCell": setupContactPersonCell,
            },
            {
                "data": "id",
                "createdCell": setupPhoneNumberCell,
            },
            {
                "data": "id",
                "createdCell": setupEmailCell,
            },
        ];
        $.each(packages, function () {
            columns.push({
                "data": "id",
                "createdCell": setupPackageCell,
            });
        });
        $('#cycle-laboratory-list-table').DataTable({
            "language" : {
                "url" : "{{ asset('data-tables/Indonesian.json') }}"
            },
            "scrollX": true,
            "paging": false,
            "ordering": false,
            "data": data,
            "columns": columns,
            "buttons": [
                'copy', 'csv', 'excel', 'pdf'
            ]
        });
        $('.custom-progress-layout').each(function () {
            $(this).remove();
        });
        $('.hide-on-loading').each(function () {
            $(this).removeClass('hide-on-loading');
        });
    });

    function setupNumberCell(td, cellData, rowData, row, col) {
        $(td).html(row + 1);
    }

    function setupProvinceNameCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.province.name)
    }

    function setupCityNameCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.city)
    }

    function setupDistrictNameCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.district)
    }

    function setupVillageNameCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.village)
    }

    function setupLaboratoryNameCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.name)
    }

    function setupPemerintahCell(td, cellData, rowData, row, col) {
        if (rowData.ownership_id === 1) {
            $(td).html('1')
        } else {
            $(td).html('')
        }
    }

    function setupSwastaCell(td, cellData, rowData, row, col) {
        if (rowData.ownership_id === 2) {
            $(td).html('1')
        } else {
            $(td).html('')
        }
    }

    function setupType1Cell(td, cellData, rowData, row, col) {
        if (rowData.type_id === 1) {
            $(td).html('1')
        } else {
            $(td).html('')
        }
    }

    function setupType2Cell(td, cellData, rowData, row, col) {
        if (rowData.type_id === 2) {
            $(td).html('1')
        } else {
            $(td).html('')
        }
    }

    function setupType3Cell(td, cellData, rowData, row, col) {
        if (rowData.type_id === 3) {
            $(td).html('1')
        } else {
            $(td).html('')
        }
    }

    function setupType4Cell(td, cellData, rowData, row, col) {
        if (rowData.type_id === 4) {
            $(td).html('1')
        } else {
            $(td).html('')
        }
    }

    function setupType5Cell(td, cellData, rowData, row, col) {
        if (rowData.type_id === 5) {
            $(td).html('1')
        } else {
            $(td).html('')
        }
    }

    function setupLaboratoryAddressCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.address)
    }

    function setupKodePesertaCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.participant_number)
    }

    function setupContactPersonCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.user.name)
    }

    function setupPhoneNumberCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.phone_number)
    }

    function setupEmailCell(td, cellData, rowData, row, col) {
        $(td).html(rowData.user.email)
    }

    function setupPackageCell(td, cellData, rowData, row, col) {
        let _package = packages[col - 18];
        let _orders = [];
        $.each(rowData.selected_invoices, function (id, invoice) {
            if (invoice.is_payment_verified || invoice.is_payment_in_debt) {
                $.each(invoice.orders, function (id, order) {
                    if (order.package_id === _package.id) {
                        _orders.push(order);
                    }
                });
            }
        });
        if (_orders.length > 0) {
            $(td).html('1');
        } else {
            $(td).html('');
        }
    }

</script>