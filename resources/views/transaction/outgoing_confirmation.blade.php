<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Outgoing Confirmation</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-1 text-center">
            <button class="btn btn-sm btn-outline-primary" id="btnRefresh" onclick="btnRefreshOnclick(this)"><i class="fas fa-sync"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-1">
            <table id="tableConfirmation" class="table table-sm table-striped table-bordered table-hover compact" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">DO Number</th>
                        <th class="text-center">Customer</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var DTOutgoingConfirmation;

    function si_conf_on_GridActionButton_Click(event) {
        if (confirm("Is this DO (" + event.data.TDLVORD_DLVCD + ") delivered ?")) {
            $.ajax({
                type: "POST",
                url: "confirm",
                data: {
                    id: event.data.TDLVORD_DLVCD
                },
                dataType: "json",
                success: function(response) {
                    if (response.status[0].cd == 1) {
                        alertify.success(response.status[0].msg);
                        btnRefreshOnclick();
                    } else {
                        alertify.message(response.status[0].msg);
                    }
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.error(xthrow);
                }
            });
        }
    }

    function btnRefreshOnclick(p) {
        p.disabled = true;
        DTOutgoingConfirmation = $('#tableConfirmation').DataTable({
            select: true,
            fixedHeader: true,
            destroy: true,
            scrollX: true,
            scrollY: true,
            ajax: {
                url: 'delivery/unconfirmed',
                dataSrc: function(json) {
                    btnRefresh.disabled = false;
                    return json.data;
                }
            },
            columns: [{
                    data: 'TDLVORD_DLVCD'
                },
                {
                    data: 'MCUS_CUSNM'
                },
                {
                    data: 'MCUS_CUSNM',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<input type="button" class="btn btn-sm btn-success" value="Confirm">';
                    },
                    createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                        $(cell).on("click", "input", rowData, si_conf_on_GridActionButton_Click);
                    }
                }
            ],
            columnDefs: [{

            }]
        });
    }
</script>