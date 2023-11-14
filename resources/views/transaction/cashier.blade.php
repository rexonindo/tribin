<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cashier</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnPrint" onclick="btnPrintOnClick(this)" title="Print"><i class="fas fa-print"></i></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col mb-1" id="div-alert">
    </div>
</div>
<div class="row">
    <div class="col">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-input-tab" data-bs-toggle="tab" data-bs-target="#nav-input" type="button" role="tab">Transaction</button>
                <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab">History</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-input" role="tabpanel" aria-labelledby="nav-input-tab" tabindex="0">
                <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="cashierCode">Reference</label>
                            <div class="input-group">
                                <input type="text" id="cashierCode" class="form-control">
                                <button class="btn btn-primary" type="button" onclick="btnShowCoaModal()"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="cashierName">User</label>
                            <input type="text" id="cashierName" class="form-control" maxlength="50">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="cashierDate">Date</label>
                            <div class="input-group">
                                <input type="text" id="cashierDate" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="cashierAmount">Amount</label>
                            <input type="text" id="cashierAmount" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <label class="form-label" for="cashierDescription">Description</label>
                            <div class="input-group">
                                <input type="text" id="cashierDescription" class="form-control" maxlength="45">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <label class="form-label" for="cashierDocNumber">Transaction Number</label>
                            <div class="input-group">
                                <input type="text" id="cashierDocNumber" class="form-control" disabled>
                                <button class="btn btn-primary" type="button" onclick="btnShowSavedDataModal()"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="1">
                <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                    <div class="row">
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="cashierFilterDate">Date from</label>
                            <div class="input-group">
                                <input type="text" id="cashierFilterDate" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-1">
                            <label class="form-label" for="cashierFilterDate2">Date to</label>
                            <div class="input-group">
                                <input type="text" id="cashierFilterDate2" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-1 text-center">
                            <button class="btn btn-primary" onclick="btnCashierFilterOnClick(this)"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="coaReportTabelContainer">
                                <table id="coaReportTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light align-middle">
                                        <tr class="text-center">
                                            <th rowspan="2">Date</th>
                                            <th rowspan="2">Document</th>
                                            <th rowspan="2">User</th>
                                            <th colspan="3">Amount</th>
                                        </tr>
                                        <tr class="text-center">
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="coaModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Reference List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="coaSearchBy" class="form-select" onchange="coaSearch.focus()">
                                    <option value="0">Document</option>
                                    <option value="1">User</option>
                                </select>
                                <input type="text" id="coaSearch" class="form-control" maxlength="50" onkeypress="coaSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="coaTabelContainer">
                                <table id="coaTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Document</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Saved Cash Transaction -->
<div class="modal fade" id="coaSavedModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="coaSavedSearchBy" class="form-select" onchange="coaSavedSearch.focus()">
                                    <option value="0">Reference</option>
                                    <option value="1">User</option>
                                </select>
                                <input type="text" id="coaSavedSearch" class="form-control" maxlength="50" onkeypress="coaSavedSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="coaSavedTabelContainer">
                                <table id="coaSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Document</th>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#cashierDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    cashierDate.value = moment().format('YYYY-MM-DD')

    $("#cashierFilterDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    cashierFilterDate.value = moment().format('YYYY-MM-DD')

    $("#cashierFilterDate2").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    cashierFilterDate2.value = moment().format('YYYY-MM-DD')

    Inputmask({
        'alias': 'decimal',
        'groupSeparator': ',',
    }).mask(cashierAmount);

    function btnSaveOnclick(pthis) {
        const data = {
            CCASHIER_REFF_DOC: cashierCode.value.trim(),
            CCASHIER_USER: cashierName.value.trim(),
            CCASHIER_PRICE: cashierAmount.inputmask ? cashierAmount.inputmask.unmaskedvalue() : cashierAmount.value.trim(),
            CCASHIER_ISSUDT: cashierDate.value.trim(),
            CCASHIER_REMARK: cashierDescription.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        if (data.CCASHIER_PRICE == 0) {
            cashierAmount.focus()
            alertify.warning('Amount should not be zero')
            return
        }
        if (confirm(`Are you sure ?`)) {
            pthis.innerHTML = `Please wait...`
            pthis.disabled = true
            $.ajax({
                type: "post",
                url: "cashier",
                data: data,
                dataType: "json",
                success: function(response) {
                    pthis.innerHTML = `<i class="fas fa-save"></i>`
                    alertify.success(response.msg)
                    pthis.disabled = false
                    document.getElementById('div-alert').innerHTML = ''
                    cashierCode.value = ''
                    cashierName.value = ''
                    Inputmask.setValue(cashierAmount, 0)
                },
                error: function(xhr, xopt, xthrow) {
                    pthis.disabled = false
                    pthis.innerHTML = `<i class="fas fa-save"></i>`
                    alertify.warning(xthrow);
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
    }

    function btnShowCoaModal() {
        const myModal = new bootstrap.Modal(document.getElementById('coaModal'), {})
        coaModal.addEventListener('shown.bs.modal', () => {
            coaSearch.focus()
        })
        myModal.show()
    }

    function btnShowSavedDataModal() {
        const myModal = new bootstrap.Modal(document.getElementById('coaSavedModal'), {})
        coaModal.addEventListener('shown.bs.modal', () => {
            coaSearch.focus()
        })
        myModal.show()
    }

    function coaSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: coaSearchBy.value,
                searchValue: e.target.value,
            }
            coaTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "SPK",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("coaTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = coaTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("coaTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['CSPK_DOCNO']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#coaModal').modal('hide')
                            cashierCode.value = arrayItem['CSPK_DOCNO']
                            cashierName.value = arrayItem['USER_PIC_NAME']
                            Inputmask.setValue(cashierAmount, numeral(arrayItem['TOTAL_AMOUNT']).value())
                        }
                        newcell = newrow.insertCell(-1)
                        newcell.innerHTML = arrayItem['USER_PIC_NAME']
                        newcell = newrow.insertCell(-1)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TOTAL_AMOUNT']).format('0,0.00')
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    coaTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please try again</td></tr>`
                }
            });
        }
    }

    function btnCashierFilterOnClick(senderElementContext) {
        const data = {
            DATE_FROM: cashierFilterDate.value,
            DATE_TO: cashierFilterDate2.value,
        }
        senderElementContext.disabled = true
        coaReportTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please wait</td></tr>`
        $.ajax({
            type: "GET",
            url: "cashier",
            data: data,
            dataType: "JSON",
            success: function(response) {
                senderElementContext.disabled = false
                let myContainer = document.getElementById("coaReportTabelContainer");
                let myfrag = document.createDocumentFragment();
                let cln = coaReportTabel.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("coaReportTabel");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    if (!arrayItem['CCASHIER_ISSUDT']) {
                        newrow.classList.add('table-info')
                    }
                    newcell = newrow.insertCell(0)
                    newcell.innerHTML = arrayItem['CCASHIER_ISSUDT']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['CCASHIER_REFF_DOC']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['CCASHIER_USER']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['INVALUE']).format('0,0.00')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['OUTVALUE']).format('0,0.00')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['PREVIOUS_BALANCE']).format('0,0.00')
                })
                response.dataTx.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    if (!arrayItem['CCASHIER_ISSUDT']) {
                        newrow.classList.add('table-info')
                    }
                    newcell = newrow.insertCell(0)
                    newcell.innerHTML = arrayItem['CCASHIER_ISSUDT']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['CCASHIER_REFF_DOC']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['CCASHIER_USER']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['INVALUE']).format('0,0.00')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['OUTVALUE']).format('0,0.00')
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['PREVIOUS_BALANCE']).format('0,0.00')
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
                senderElementContext.disabled = false
                coaReportTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please try again</td></tr>`
            }
        });
    }

    function coaSavedSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: coaSavedSearchBy.value,
                searchValue: e.target.value,
            }
            coaSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4" class="text-center">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "cashier/search",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("coaSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = coaSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("coaSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['CCASHIER_ISSUDT']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#coaSavedModal').modal('hide')
                            cashierDocNumber.value = arrayItem['id']
                            cashierCode.value = arrayItem['CCASHIER_REFF_DOC']
                            cashierName.value = arrayItem['CCASHIER_USER']
                            cashierDate.value = arrayItem['CCASHIER_ISSUDT']
                            Inputmask.setValue(cashierAmount, numeral(arrayItem['CCASHIER_PRICE']).value())
                        }
                        newcell = newrow.insertCell(-1)
                        newcell.innerHTML = arrayItem['CCASHIER_REFF_DOC']
                        newcell = newrow.insertCell(-1)
                        newcell.innerHTML = arrayItem['CCASHIER_USER']
                        newcell = newrow.insertCell(-1)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['CCASHIER_PRICE']).format('0,0.00')
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    coaSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please try again</td></tr>`
                }
            });
        }
    }
</script>