<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Purchase Order</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnPrint" onclick="btnPrintOnclick(this)" title="Print"><i class="fas fa-print"></i></button>
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
            <div class="col-md-4 mb-1">
                <label for="orderCode" class="form-label">Code</label>
                <div class="input-group mb-1">
                    <input type="text" id="orderCode" class="form-control" placeholder="PO..." maxlength="17" disabled>
                    <button class="btn btn-primary" type="button" onclick="btnShowReceiveModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-4 mb-1">
                <label for="orderIssueDate" class="form-label">Issue Date</label>
                <input type="text" id="orderIssueDate" class="form-control" maxlength="10" readonly>
            </div>
            <div class="col-md-4 mb-1">
                <label for="orderDeliveryDate" class="form-label">Delivery Date</label>
                <input type="text" id="orderDeliveryDate" class="form-control" maxlength="10" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label for="orderCustomer" class="form-label">Supplier Name</label>
                <div class="input-group mb-1">
                    <input type="text" id="orderCustomer" class="form-control" maxlength="50" disabled>
                    <input type="hidden" id="orderCustomerCode">
                    <button class="btn btn-primary" type="button" onclick="btnShowReceiveCustomerModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label for="orderAttn" class="form-label">Attn.</label>
                <input type="text" id="orderAttn" class="form-control" maxlength="50">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="orderQuotation" class="form-label">Purchase Request</label>
                <div class="input-group mb-1">
                    <input type="text" id="orderQuotation" class="form-control" placeholder="PCR..." disabled>
                    <button class="btn btn-primary" type="button" onclick="btnShowQuotationModal()"><i class="fas fa-search"></i></button>
                </div>
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
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th class="text-end">Qty</th>
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
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Code</span>
                    <input type="text" id="orderItemCode" class="form-control orderInputItem" placeholder="Item Code" disabled>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Name</span>
                    <input type="text" id="orderItemName" class="form-control orderInputItem" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Qty</span>
                    <input type="text" id="orderQty" class="form-control orderInputItem" disabled>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Price</span>
                    <input type="text" id="orderPrice" class="form-control orderInputItem">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1 text-center">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" id="btnUpdateLine" onclick="btnUpdateLineOnclick(this)">Update line</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnRemoveLine" onclick="btnRemoveLineOnclick(this)">Remove line</button>
                </div>
            </div>
        </div>
        <input type="hidden" id="orderInputMode" value="0">
        <input type="hidden" id="selectedRowAtOrderTable">
    </div>

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
                                    <option value="0">Order Code</option>
                                    <option value="1">Supplier</option>
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
                                            <th>Issue Date</th>
                                            <th>Delivery Plan Date</th>
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
<!-- Customer Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Supplier List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="supplierSearchBy" class="form-select" onchange="supplierSearch.focus()">
                                    <option value="0">Code</option>
                                    <option value="1">Name</option>
                                    <option value="2">Address</option>
                                </select>
                                <input type="text" id="supplierSearch" class="form-control" maxlength="50" onkeypress="supplierSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="customerTabelContainer">
                                <table id="customerTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Currency</th>
                                            <th>Tax Reg. Number</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
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
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Purchase Request List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="quotationSearchBy" class="form-select" onchange="quotationSearch.focus()">
                                    <option value="0">Purchase Request Code</option>
                                    <option value="1">Supplier</option>
                                </select>
                                <input type="text" id="quotationSearch" class="form-control" maxlength="50" onkeypress="quotationSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="quotationSavedTabelContainer">
                                <table id="quotationSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Supplier</th>
                                            <th>Issue Date</th>
                                            <th>Subject</th>
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
    $("#orderIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $("#orderDeliveryDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    function btnShowReceiveCustomerModal() {
        const myModal = new bootstrap.Modal(document.getElementById('supplierModal'), {})
        supplierModal.addEventListener('shown.bs.modal', () => {
            supplierSearch.focus()
        })
        myModal.show()
    }

    function supplierSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: supplierSearchBy.value,
                searchValue: e.target.value,
            }
            customerTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "supplier",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("customerTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = customerTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("customerTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MSUP_SUPCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#supplierModal').modal('hide')
                            orderCustomerCode.value = arrayItem['MSUP_SUPCD']
                            orderCustomer.value = arrayItem['MSUP_SUPNM']
                            orderAttn.focus()
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MSUP_SUPNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MSUP_CURCD']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['MSUP_TAXREG']
                        newcell = newrow.insertCell(4)
                        newcell.innerHTML = arrayItem['MSUP_ADDR1']
                        newcell = newrow.insertCell(5)
                        newcell.innerHTML = arrayItem['MSUP_TELNO']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    customerTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please try again</td></tr>`
                }
            });
        }
    }

    function btnNewOnclick() {
        tribinClearTextBox()
        orderTable.getElementsByTagName('tbody')[0].innerHTML = ``
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
            if (confirm(`Are you sure ?`)) {
                if (idItem.length >= 1) {
                    pthis.disabled = true
                    pthis.innerHTML = `Please wait`
                    $.ajax({
                        type: "DELETE",
                        url: `receive-order/items/${idItem}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Remove line`
                            pthis.disabled = false
                            orderTable.rows[iFounded].remove()
                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Remove line`
                        }
                    });
                } else {
                    orderTable.rows[iFounded].remove()
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function btnSaveOnclick(pthis) {
        let itemCode = []
        let itemQty = []
        let itemPrice = []

        const ttlrows = orderTable.rows.length
        for (let i = 1; i < ttlrows; i++) {
            itemCode.push(orderTable.rows[i].cells[1].innerText.trim())
            itemQty.push(orderTable.rows[i].cells[3].innerText.trim())
            itemPrice.push(numeral(orderTable.rows[i].cells[4].innerText.trim()).value())
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
                TPCHORD_SUPCD: orderCustomerCode.value.trim(),
                TPCHORD_ATTN: orderAttn.value.trim(),
                TPCHORD_REQCD: orderQuotation.value.trim(),
                TPCHORD_ISSUDT: orderIssueDate.value.trim(),
                TPCHORD_DLVDT: orderDeliveryDate.value.trim(),
                TPCHORDDETA_ITMCD: itemCode,
                TPCHORDDETA_ITMQT: itemQty,
                TPCHORDDETA_ITMPRC_PER: itemPrice,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "purchase-order",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        orderCode.value = response.doc
                        loadReceiveDetail({
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
                TPCHORD_SUPCD: orderCustomerCode.value.trim(),
                TPCHORD_ATTN: orderAttn.value.trim(),
                TPCHORD_ISSUDT: orderIssueDate.value.trim(),
                TPCHORD_DLVDT: orderDeliveryDate.value.trim(),
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `purchase-order/${btoa(orderCode.value)}`,
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

    function btnShowReceiveModal() {
        const myModal = new bootstrap.Modal(document.getElementById('orderModal'), {})
        orderModal.addEventListener('shown.bs.modal', () => {
            orderSearch.focus()
        })
        myModal.show()
    }

    function orderSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: orderSearchBy.value,
                searchValue: e.target.value,
            }
            orderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "purchase-order",
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
                        newcell.innerHTML = arrayItem['TPCHORD_PCHCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#orderModal').modal('hide')
                            orderCode.value = arrayItem['TPCHORD_PCHCD']
                            orderIssueDate.value = arrayItem['TPCHORD_ISSUDT']
                            orderQuotation.value = arrayItem['TPCHORD_REQCD']
                            orderCustomer.value = arrayItem['MSUP_SUPNM']
                            orderCustomerCode.value = arrayItem['TPCHORD_SUPCD']
                            orderDeliveryDate.value = arrayItem['TPCHORD_DLVDT']
                            loadReceiveDetail({
                                doc: arrayItem['TPCHORD_PCHCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MSUP_SUPNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TPCHORD_ISSUDT']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['TPCHORD_DLVDT']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    orderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6"></td></tr>`
                }
            });
        }
    }

    function loadReceiveDetail(data) {
        $.ajax({
            type: "GET",
            url: `purchase-order/document/${btoa(data.doc)}`,
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
                            selectedRowAtOrderTable.value = -1
                            orderItemCode.value = ''
                            orderItemName.value = ''
                            orderQty.value = ''
                            orderPrice.value = ''
                        } else {
                            const ttlrows = orderTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                orderTable.rows[i].classList.remove('table-info')
                                orderTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                            selectedRowAtOrderTable.value = event.target.parentElement.rowIndex
                            orderItemCode.value = selrow.cells[1].innerText
                            orderItemName.value = selrow.cells[2].innerText
                            orderQty.value = selrow.cells[3].innerText
                            orderPrice.value = selrow.cells[4].innerText
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TPCHORDDETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TPCHORDDETA_ITMQT']
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TPCHORDDETA_ITMPRC_PER']).format(',')
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function btnShowQuotationModal() {
        const myModal = new bootstrap.Modal(document.getElementById('quotationModal'), {})
        quotationModal.addEventListener('shown.bs.modal', () => {
            quotationSearch.focus()
        })
        myModal.show()
    }

    function quotationSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: quotationSearchBy.value,
                searchValue: e.target.value,
                approval: '1',
            }
            quotationSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "purchase-request",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("quotationSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = quotationSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("quotationSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['TPCHREQ_PCHCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#quotationModal').modal('hide')
                            orderQuotation.value = arrayItem['TPCHREQ_PCHCD']
                            orderCustomer.value = arrayItem['MSUP_SUPNM']
                            orderCustomerCode.value = arrayItem['TPCHREQ_SUPCD']
                            loadQuotationDetail({
                                doc: arrayItem['TPCHREQ_PCHCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MSUP_SUPNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TPCHREQ_ISSUDT']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['TPCHREQ_PURPOSE']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    quotationSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4"></td></tr>`
                }
            });
        }
    }

    function loadQuotationDetail(data) {
        $.ajax({
            type: "GET",
            url: `purchase-request/${btoa(data.doc)}`,
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
                            selectedRowAtOrderTable.value = -1
                            orderItemCode.value = ''
                            orderItemName.value = ''
                            orderQty.value = ''
                            orderPrice.value = ''
                        } else {
                            const ttlrows = orderTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                orderTable.rows[i].classList.remove('table-info')
                                orderTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                            selectedRowAtOrderTable.value = event.target.parentElement.rowIndex
                            orderItemCode.value = selrow.cells[1].innerText
                            orderItemName.value = selrow.cells[2].innerText
                            orderQty.value = selrow.cells[3].innerText
                            orderPrice.value = selrow.cells[4].innerText
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TPCHREQDETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TPCHREQDETA_ITMQT']).value()
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = 0
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function btnUpdateLineOnclick(pthis) {
        if (orderCode.value.trim().length > 0) {
            const data = {
                TPCHORDDETA_ITMPRC_PER: orderPrice.value,
                _token: '{{ csrf_token() }}'
            }
            const idRow = orderTable.rows[selectedRowAtOrderTable.value].cells[0].innerText
            if (confirm('Are you sure ?')) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `purchase-order/items/${idRow}`,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        pthis.disabled = false
                        document.getElementById('div-alert').innerHTML = ''
                        updateSelectedTable(selectedRowAtOrderTable.value)
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
            updateSelectedTable(selectedRowAtOrderTable.value)
        }
    }

    function updateSelectedTable(pindex) {
        orderTable.rows[pindex].cells[1].innerText = orderItemCode.value
        orderTable.rows[pindex].cells[2].innerText = orderItemName.value
        orderTable.rows[pindex].cells[3].innerText = orderQty.value
        orderTable.rows[pindex].cells[4].innerText = orderPrice.value
        tribinClearTextBoxByClassName('orderInputItem')
    }

    function btnPrintOnclick(){
        if (orderCode.value.trim().length === 0) {
            alertify.message('Code is required')
            orderCode.focus()
            return
        }
        window.open(`PDF/purchase-order/${btoa(orderCode.value)}`, '_blank');
    }
</script>