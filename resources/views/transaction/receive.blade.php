<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Receive</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-primary" id="btnSubmit" onclick="btnSubmitOnclick(this)" title="Affect stock status">Submit</button>
        </div>
    </div>
</div>
<form id="order-form">
    <div class="container">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label for="orderCode" class="form-label">Code</label>
                <div class="input-group mb-1">
                    <input type="text" id="orderCode" class="form-control" placeholder="Autogenerate" maxlength="17" disabled>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#orderModal"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label for="orderIssueDate" class="form-label">Receive Date</label>
                <input type="text" id="orderIssueDate" class="form-control" maxlength="10" readonly>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label for="orderSupplier" class="form-label">Supplier Name</label>
                <div class="input-group input-group-sm mb-1">
                    <input type="text" id="orderSupplier" class="form-control" maxlength="50" disabled>
                    <input type="hidden" id="orderSupplierCode">
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label for="receiveSupplierDN" class="form-label">Supplier DN</label>
                <input type="text" id="receiveSupplierDN" class="form-control form-control-sm" maxlength="45">
            </div>
        </div>
        <div class="row border-top">
            <div class="col-md-12 mb-1">
                <div class="table-responsive" id="orderTableContainer">
                    <table id="orderTable" class="table table-sm table-hover table-bordered caption-top">
                        <caption>List of items</caption>
                        <thead class="table-light">
                            <tr>
                                <th class="d-none">idLine</th>
                                <th>Document Code</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Code</span>
                    <input type="text" id="orderItemCode" class="form-control orderInputItem" placeholder="Item Code" disabled>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Name</span>
                    <input type="text" id="orderItemName" class="form-control orderInputItem" disabled>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Qty</span>
                    <input type="text" id="orderQty" class="form-control orderInputItem" title="price per hour">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" id="btnUpdateLine" onclick="btnUpdateLineOnclick(this)">Update line</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnRemoveLine" onclick="btnRemoveLineOnclick(this)">Remove line</button>
                </div>
            </div>
            <div class="col-md-6 mb-1 text-end">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" id="btnFromPO">Addition</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="btnFromPOLineOnclick(this)">From PO</a></li>
                        <li><a class="dropdown-item" href="#">From Internal DO</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="orderInputMode" value="0">
</form>

<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Receive List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="orderSearchBy" class="form-select" onchange="orderSearch.focus()">
                                    <option value="0">Receive Code</option>
                                    <option value="1">Supplier</option>
                                    <option value="2">DN</option>
                                </select>
                                <input type="text" id="orderSearch" class="form-control" maxlength="50" onkeypress="orderSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="orderSavedTabelContainer">
                                <table id="orderSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Supplier</th>
                                            <th>DN</th>
                                            <th>Receive Date</th>
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

<!-- Modal Outstanding PO-->
<div class="modal fade" id="purchaseOutStandingModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">PO Outstanding List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="purchaseSearchSearchBy" class="form-select" onchange="purchaseSearch.focus()">
                                    <option value="0">Purchase Code</option>
                                    <option value="1">Supplier</option>
                                </select>
                                <input type="text" id="purchaseSearch" class="form-control" maxlength="50" onkeypress="purchaseSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="purchaseOutStandingTabelContainer">
                                <table id="purchaseOutStandingTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Supplier</th>
                                            <th>Issue Date</th>
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
    Inputmask({
        'alias': 'decimal',
        'groupSeparator': ',',
    }).mask(orderQty);

    function btnSaveOnclick(pthis) {
        let purchaseCode = []
        let itemCode = []
        let itemQty = []
        let itemPrice = []

        let ttlrows = 0

        ttlrows = orderTable.rows.length
        for (let i = 1; i < ttlrows; i++) {
            purchaseCode.push(orderTable.rows[i].cells[1].innerText.trim())
            itemCode.push(orderTable.rows[i].cells[2].innerText.trim())
            itemQty.push(numeral(orderTable.rows[i].cells[4].innerText.trim()).value())
            itemPrice.push(numeral(orderTable.rows[i].cells[5].innerText.trim()).value())
        }

        if (ttlrows === 1) {
            alertify.message('nothing to be saved')
            return
        }
        if (orderIssueDate.value.length === 0) {
            alertify.message('issue date is required')
            orderIssueDate.focus()
            return
        }

        if (orderCode.value.length === 0) {

            const data = {
                TRCV_SUPCD: orderSupplierCode.value.trim(),
                TRCV_ISSUDT: orderIssueDate.value.trim(),
                TRCV_RCVCD: receiveSupplierDN.value.trim(),
                po_number: purchaseCode,
                item_code: itemCode,
                quantity: itemQty,
                unit_price: itemPrice,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "receive",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)

                        orderCode.value = response.doc
                        loadQuotationDetail({
                            doc: response.doc
                        })
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
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
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.warning(xthrow);
                        pthis.disabled = false
                    }
                });
            }
        } else {
            const data = {
                TRCV_ISSUDT: orderIssueDate.value.trim(),
                TRCV_RCVCD: receiveSupplierDN.value.trim(),
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `receive/form/${btoa(orderCode.value)}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
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
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.warning(xthrow);
                        pthis.disabled = false
                    }
                });
            }
        }
    }

    function btnNewOnclick(pthis) {
        tribinClearTextBox()
        orderTable.getElementsByTagName('tbody')[0].innerHTML = ``
    }

    function btnFromPOLineOnclick() {
        const myModal = new bootstrap.Modal(document.getElementById('purchaseOutStandingModal'), {})
        myModal.show()
    }

    purchaseOutStandingModal.addEventListener('shown.bs.modal', () => {
        purchaseSearch.focus()
    })

    orderModal.addEventListener('shown.bs.modal', () => {
        orderSearch.focus()
    })

    function purchaseSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: purchaseSearchSearchBy.value,
                searchValue: e.target.value,
            }
            $.ajax({
                type: "GET",
                url: "receive/outstanding-po",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("purchaseOutStandingTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = purchaseOutStandingTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("purchaseOutStandingTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['TPCHORDDETA_PCHCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $("#purchaseOutStandingModal").modal('hide')
                            purchaseOutStandingTabel.getElementsByTagName('tbody')[0].innerHTML = ''
                            orderSupplier.value = arrayItem['MSUP_SUPNM']
                            orderSupplierCode.value = arrayItem['MSUP_SUPCD']
                            loadDocumentDetail({
                                doc: arrayItem['TPCHORDDETA_PCHCD']
                            })
                        }
                        newcell = newrow.insertCell(-1)
                        newcell.innerHTML = arrayItem['MSUP_SUPNM']
                        newcell = newrow.insertCell(-1)
                        newcell.innerHTML = arrayItem['TPCHORD_ISSUDT']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                }
            });
        }
    }

    function loadDocumentDetail(data) {
        $.ajax({
            type: "GET",
            url: `receive/outstanding-po/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                let myContainer = document.getElementById("orderTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = orderTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("orderTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = orderTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                            orderItemCode.value = ''
                            orderItemName.value = ''
                            Inputmask.setValue(orderQty, 0)
                        } else {
                            const ttlrows = orderTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                orderTable.rows[i].classList.remove('table-info')
                                orderTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')

                            orderItemCode.value = selrow.cells[2].innerText
                            orderItemName.value = selrow.cells[3].innerText
                            Inputmask.setValue(orderQty, selrow.cells[4].innerText)
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.style.cssText = 'cursor:pointer'
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['TPCHORDDETA_PCHCD']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['TPCHORDDETA_ITMCD']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['BALQT']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TPCHORDDETA_ITMPRC_PER']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function btnRemoveLineOnclick(pthis) {
        const ttlrows = orderTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (orderTable.rows[i].title === 'selected') {
                idItem = orderTable.rows[i].cells[0].innerText.trim()
                iFounded = i
                break
            }
        }

        if (iFounded > 0) {
            if (confirm(`Are you sure want to delete ?`)) {
                if (idItem.length >= 1) {
                    pthis.disabled = true
                    pthis.innerHTML = `Please wait`
                    $.ajax({
                        type: "DELETE",
                        url: `receive/item/${idItem}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Remove line`
                            pthis.disabled = false

                            orderTable.rows[iFounded].remove()
                            alertify.message(response.msg)
                            tribinClearTextBoxByClassName('orderInputItem')

                            if (response.headRowsCount === 0) {
                                btnNewOnclick(btnNew)
                            }
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Remove line`
                        }
                    });
                } else {
                    orderTable.rows[iFounded].remove()
                    tribinClearTextBoxByClassName('orderInputItem')
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function btnUpdateLineOnclick(pthis) {
        const ttlrows = orderTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (orderTable.rows[i].title === 'selected') {
                idItem = orderTable.rows[i].cells[0].innerText.trim()
                iFounded = i
                break
            }
        }

        if (iFounded > 0) {
            if (idItem.length >= 1) {
                if (orderCode.value.length === 0) {
                    alertify.warning(`receive code is required`)
                    return
                }
                if (confirm(`Are you sure want to update ?`)) {
                    pthis.disabled = true
                    pthis.innerHTML = `Please wait`
                    const data = {
                        _token: '{{ csrf_token() }}',
                        quantity: orderQty.value,
                    }
                    $.ajax({
                        type: "PUT",
                        url: `receive/items/${idItem}`,
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Update line`
                            pthis.disabled = false

                            if (response.msg === 'OK') {
                                refreshTableRent(iFounded)
                            }

                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Update line`
                        }
                    });
                }
            } else {
                refreshTableRent(iFounded)
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function refreshTableRent(selectedRow) {
        orderTable.rows[selectedRow].cells[4].innerText = orderQty.value
    }

    function loadQuotationDetail(data) {
        $.ajax({
            type: "GET",
            url: `receive/form/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {

                let myContainer = document.getElementById("orderTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = orderTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("orderTable");

                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''

                response.dataItem.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = orderTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                            orderItemCode.value = ''
                            orderItemName.value = ''
                            Inputmask.setValue(orderQty, 0)
                        } else {
                            const ttlrows = orderTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                orderTable.rows[i].classList.remove('table-info')
                                orderTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')

                            orderItemCode.value = selrow.cells[2].innerText
                            orderItemName.value = selrow.cells[3].innerText
                            Inputmask.setValue(orderQty, selrow.cells[4].innerText)
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerText = arrayItem['id']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['po_number']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['item_code']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['quantity']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['unit_price']

                })

                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    $("#orderIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    function orderSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: orderSearchBy.value,
                searchValue: e.target.value,
            }
            orderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "receive",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("orderSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = orderSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("orderSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['id']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#orderModal').modal('hide')
                            orderCode.value = arrayItem['id']
                            orderIssueDate.value = arrayItem['TRCV_ISSUDT']
                            orderSupplier.value = arrayItem['MSUP_SUPNM']
                            orderSupplierCode.value = arrayItem['MSUP_SUPCD']
                            receiveSupplierDN.value = arrayItem['TRCV_RCVCD']
                            loadQuotationDetail({
                                doc: arrayItem['id']
                            })
                            orderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = ''

                            btnSubmit.disabled = arrayItem['TRCV_SUBMITTED_AT'] ? true : false
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MSUP_SUPNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TRCV_RCVCD']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['TRCV_ISSUDT']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    orderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4"></td></tr>`
                }
            });
        }
    }

    function btnSubmitOnclick(pthis) {
        if (!confirm("Submit this document ?")) {
            return
        }
        pthis.disabled = true
        $.ajax({
            type: "post",
            url: `receive/form/${btoa(orderCode.value)}`,
            data: {
                _token: '{{ csrf_token() }}',
            },
            dataType: "json",
            success: function(response) {
                alertify.success(response.message);
            },
            error: function(xhr, xopt, xthrow) {
                pthis.disabled = false
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
                alertify.warning(xthrow);
            }
        });
    }
</script>