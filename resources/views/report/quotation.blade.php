<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quotation Report</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="item-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label for="quotationIssueDateFrom" class="form-label">Issue date from</label>
                <input type="text" id="quotationIssueDateFrom" class="form-control" maxlength="10" readonly>
            </div>
            <div class="col-md-6 mb-1">
                <label for="quotationIssueDateTo" class="form-label">to</label>
                <input type="text" id="quotationIssueDateTo" class="form-control" maxlength="10" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col mb-1">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" id="btnExport" title="Export to spreadsheet file" onclick="btnExportOnclick(this)"><i class="fas fa-file-excel"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    var $dateFrom = $("#quotationIssueDateFrom").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    var $dateTo = $("#quotationIssueDateTo").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $dateFrom.value(moment().format('YYYY-MM-DD'))
    $dateTo.value(moment().format('YYYY-MM-DD'))

    function btnExportOnclick(p) {
        p.disabled = true
        p.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'
        const data = {
            dateFrom: quotationIssueDateFrom.value,
            dateTo: quotationIssueDateTo.value,
        }
        $.ajax({
            type: "GET",
            data: data,
            url: "report/quotation",
            success: function(response) {
                const blob = new Blob([response], {
                    type: "application/vnd.ms-excel"
                })
                const fileName = `Quotation Report ${quotationIssueDateFrom.value} to ${quotationIssueDateTo.value}.xlsx`
                saveAs(blob, fileName)
                p.innerHTML = '<i class="fas fa-file-excel"></i>'
                p.disabled = false
                alertify.success('Done')
            },
            xhr: function() {
                const xhr = new XMLHttpRequest()
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 2) {
                        if (xhr.status == 200) {
                            xhr.responseType = "blob";
                        } else {
                            p.innerHTML = '<i class="fas fa-file-excel"></i>'
                            p.disabled = false
                            xhr.responseType = "text";
                        }
                    }
                }
                return xhr
            },
            error: function(xhr, xopt, xthrow) {
                const respon = Object.keys(xhr.responseJSON)
                const div_alert = document.getElementById('div-alert')
                let msg = ''
                for (const item of respon) {
                    msg += `<p>${xhr.responseJSON[item]}</p>`
                }
                div_alert.innerHTML = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ${msg}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`
            }
        })
    }
</script>