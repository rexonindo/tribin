<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Delivery Order</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnPrint" onclick="showPrintModal()" title="Print"><i class="fas fa-print"></i></button>
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
                    <input type="text" id="orderCode" class="form-control" placeholder="SP..." maxlength="17" disabled>
                    <button class="btn btn-primary" type="button" onclick="btnShowSavedDeliveryModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label for="orderIssueDate" class="form-label">Issue Date</label>
                <input type="text" id="orderIssueDate" class="form-control" maxlength="10" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label for="orderQuotation" class="form-label">Sales Order</label>
                <div class="input-group mb-1">
                    <input type="text" id="SalesOrderQuotation" class="form-control" placeholder="../SLO/..." disabled>
                    <button class="btn btn-primary" type="button" id="btnShowSalesOrder" onclick="btnShowSalesOrderModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label for="orderCustomer" class="form-label">Customer</label>
                <div class="input-group mb-1">
                    <input type="text" id="orderCustomer" class="form-control" maxlength="50" disabled>
                    <input type="hidden" id="orderCustomerCode">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1">
                <div class="input-group mb-1">
                    <span class="input-group-text">Invoice Code</span>
                    <input type="text" id="orderInvoiceCode" class="form-control" maxlength="40" readonly disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="input-group mb-1">
                    <span class="input-group-text">Remark</span>
                    <input type="text" id="orderRemarkHead" class="form-control">
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
                    <input type="text" id="orderQty" class="form-control orderInputItem">
                    <input type="hidden" id="orderQtyBackup" class="form-control">
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
                                <select id="SalesOrderSearchBy" class="form-select" onchange="SalesOrderSearch.focus()">
                                    <option value="0">Order Code</option>
                                    <option value="1">Customer</option>
                                </select>
                                <input type="text" id="SalesOrderSearch" class="form-control" maxlength="50" onkeypress="SalesOrderSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="SalesOrderSavedTabelContainer">
                                <table id="SalesOrderSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
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
<!-- Created DO Modal -->
<div class="modal fade" id="DeliveryorderModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delivery Order List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="DeliveryOrderSearchBy" class="form-select" onchange="DeliveryOrderSearch.focus()">
                                    <option value="0">Order Code</option>
                                    <option value="1">Customer</option>
                                </select>
                                <input type="text" id="DeliveryOrderSearch" class="form-control" maxlength="50" onkeypress="DeliveryOrderSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="DeliveryOrderSavedTabelContainer">
                                <table id="DeliveryOrderSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
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
<div class="modal fade" id="printingModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Print</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-1">
                        <div class="card">
                            <div class="card-header">
                                Document Type
                            </div>
                            <div class="card-body">
                                <ul class="list-group text-center">
                                    <li class="list-group-item">
                                        <input class="form-check-input" type="checkbox" value="1" id="txfg_ckDO">
                                        <label class="form-check-label" for="txfg_ckDO">Delivery Order</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input" type="checkbox" value="1" id="txfg_ckINV">
                                        <label class="form-check-label" for="txfg_ckINV">Invoice</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input class="form-check-input" type="checkbox" value="1" id="txfg_ckKwitansi">
                                        <label class="form-check-label" for="txfg_ckKwitansi">Receipt</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col mb-1 text-center">
                    <button class="btn btn-sm btn-primary" title="Print" id="txfg_btnprintseldocs" onclick="btnPrintOnclick()"><i class="fas fa-print"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function btnNewOnclick() {
        tribinClearTextBox()
        orderTable.getElementsByTagName('tbody')[0].innerHTML = ``
        btnShowSalesOrder.disabled = false
    }

    function btnShowSalesOrderModal() {
        const myModal = new bootstrap.Modal(document.getElementById('orderModal'), {})
        orderModal.addEventListener('shown.bs.modal', () => {
            SalesOrderSearch.focus()
        })
        myModal.show()
    }

    function SalesOrderSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: SalesOrderSearchBy.value,
                searchValue: e.target.value,
            }
            SalesOrderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "delivery/outstanding-warehouse",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("SalesOrderSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = SalesOrderSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("SalesOrderSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['TSLO_SLOCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#orderModal').modal('hide')
                            SalesOrderQuotation.value = arrayItem['TSLO_SLOCD']
                            orderCustomer.value = arrayItem['MCUS_CUSNM']
                            orderCustomerCode.value = arrayItem['TSLO_CUSCD']                            
                            loadSalesOrderDetail({
                                doc: arrayItem['TSLO_SLOCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TSLO_PLAN_DLVDT']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    SalesOrderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please try again</td></tr>`
                }
            });
        }
    }

    function showPrintModal() {
        const myModal = new bootstrap.Modal(document.getElementById('printingModal'), {})
        myModal.show()
    }

    $("#orderIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    function loadSalesOrderDetail(data) {
        $.ajax({
            type: "GET",
            url: `delivery/outstanding-warehouse/${btoa(data.doc)}`,
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
                            selectedRowAtOrderTable.value = -1
                            orderItemCode.value = ''
                            orderItemName.value = ''
                            orderQty.value = ''
                            orderQtyBackup.value = ''
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
                            orderQtyBackup.value = selrow.cells[3].innerText
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TSLODETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['BALQT']
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
        const newQty = numeral(orderQty.value).value()
        const oldQty = numeral(orderQtyBackup.value).value()
        if (newQty > oldQty) {
            alertify.warning('New qty could not be greater than old qty !')
            return
        }
        if (newQty <= 0) {
            alertify.warning('at least new qty is 1')
            return
        }
        if (orderCode.value.trim().length > 0) {
            const data = {
                TDLVORDDETA_ITMQT: orderQty.value,
                _token: '{{ csrf_token() }}'
            }
            const idRow = orderTable.rows[selectedRowAtOrderTable.value].cells[0].innerText
            if (confirm('Are you sure ?')) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `delivery/items/${idRow}`,
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
        tribinClearTextBoxByClassName('orderInputItem')
    }

    function btnSaveOnclick(pthis) {
        let itemCode = []
        let itemQty = []
        let itemPrice = []
        let salesOrder = []

        const ttlrows = orderTable.rows.length
        for (let i = 1; i < ttlrows; i++) {
            itemCode.push(orderTable.rows[i].cells[1].innerText.trim())
            itemQty.push(orderTable.rows[i].cells[3].innerText.trim())
            itemPrice.push(0)
            salesOrder.push(SalesOrderQuotation.value)
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
                TDLVORD_CUSCD: orderCustomerCode.value.trim(),
                TDLVORD_ISSUDT: orderIssueDate.value.trim(),
                TDLVORD_REMARK: orderRemarkHead.value.trim(),
                TDLVORD_INVCD: orderInvoiceCode.value.trim(),
                TDLVORDDETA_ITMCD: itemCode,
                TDLVORDDETA_ITMQT: itemQty,
                TDLVORDDETA_PRC: itemPrice,
                TDLVORDDETA_SLOCD: salesOrder,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "delivery",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        orderCode.value = response.doc
                        orderInvoiceCode.value = response.docInvoice
                        loadDeliveryOrderDetail({
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
                TDLVORD_ISSUDT: orderIssueDate.value.trim(),
                TDLVORD_REMARK: orderRemarkHead.value.trim(),
                TDLVORD_INVCD: orderInvoiceCode.value.trim(),
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `delivery/${btoa(orderCode.value)}`,
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

    function loadDeliveryOrderDetail(data) {
        $.ajax({
            type: "GET",
            url: `delivery/document/${btoa(data.doc)}`,
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
                            selectedRowAtOrderTable.value = -1
                            orderItemCode.value = ''
                            orderItemName.value = ''
                            orderQty.value = ''
                            orderQtyBackup.value = ''
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
                            orderQtyBackup.value = selrow.cells[3].innerText
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerText = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TDLVORDDETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TDLVORDDETA_ITMQT']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function btnShowSavedDeliveryModal() {
        const myModal = new bootstrap.Modal(document.getElementById('DeliveryorderModal'), {})
        DeliveryorderModal.addEventListener('shown.bs.modal', () => {
            DeliveryOrderSearch.focus()
        })
        myModal.show()
    }

    function DeliveryOrderSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: DeliveryOrderSearchBy.value,
                searchValue: e.target.value,
            }
            DeliveryOrderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "delivery",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("DeliveryOrderSavedTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = DeliveryOrderSavedTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("DeliveryOrderSavedTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['TDLVORD_DLVCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#DeliveryorderModal').modal('hide')
                            orderCode.value = arrayItem['TDLVORD_DLVCD']
                            orderCustomer.value = arrayItem['MCUS_CUSNM']
                            orderCustomerCode.value = arrayItem['TDLVORD_CUSCD']
                            orderIssueDate.value = arrayItem['TDLVORD_ISSUDT']
                            SalesOrderQuotation.value = arrayItem['TDLVORDDETA_SLOCD']
                            orderRemarkHead.value = arrayItem['TDLVORD_REMARK']
                            orderInvoiceCode.value = arrayItem['TDLVORD_INVCD']
                            btnShowSalesOrder.disabled = true
                            loadDeliveryOrderDetail({
                                doc: arrayItem['TDLVORD_DLVCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TDLVORD_ISSUDT']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    DeliveryOrderSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="3">Please try again</td></tr>`
                }
            });
        }
    }

    function btnPrintOnclick(pthis) {
        let mckdo = txfg_ckDO.checked ? '1' : '0';
        let mckinv = txfg_ckINV.checked ? '1' : '0';
        let mckKwitansi = txfg_ckKwitansi.checked ? '1' : '0';
        if (orderCode.value.trim().length === 0) {
            alertify.message('Delivery Document is required')
            orderCode.focus()
            return
        }
        Cookies.set('JOS_PRINT_FORM', (mckdo + mckinv + mckKwitansi), {
            expires: 365
        });
        window.open(`PDF/delivery-order/${btoa(orderCode.value)}`, '_blank');
    }
</script>