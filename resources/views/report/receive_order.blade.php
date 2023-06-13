<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" id="rowStack0">
    <h1 class="h2">Received Order Report</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="item-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row" id="rowStack1">
            <div class="col-md-6 mb-1">
                <label for="salesIssueDateFrom" class="form-label">Issue date from</label>
                <input type="text" id="salesIssueDateFrom" class="form-control" maxlength="10" readonly>
            </div>
            <div class="col-md-6 mb-1">
                <label for="salesIssueDateTo" class="form-label">to</label>
                <input type="text" id="salesIssueDateTo" class="form-control" maxlength="10" readonly>
            </div>
        </div>
        <div class="row" id="rowStack2">
            <div class="col mb-1">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" id="btnExport" title="Export to spreadsheet file" onclick="btnExportOnclick(this)"><i class="fas fa-file-excel"></i></button>
                    <button type="button" class="btn btn-outline-primary" id="btnSearch" title="Search" onclick="btnSearchOnclick(this)"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive" id="divSalesReportContainer">
                    <table id="tblSalesReport" class="table table-striped table-bordered table-sm table-hover">
                        <thead class="table-light">
                            <tr class="first">
                                <th class="align-middle">Sales</th>
                                <th class="align-middle">Customer</th>
                                <th class="text-end">Attn</th>
                                <th class="text-center">Quotation</th>
                                <th class="text-center" title="from a Customer">PO Number</th>
                                <th class="text-center">Issue Date</th>
                                <th class="text-center">Approved by</th>
                                <th class="text-center">Approved Date</th>
                                <th class="text-center">Item Code</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Item Qty</th>
                                <th class="text-center">Usage</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Operator Price</th>
                                <th class="text-center">Mobdemob</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#divSalesReportContainer").css('height', $(window).height() -
        document.getElementById('rowStack0').offsetHeight -
        document.getElementById('rowStack1').offsetHeight -
        document.getElementById('rowStack2').offsetHeight -
        100);
    var $dateFrom = $("#salesIssueDateFrom").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    var $dateTo = $("#salesIssueDateTo").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $dateFrom.value(moment().format('YYYY-MM-DD'))
    $dateTo.value(moment().format('YYYY-MM-DD'))

    function btnSearchOnclick(p) {
        const data = {
            dateFrom: salesIssueDateFrom.value,
            dateTo: salesIssueDateTo.value,
            fileType: 'json',
        }
        p.disabled = true
        p.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'
        $.ajax({
            type: "GET",
            url: "report/received-order",
            data: data,
            dataType: "json",
            success: function(response) {
                p.innerHTML = '<i class="fas fa-search"></i>'
                p.disabled = false
                let myContainer = document.getElementById("divSalesReportContainer");
                let myfrag = document.createDocumentFragment();
                let cln = tblSalesReport.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("tblSalesReport");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newcell = newrow.insertCell(0)
                    newcell.innerHTML = arrayItem['TSLO_SLOCD']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['MCUS_CUSNM']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['TSLO_ATTN']
                    newcell = newrow.insertCell(3)
                    newcell.innerHTML = arrayItem['TSLO_QUOCD']
                    newcell = newrow.insertCell(4)
                    newcell.innerHTML = arrayItem['TSLO_POCD']

                    newcell = newrow.insertCell(5)
                    newcell.innerHTML = arrayItem['TSLO_ISSUDT']
                    newcell = newrow.insertCell(6)
                    newcell.innerHTML = arrayItem['TSLO_APPRVBY']
                    newcell = newrow.insertCell(7)
                    newcell.innerHTML = arrayItem['TSLO_APPRVDT']
                    newcell = newrow.insertCell(8)
                    newcell.innerHTML = arrayItem['TSLODETA_ITMCD']
                    newcell = newrow.insertCell(9)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(10)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TSLODETA_ITMQT']
                    newcell = newrow.insertCell(11)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TSLODETA_USAGE']
                    newcell = newrow.insertCell(12)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TSLODETA_PRC']).format(',')
                    newcell = newrow.insertCell(13)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TSLODETA_OPRPRC']).format(',')
                    newcell = newrow.insertCell(14)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TSLODETA_MOBDEMOB']).format(',')
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                p.disabled = false
                p.innerHTML = '<i class="fas fa-search"></i>'
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
        });
    }

    function btnExportOnclick(p) {
        p.disabled = true
        p.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'
        const data = {
            dateFrom: salesIssueDateFrom.value,
            dateTo: salesIssueDateTo.value,
            fileType: 'spreadsheet',
        }
        $.ajax({
            type: "GET",
            data: data,
            url: "report/received-order",
            success: function(response) {
                const blob = new Blob([response], {
                    type: "application/vnd.ms-excel"
                })
                const fileName = `Sales Report ${salesIssueDateFrom.value} to ${salesIssueDateTo.value}.xlsx`
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