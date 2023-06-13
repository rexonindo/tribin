<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Item Master Report</h1>
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
            <div class="col mb-1">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" id="btnExport" title="Export to spreadsheet file" onclick="btnExportOnclick(this)"><i class="fas fa-file-excel"></i></button>
                    <button type="button" class="btn btn-outline-primary" id="btnSearch" title="Search" onclick="btnSearchOnclick(this)"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive" id="divItemReportContainer">
                    <table id="tblItemReport" class="table table-striped table-bordered table-sm table-hover">
                        <thead class="table-light">
                            <tr class="first">
                                <th class="align-middle">Item Code</th>
                                <th class="align-middle">Item Name</th>
                                <th class="text-end">Type</th>
                                <th class="text-center">UOM</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Specification</th>
                                <th class="text-center">Category</th>
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
    $("#divItemReportContainer").css('height', $(window).height() -
        document.getElementById('rowStack1').offsetHeight -
        150);

    function btnExportOnclick(p) {
        p.disabled = true
        p.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'
        $.ajax({
            type: "GET",
            data: {
                fileType: 'spreadsheet'
            },
            url: "report/item-master",
            success: function(response) {
                const blob = new Blob([response], {
                    type: "application/vnd.ms-excel"
                })
                const fileName = `Item Master Report.xlsx`
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

    function btnSearchOnclick(p) {
        const data = {
            fileType: 'json',
        }
        p.disabled = true
        p.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'
        $.ajax({
            type: "GET",
            url: "report/item-master",
            data: data,
            dataType: "json",
            success: function(response) {
                p.innerHTML = '<i class="fas fa-search"></i>'
                p.disabled = false
                let myContainer = document.getElementById("divItemReportContainer");
                let myfrag = document.createDocumentFragment();
                let cln = tblItemReport.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("tblItemReport");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newcell = newrow.insertCell(0)
                    newcell.innerHTML = arrayItem['MITM_ITMCD']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMTYPE']
                    newcell = newrow.insertCell(3)
                    newcell.innerHTML = arrayItem['MITM_STKUOM']

                    newcell = newrow.insertCell(4)
                    newcell.innerHTML = arrayItem['MITM_BRAND']
                    newcell = newrow.insertCell(5)
                    newcell.innerHTML = arrayItem['MITM_MODEL']
                    newcell = newrow.insertCell(6)
                    newcell.innerHTML = arrayItem['MITM_SPEC']
                    newcell = newrow.insertCell(7)
                    newcell.innerHTML = arrayItem['MITM_ITMCAT']
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
</script>