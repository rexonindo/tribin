<style>
    thead tr.first th,
    thead tr.first td {
        position: sticky;
        top: 0;
    }

    thead tr.second th,
    thead tr.second td {
        position: sticky;
        top: 26px;
    }
</style>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Stock Status</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<div class="row">
    <div class="col mb-1" id="div-alert">
    </div>
</div>
<div class="row" id="inventoryStack1">
    <div class="col-md-6 mb-1">
        <div class="input-group input-group-sm">
            <span class="input-group-text">Search by</span>
            <select class="form-select" id="inventorySearchBy" onchange="inventorySearch.focus()">
                <option value="0">Item Code</option>
                <option value="1">Item Name</option>
            </select>
            <input type="text" class="form-control" id="inventorySearch">
            <button title="Search" class="btn btn-primary" id="inventorySearchButton" onclick="inventorySearchButtonOnClick(this)"> <i class="fas fa-search"></i> </button>

            <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Export to..">
                <i class="fas fa-file-export"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item" href="#" id="ith_btn_xls" onclick="inventoryExportSpreadsheetOnClick(this)"><span style="color: MediumSeaGreen"><i class="fas fa-file-excel"></i></span> Spreadsheet</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-6 mb-1">
        <div class="input-group input-group-sm">
            <span class="input-group-text">Warehouse</span>
            <select class="form-select" id="inventoryLocation">
                <option value="WH1">WH1</option>
            </select>
        </div>
    </div>
</div>
<div class="row" id="inventoryStack2">
    <div class="col-md-12 mb-1">
        <label for="inventoryDate" class="form-label">Date</label>
        <input type="text" class="form-control" id="inventoryDate" readonly>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" id="inventoryReportTabelContainer">
            <table id="inventoryReportTabel" class="table table-sm table-striped table-bordered table-hover">
                <thead class="table-light align-middle text-center">
                    <tr class="first">
                        <th rowspan="2">Item Code</th>
                        <th rowspan="2">Item Name</th>
                        <th colspan="4">Quantity</th>
                        <th rowspan="2">UM</th>
                    </tr>
                    <tr class="second">
                        <th>Opening</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $("#inventoryReportTabelContainer").css('height', $(window).height() -
        document.getElementById('inventoryStack1').offsetHeight -
        document.getElementById('inventoryStack2').offsetHeight -
        150);

    $("#inventoryDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    inventoryDate.value = moment().format('YYYY-MM-DD')

    function inventorySearchButtonOnClick(pthis) {
        const data = {
            searchBy: inventorySearchBy.value,
            searchValue: inventorySearch.value,
            date: inventoryDate.value,
            location: inventoryLocation.value
        }
        pthis.disabled = true
        pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
        $.ajax({
            type: "GET",
            url: "inventory/status",
            data: data,
            dataType: "json",
            success: function(response) {
                pthis.disabled = false
                pthis.innerHTML = `<i class="fas fa-search"></i>`
                let myContainer = document.getElementById("inventoryReportTabelContainer");
                let myfrag = document.createDocumentFragment();
                let cln = inventoryReportTabel.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("inventoryReportTabel");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newcell = newrow.insertCell(0)
                    newcell.innerHTML = arrayItem['MITM_ITMCD']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['OPENINGQT']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['INQT']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['OUTQT']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['STOCKQT']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = arrayItem['MITM_STKUOM']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                pthis.innerHTML = `<i class="fas fa-search"></i>`
                pthis.disabled = false
                alertify.warning(xthrow);
            }
        });
    }

    function inventoryExportSpreadsheetOnClick(pthis) {
        pthis.classList.add('disabled')
        pthis.innerHTML = 'Please wait'
        const data = {
            searchBy: inventorySearchBy.value,
            searchValue: inventorySearch.value,
            date: inventoryDate.value,
            location: inventoryLocation.value
        }
        $.ajax({
            type: "GET",
            url: "report/stock-status",
            data: data,
            success: function(response) {
                const blob = new Blob([response], {
                    type: "application/vnd.ms-excel"
                })
                const fileName = `Stock Status Report ${inventoryDate.value}.xlsx`
                saveAs(blob, fileName)
                pthis.innerHTML = `<span style="color: MediumSeaGreen"><i class="fas fa-file-excel"></i></span> Spreadsheet`
                pthis.classList.remove('disabled')
                alertify.success('Done')
            },
            xhr: function() {
                const xhr = new XMLHttpRequest()
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 2) {
                        if (xhr.status == 200) {
                            xhr.responseType = "blob";
                        } else {
                            pthis.innerHTML = `<span style="color: MediumSeaGreen"><i class="fas fa-file-excel"></i></span> Spreadsheet`
                            pthis.classList.remove('disabled')
                            xhr.responseType = "text";
                        }
                    }
                }
                return xhr
            },
            error: function(xhr, xopt, xthrow) {
                pthis.innerHTML = `<span style="color: MediumSeaGreen"><i class="fas fa-file-excel"></i></span> Spreadsheet`
                pthis.classList.remove('disabled')
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