<style>
    thead tr.first th,
    thead tr.first td {
        position: sticky;
        top: 0;
    }

    thead tr.second th,
    thead tr.second td {
        position: sticky;
        top: 23px;
    }
</style>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Stock Ledger</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<div class="row">
    <div class="col mb-1" id="div-alert">
    </div>
</div>


<div class="row" id="rhistory_stack1">
    <div class="col-md-3 mb-1">
        <label for="rhistory_txt_dt" class="form-label">From</label>
        <div class="input-group">
            <input type="text" class="form-control" id="rhistory_txt_dt" readonly>
        </div>
    </div>
    <div class="col-md-3 mb-1">
        <label for="rhistory_txt_dt2" class="form-label">To</label>
        <div class="input-group">
            <input type="text" class="form-control" id="rhistory_txt_dt2" readonly>
        </div>
    </div>
    <div class="col-md-6 mb-1">
        <label for="rhistory_cmb_wh" class="form-label">Warehouse</label>
        <div class="input-group">
            <select class="form-select" id="rhistory_cmb_wh">
                <option value="WH1">WH1</option>
            </select>
        </div>
    </div>
</div>

<div class="row" id="rhistory_stack2">
    <div class="col-md-6 mb-1">
        <div class="input-group input-group-sm">
            <span class="input-group-text">Search by</span>
            <select class="form-select" id="rhistory_cmb_search_by" onchange="rhistory_cmb_search_by_eChange()">
                <option value="0">Item Code</option>
                <option value="1">Item Name</option>
            </select>
            <input type="text" class="form-control" id="rhistory_txt_assy" onkeypress="rhistory_txt_assy_eKPress(event)">
        </div>
    </div>

    <div class="col-md-4 mb-1">
        <div class="btn-group btn-group-sm">
            <button class="btn btn-primary" type="button" id="rhistory_btn_gen"><i class="fas fa-search"></i></button>
            <div class="btn-group btn-group-sm" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-file-export"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <li><a class="dropdown-item" href="#" id="rhistory_btn_xls" onclick="inventoryExportSpreadsheetOnClick(this)"><span style="color: MediumSeaGreen"><i class="fas fa-file-excel"></i></span> Spreadsheet</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-1 text-end">
        <span id="rhistory_lblinfo" class="badge bg-info"></span>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-1">
        <div class="table-responsive" id="rhistory_divku">
            <table id="rhistory_tbl" class="table table-bordered table-sm table-hover" style="font-size:75%">
                <thead class="table-light">
                    <tr class="first">
                        <th rowspan="2" class="align-middle text-center">Date</th>
                        <th rowspan="2" class="align-middle">Item Code</th>
                        <th rowspan="2" class="align-middle">Item Name</th>
                        <th rowspan="2" class="align-middle">Warehouse</th>
                        <th rowspan="2" class="align-middle">Event</th>
                        <th rowspan="2" class="align-middle text-center">Document</th>
                        <th class="text-center" colspan="3">Quantity</th>
                        <th rowspan="2" class="align-middle text-center">UM</th>
                    </tr>
                    <tr class="second">
                        <th class="text-center">IN</th>
                        <th class="text-center">OUT</th>
                        <th class="text-center">BALANCE</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $("#rhistory_divku").css('height', $(window).height() -
        document.getElementById('rhistory_stack1').offsetHeight -
        document.getElementById('rhistory_stack2').offsetHeight -
        160);
    $("#rhistory_btn_xls").click(function(e) {
        let dt1 = document.getElementById('rhistory_txt_dt').value;
        let dt2 = document.getElementById('rhistory_txt_dt2').value;
        let itmcd = document.getElementById('rhistory_txt_assy').value;
        let wh = document.getElementById('rhistory_cmb_wh').value;

        Cookies.set('CKPSI_DDT1', dt1, {
            expires: 365
        });
        Cookies.set('CKPSI_DDT2', dt2, {
            expires: 365
        });
        Cookies.set('CKPSI_DITEMCD', itmcd, {
            expires: 365
        });
        Cookies.set('CKPSI_DWH', wh, {
            expires: 365
        });
        Cookies.set('CKPSI_SEARCHBY', rhistory_cmb_search_by.value, {
            expires: 365
        });

    });

    $("#rhistory_txt_dt").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    $("#rhistory_txt_dt2").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    rhistory_txt_dt.value = moment().format('YYYY-MM-DD')
    rhistory_txt_dt2.value = moment().format('YYYY-MM-DD')

    function rhistory_generate_report() {
        document.getElementById('rhistory_btn_gen').disabled = true;

        let wh = document.getElementById('rhistory_cmb_wh').value;
        $("#rhistory_tbl tbody").empty();
        rhistory_tbl.getElementsByTagName('tbody')[0].innerHTML = '<tr><td colspan="10" class="text-center">Please wait...</td></tr>'

        const data = {
            searchBy: rhistory_cmb_search_by.value,
            searchValue: rhistory_txt_assy.value,
            location: wh,
            date: rhistory_txt_dt.value,
            date2: rhistory_txt_dt2.value,
        }

        $.ajax({
            type: "get",
            url: "inventory/ledger",
            data: data,
            dataType: "json",
            success: function(response) {
                document.getElementById('rhistory_btn_gen').disabled = false;
                let ttlrows = response.data.length;
                if (ttlrows > 0) {
                    let wh = document.getElementById('rhistory_cmb_wh').value;
                    document.getElementById('rhistory_lblinfo').innerText = ttlrows + ' row(s) found';
                    let mydes = document.getElementById("rhistory_divku");
                    let myfrag = document.createDocumentFragment();
                    let mtabel = document.getElementById("rhistory_tbl");
                    let cln = mtabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let tabell = myfrag.getElementById("rhistory_tbl");
                    let tableku2 = tabell.getElementsByTagName("tbody")[0];
                    let newrow, newcell, newText;
                    tableku2.innerHTML = '';
                    let mhead = false;
                    let uom = '';
                    for (let i = 0; i < ttlrows; i++) {
                        newrow = tableku2.insertRow(-1);
                        if (response.data[i].EVENT == '') {
                            newrow.classList.add("table-primary");
                            mhead = true;
                            uom = response.data[i].UM
                        } else {
                            mhead = false;
                        }
                        newcell = newrow.insertCell(0);
                        newcell.classList.add('text-center')
                        newcell.innerHTML = response.data[i].DATEKU
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = response.data[i].CITRN_ITMCD
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = response.data[i].MITM_ITMNM
                        newcell = newrow.insertCell(3);
                        newcell.innerHTML = wh
                        newcell = newrow.insertCell(4);
                        newcell.classList.add('text-center')
                        newcell.innerHTML = response.data[i].EVENT
                        newcell = newrow.insertCell(5);
                        newcell.innerHTML = response.data[i].CITRN_DOCNO
                        newcell = newrow.insertCell(6);
                        newcell.classList.add('text-end')
                        newcell.innerHTML = response.data[i].INQT == '' ? '' : numeral(response.data[i].INQT).format(',')
                        newcell = newrow.insertCell(7);
                        newcell.classList.add('text-end')
                        newcell.innerHTML = response.data[i].OUTQT == '' ? '' : numeral(response.data[i].OUTQT).format(',')
                        newcell = newrow.insertCell(8);
                        if (!mhead) {
                            newcell.title = "BAL";
                        } else {
                            newcell.title = "BAL Bef.";
                        }
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(response.data[i].BALQT).format(',')

                        newcell = newrow.insertCell(9);
                        newcell.classList.add('text-center')
                        newcell.innerHTML = uom
                    }
                    mydes.innerHTML = '';
                    mydes.appendChild(myfrag);
                } else {
                    rhistory_tbl.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="10">not found</td></tr>`
                    alertify.message(response.status[0].msg);
                }
            },
            error: function(xhr, xopt, xthrow) {
                document.getElementById('rhistory_btn_gen').disabled = false;
                alertify.error(xthrow);
                rhistory_tbl.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="10">[${xthrow}], please try again or contact administrator</td></tr>`
            }
        });
    }
    $("#rhistory_btn_gen").click(function(e) {
        rhistory_generate_report()
    });

    function rhistory_cmb_search_by_eChange() {
        rhistory_txt_assy.focus()

    }

    function rhistory_txt_assy_eKPress(e) {
        if (e.key === 'Enter') {
            rhistory_generate_report()
        }
    }

    function inventoryExportSpreadsheetOnClick(pthis) {
        pthis.classList.add('disabled')
        pthis.innerHTML = 'Please wait'
        const data = {
            searchBy: rhistory_cmb_search_by.value,
            searchValue: rhistory_txt_assy.value,
            location: rhistory_cmb_wh.value,
            date: rhistory_txt_dt.value,
            date2: rhistory_txt_dt2.value,
        }
        $.ajax({
            type: "GET",
            url: "report/stock-ledger",
            data: data,
            success: function(response) {
                const blob = new Blob([response], {
                    type: "application/vnd.ms-excel"
                })
                const fileName = `Stock Ledger Report ${rhistory_cmb_wh.value} ${rhistory_txt_dt.value} to ${rhistory_txt_dt2.value}.xlsx`
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