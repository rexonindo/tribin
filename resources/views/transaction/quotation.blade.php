<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quotation</h1>
    <div class="btn-toolbar mb-1 mb-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnPrint" onclick="btnPrintOnclick(this)" title="Print"><i class="fas fa-print"></i></button>
        </div>
    </div>
</div>
<form id="quotation-form">
    <div class="container">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Item</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Condition</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label for="quotationCode" class="form-label">Quotation Code</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="quotationCode" class="form-control" placeholder="PNW..." maxlength="17" disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowQuotationModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="quotationIssueDate" class="form-label">Issue Date</label>
                                    <input type="text" id="quotationIssueDate" class="form-control" maxlength="10" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label for="quotationCustomer" class="form-label">Customer Name</label>
                                    <div class="input-group input-group-sm mb-1">
                                        <input type="text" id="quotationCustomer" class="form-control" maxlength="50" disabled>
                                        <input type="hidden" id="quotationCustomerCode">
                                        <button class="btn btn-primary" type="button" onclick="btnShowQuotationCustomerModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label for="quotationAttn" class="form-label">Attn.</label>
                                    <input type="text" id="quotationAttn" class="form-control form-control-sm" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="quotationSubject" class="form-label">Subject</label>
                                    <input type="text" id="quotationSubject" class="form-control" placeholder="Penawaran ..." maxlength="100">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="quotationSubject" class="form-label">Project Location</label>
                                    <input type="text" id="quotationProjectLocation" class="form-control" maxlength="100">
                                </div>
                            </div>
                            <div class="row border-top">
                                <div class="col mt-2">
                                    <nav>
                                        <div class="nav nav-tabs" id="quotation-type-nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-rental-tab" data-bs-toggle="tab" data-bs-target="#nav-rental" type="button" role="tab">Rental</button>
                                            <button class="nav-link" id="nav-sale-tab" data-bs-toggle="tab" data-bs-target="#nav-sale" type="button" role="tab">Sale</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="quotation-type-nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-rental" role="tabpanel" tabindex="0">
                                            <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <div class="table-responsive" id="quotationTableContainer">
                                                            <table id="quotationTable" class="table table-sm table-hover table-bordered caption-top">
                                                                <caption>List of items</caption>
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th class="d-none">idLine</th>
                                                                        <th>Item Code</th>
                                                                        <th>Item Name</th>
                                                                        <th class="text-center">Usage</th>
                                                                        <th class="text-end">Price</th>
                                                                        <th class="text-center">Electricity</th>
                                                                        <th class="text-end">SUB TOTAL</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5" class="text-end"> <b>Grand Total</b></td>
                                                                        <td class="text-end"><strong id="strongGrandTotal">0</strong></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Item Code</span>
                                                            <input type="text" id="quotationItemCode" class="form-control quotationInputItem" placeholder="Item Code" disabled>
                                                            <button class="btn btn-primary" type="button" onclick="btnShowItemModal('1')"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Item Name</span>
                                                            <input type="text" id="quotationItemName" class="form-control quotationInputItem" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Usage</span>
                                                            <select id="quotationUsage" class="form-select">
                                                                @foreach ($usages as $r)
                                                                <option value="{{$r->MUSAGE_ALIAS . ' ' . $r->MUSAGE_DESCRIPTION}}">{{$r->MUSAGE_ALIAS . ' ' . $r->MUSAGE_DESCRIPTION}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Price</span>
                                                            <input type="text" id="quotationPrice" class="form-control quotationInputItem" title="price per hour">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Electricity</span>
                                                            <input type="text" id="quotationElectricity" class="form-control quotationInputItem" list="quotationElectricityDL">
                                                            <datalist id="quotationElectricityDL">
                                                                <option value="50Mhz">
                                                                <option value="60Mhz">
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-center">
                                                        <div class="btn-group btn-group-sm">
                                                            <button type="button" class="btn btn-outline-secondary" id="btnSaveLine" onclick="btnSaveLineOnclick(this)">Save line</button>
                                                            <button type="button" class="btn btn-outline-secondary" id="btnRemoveLine" onclick="btnRemoveLineOnclick(this)">Remove line</button>
                                                            <button type="button" class="btn btn-outline-secondary" id="btnUpdateLine" onclick="btnUpdateLineOnclick(this)">Update line</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-sale" role="tabpanel" tabindex="0">
                                            <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <label for="quotationServiceCost" class="form-label">Service & Transportation Price</label>
                                                        <input type="text" id="quotationServiceCost" class="form-control form-control-sm" maxlength="50">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <div class="table-responsive" id="quotationSaleTableContainer">
                                                            <table id="quotationSaleTable" class="table table-sm table-hover table-bordered caption-top">
                                                                <caption>List of Sale items</caption>
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th class="d-none">idLine</th>
                                                                        <th>Item Code</th>
                                                                        <th>Item Name</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-end">Price</th>
                                                                        <th class="text-end">Sub Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td class="text-end d-none"></td>
                                                                        <td colspan="4" class="text-end"> <b>Grand Total</b></td>
                                                                        <td class="text-end"><strong id="strongGrandTotalSale">0</strong></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Item Code</span>
                                                            <input type="text" id="quotationItemCodeSale" class="form-control quotationInputItem" placeholder="Item Code" disabled>
                                                            <button class="btn btn-primary" type="button" onclick="btnShowItemModal('2')"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Item Name</span>
                                                            <input type="text" id="quotationItemNameSale" class="form-control quotationInputItem" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Qty</span>
                                                            <input type="text" id="quotationQtySale" class="form-control quotationInputItem">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Price</span>
                                                            <input type="text" id="quotationPriceSale" class="form-control quotationInputItem">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-center">
                                                        <div class="btn-group btn-group-sm">
                                                            <button type="button" class="btn btn-outline-secondary" id="btnSaveLineSale" onclick="btnSaveLineSaleOnclick(this)">Save line</button>
                                                            <button type="button" class="btn btn-outline-secondary" id="btnRemoveLineSale" onclick="btnRemoveLineSaleOnclick(this)">Remove line</button>
                                                            <button type="button" class="btn btn-outline-secondary" id="btnUpdateLineSale" onclick="btnUpdateLineSaleOnclick(this)">Update line</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <div class="input-group mb-1">
                                        <input type="text" id="quotationCondition" class="form-control" onkeypress="quotationConditionOnKeyPress(event)" maxlength="450">
                                        <button class="btn btn-primary" type="button" id="btnAddCondition" onclick="addCondition()"><i class="fas fa-plus"></i></button>
                                        <button class="btn btn-primary" type="button" id="btnModalCondition" onclick="btnShowConditionModal()" title="pick from template"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <h3 class="text-body-secondary">Condition List :</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <ul class="list-group list-group-flush list-group-numbered" id="quotationConditionContainer">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col mt-1 mb-1">

            </div>
        </div>
        <input type="hidden" id="quotationInputMode" value="0">
    </div>

</form>
<!-- Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Quotation List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="quotationSearchBy" class="form-select" onchange="quotationSearch.focus()">
                                    <option value="0">Quotation Code</option>
                                    <option value="1">Customer</option>
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
                                            <th>Customer</th>
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
<!-- Customer Modal -->
<div class="modal fade" id="customerModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Customer List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="customerSearchBy" class="form-select" onchange="customerSearch.focus()">
                                    <option value="0">Customer Code</option>
                                    <option value="1">Customer Name</option>
                                    <option value="2">Address</option>
                                </select>
                                <input type="text" id="customerSearch" class="form-control" maxlength="50" onkeypress="customerSearchOnKeypress(event)">
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
<!-- Item Modal -->
<div class="modal fade" id="itemModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Item List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Search by</span>
                                <select id="itemSearchBy" class="form-select" onchange="itemSearch.focus()">
                                    <option value="1">Item Name</option>
                                    <option value="0">Item Code</option>
                                    <option value="2">Specification</option>
                                </select>
                                <input type="text" id="itemSearch" class="form-control" placeholder="Item Search" aria-label="Item Search" maxlength="50" onkeypress="itemSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="itemTabelContainer">
                                <table id="itemTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Item Type</th>
                                            <th>UM</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Specification</th>
                                            <th>Category</th>
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
<!-- Condition Modal -->
<div class="modal fade" id="conditionModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Conditions List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="conditionTabelContainer">
                                <table id="conditionTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>...</th>
                                            <th>Condition</th>
                                            <th>Order</th>
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
            <div class="modal-footer">
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <button class="btn btn-primary btn-sm" onclick="addSelectedConditionsToList()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#quotationIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })

    function quotationConditionOnKeyPress(e) {
        if (e.key === 'Enter') {
            addCondition()
        }
    }

    var grandTotal = 0
    var QuotationType = '2'

    function addCondition() {
        if (quotationCode.value.trim().length === 0) {
            const condition = quotationCondition.value.trim()
            if (condition.length > 2) {
                addConditionImplementation(condition)
            }
        } else {
            if (confirm('Are you sure ?.')) {
                const data = {
                    TQUOCOND_QUOCD: quotationCode.value,
                    TQUOCOND_CONDI: quotationCondition.value,
                    _token: '{{ csrf_token() }}',
                }
                quotationCondition.disabled = true
                btnAddCondition.disabled = true
                $.ajax({
                    type: "POST",
                    url: "quotation-condition",
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        quotationCondition.disabled = false
                        btnAddCondition.disabled = false
                        loadQuotationDetail({
                            doc: quotationCode.value
                        })
                    },
                    error: function(xhr, xopt, xthrow) {
                        quotationCondition.disabled = false
                        btnAddCondition.disabled = false
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

    function btnShowQuotationCustomerModal() {
        const myModal = new bootstrap.Modal(document.getElementById('customerModal'), {})
        customerModal.addEventListener('shown.bs.modal', () => {
            customerSearch.focus()
        })
        myModal.show()
    }

    function customerSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: customerSearchBy.value,
                searchValue: e.target.value,
            }
            customerTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="6">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "customer",
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
                        newcell.innerHTML = arrayItem['MCUS_CUSCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#customerModal').modal('hide')
                            quotationCustomerCode.value = arrayItem['MCUS_CUSCD']
                            quotationCustomer.value = arrayItem['MCUS_CUSNM']
                            quotationAttn.value = arrayItem['MCUS_PIC_NAME']
                            quotationAttn.focus()
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MCUS_CURCD']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['MCUS_TAXREG']
                        newcell = newrow.insertCell(4)
                        newcell.innerHTML = arrayItem['MCUS_ADDR1']
                        newcell = newrow.insertCell(5)
                        newcell.innerHTML = arrayItem['MCUS_TELNO']
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

    function btnShowItemModal(paramString) {
        QuotationType = paramString
        const myModal = new bootstrap.Modal(document.getElementById('itemModal'), {})
        itemModal.addEventListener('shown.bs.modal', () => {
            itemSearch.focus()
        })
        myModal.show()
    }

    function itemSearchOnKeypress(e) {
        if (e.key === 'Enter') {
            e.target.disabled = true
            const data = {
                searchBy: itemSearchBy.value,
                searchValue: e.target.value,
            }
            itemTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="8">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "item",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    let myContainer = document.getElementById("itemTabelContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = itemTabel.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("itemTabel");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    response.data.forEach((arrayItem) => {
                        newrow = myTableBody.insertRow(-1)
                        newcell = newrow.insertCell(0)
                        newcell.innerHTML = arrayItem['MITM_ITMCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#itemModal').modal('hide')
                            if (QuotationType === '1') {
                                quotationItemCode.value = arrayItem['MITM_ITMCD']
                                quotationItemName.value = arrayItem['MITM_ITMNM']
                            } else {
                                quotationItemCodeSale.value = arrayItem['MITM_ITMCD']
                                quotationItemNameSale.value = arrayItem['MITM_ITMNM']
                            }
                        }
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
                    alertify.warning(xthrow);
                    e.target.disabled = false
                }
            });
        }
    }

    function btnSaveLineOnclick(pthis) {
        if (quotationItemCode.value.length === 0) {
            quotationItemCode.focus()
            alertify.warning(`Item Code is required`)
            return
        }
        if (quotationCode.value.trim().length > 0) {
            const data = {
                TQUODETA_QUOCD: quotationCode.value,
                TQUODETA_ITMCD: quotationItemCode.value,
                TQUODETA_ITMQT: 1,
                TQUODETA_USAGE: 1,
                TQUODETA_USAGE_DESCRIPTION: quotationUsage.value,
                TQUODETA_PRC: numeral(quotationPrice.value).value(),
                TQUODETA_ELECTRICITY: quotationElectricity.value,
                TQUO_TYPE: '2',
                _token: '{{ csrf_token() }}',
            }
            pthis.disabled = true
            pthis.innerHTML = `Please wait`
            $.ajax({
                type: "POST",
                url: `quotation/items/${btoa(quotationCode.value)}`,
                data: data,
                dataType: "json",
                success: function(response) {
                    pthis.innerHTML = `Save line`
                    pthis.disabled = false
                    alertify.success(response.msg)
                    loadQuotationDetail({
                        doc: quotationCode.value
                    })
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    pthis.disabled = false
                    pthis.innerHTML = `Save line`

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
        } else {
            const quotationTableBody = quotationTable.getElementsByTagName('tbody')[0]
            const subTotal = numeral(quotationPrice.value).value()
            newrow = quotationTableBody.insertRow(-1)
            newrow.title = 'not selected'
            newrow.onclick = (event) => {
                const selrow = quotationTable.rows[event.target.parentElement.rowIndex]
                if (selrow.title === 'selected') {
                    selrow.title = 'not selected'
                    selrow.classList.remove('table-info')
                    quotationItemCode.value = ''
                    quotationItemName.value = ''
                    quotationUsage.value = ''
                    quotationPrice.value = ''
                    quotationElectricity.value = ''
                } else {
                    const ttlrows = quotationTable.rows.length
                    for (let i = 1; i < ttlrows; i++) {
                        quotationTable.rows[i].classList.remove('table-info')
                        quotationTable.rows[i].title = 'not selected'
                    }
                    selrow.title = 'selected'
                    selrow.classList.add('table-info')
                    quotationItemCode.value = selrow.cells[1].innerText
                    quotationItemName.value = selrow.cells[2].innerText
                    quotationUsage.value = selrow.cells[3].innerText
                    quotationPrice.value = selrow.cells[4].innerText
                    quotationElectricity.value = selrow.cells[5].innerText
                }
            }
            newcell = newrow.insertCell(0)
            newcell.classList.add('d-none')

            newcell = newrow.insertCell(1)
            newcell.innerHTML = quotationItemCode.value

            newcell = newrow.insertCell(2)
            newcell.innerHTML = quotationItemName.value

            newcell = newrow.insertCell(3)
            newcell.innerHTML = quotationUsage.value
            newcell.classList.add('text-center')

            newcell = newrow.insertCell(4)
            newcell.innerHTML = numeral(quotationPrice.value).format(',')
            newcell.classList.add('text-end')

            newcell = newrow.insertCell(-1)
            newcell.innerHTML = quotationElectricity.value
            newcell.classList.add('text-center')

            newcell = newrow.insertCell(-1)
            newcell.innerHTML = numeral(subTotal).format(',')
            newcell.classList.add('text-end')

            grandTotal += subTotal
            strongGrandTotal.innerText = numeral(grandTotal).format(',')
            tribinClearTextBoxByClassName('quotationInputItem')

        }
    }

    function btnSaveLineSaleOnclick(pthis) {
        if (quotationItemCodeSale.value.length === 0) {
            quotationItemCodeSale.focus()
            alertify.warning(`Item Code is required`)
            return
        }
        if (quotationCode.value.trim().length > 0) {
            const data = {
                TQUODETA_QUOCD: quotationCode.value,
                TQUODETA_ITMCD: quotationItemCodeSale.value,
                TQUODETA_ITMQT: quotationQtySale.value,
                TQUODETA_USAGE: 1,
                TQUODETA_PRC: numeral(quotationPriceSale.value).value(),
                TQUO_TYPE: '2',
                _token: '{{ csrf_token() }}',
            }
            pthis.disabled = true
            pthis.innerHTML = `Please wait`
            $.ajax({
                type: "POST",
                url: `quotation/items/${btoa(quotationCode.value)}`,
                data: data,
                dataType: "json",
                success: function(response) {
                    pthis.innerHTML = `Save line`
                    pthis.disabled = false
                    alertify.success(response.msg)
                    loadQuotationDetail({
                        doc: quotationCode.value
                    })
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    pthis.disabled = false
                    pthis.innerHTML = `Save line`

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
        } else {
            const quotationTableBody = quotationSaleTable.getElementsByTagName('tbody')[0]
            const subTotal = numeral(quotationPriceSale.value).value() *
                numeral(quotationQtySale.value).value()
            newrow = quotationTableBody.insertRow(-1)
            newrow.title = 'not selected'
            newrow.onclick = (event) => {
                const selrow = quotationSaleTable.rows[event.target.parentElement.rowIndex]
                if (selrow.title === 'selected') {
                    selrow.title = 'not selected'
                    selrow.classList.remove('table-info')
                    quotationItemCodeSale.value = ''
                    quotationItemNameSale.value = ''
                    quotationQtySale.value = ''
                    quotationPriceSale.value = ''
                } else {
                    const ttlrows = quotationSaleTable.rows.length
                    for (let i = 1; i < ttlrows; i++) {
                        quotationSaleTable.rows[i].classList.remove('table-info')
                        quotationSaleTable.rows[i].title = 'not selected'
                    }
                    selrow.title = 'selected'
                    selrow.classList.add('table-info')
                    quotationItemCodeSale.value = selrow[1].innerText
                    quotationItemNameSale.value = selrow[2].innerText
                    quotationQtySale.value = selrow[3].innerText
                    quotationPriceSale.value = selrow[4].innerText
                }
            }
            newcell = newrow.insertCell(0)
            newcell.classList.add('d-none')

            newcell = newrow.insertCell(1)
            newcell.innerHTML = quotationItemCodeSale.value

            newcell = newrow.insertCell(2)
            newcell.innerHTML = quotationItemNameSale.value

            newcell = newrow.insertCell(3)
            newcell.innerHTML = quotationQtySale.value
            newcell.classList.add('text-center')

            newcell = newrow.insertCell(4)
            newcell.innerHTML = numeral(quotationPriceSale.value).format(',')
            newcell.classList.add('text-end')

            newcell = newrow.insertCell(5)
            newcell.innerHTML = numeral(subTotal).format(',')
            newcell.classList.add('text-end')

            grandTotal += subTotal
            strongGrandTotalSale.innerText = numeral(grandTotal).format(',')
            tribinClearTextBoxByClassName('quotationInputItem')
        }
    }

    function btnNewOnclick() {
        tribinClearTextBox()
        quotationTable.getElementsByTagName('tbody')[0].innerHTML = ``
        quotationSaleTable.getElementsByTagName('tbody')[0].innerHTML = ``
        quotationConditionContainer.innerHTML = ``
        grandTotal = 0
    }

    function btnRemoveLineOnclick(pthis) {
        const ttlrows = quotationTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (quotationTable.rows[i].title === 'selected') {
                idItem = quotationTable.rows[i].cells[0].innerText.trim()
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
                        url: `quotation/items/${idItem}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Remove line`
                            pthis.disabled = false
                            grandTotal -= numeral(quotationTable.rows[iFounded].cells[6].innerText).value()
                            strongGrandTotal.innerText = numeral(grandTotal).format(',')
                            quotationTable.rows[iFounded].remove()
                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Remove line`
                        }
                    });
                } else {
                    grandTotal -= numeral(quotationTable.rows[iFounded].cells[6].innerText).value()
                    strongGrandTotal.innerText = numeral(grandTotal).format(',')
                    quotationTable.rows[iFounded].remove()
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function btnUpdateLineOnclick(pthis) {
        const ttlrows = quotationTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (quotationTable.rows[i].title === 'selected') {
                idItem = quotationTable.rows[i].cells[0].innerText.trim()
                iFounded = i
                break
            }
        }

        if (iFounded > 0) {
            if (confirm(`Are you sure want to update ?`)) {
                if (idItem.length >= 1) {
                    if (quotationCode.value.length === 0) {
                        alertify.warning(`quotation code is required`)
                        return
                    }
                    pthis.disabled = true
                    pthis.innerHTML = `Please wait`
                    const data = {
                        _token: '{{ csrf_token() }}',
                        TQUODETA_ITMCD: quotationItemCode.value,
                        TQUODETA_ITMQT: 1,
                        TQUODETA_USAGE_DESCRIPTION: quotationUsage.value,
                        TQUODETA_PRC: quotationPrice.value,
                        TQUODETA_ELECTRICITY: quotationElectricity.value,
                        TQUO_QUOCD: quotationCode.value,
                    }
                    $.ajax({
                        type: "PUT",
                        url: `quotation/items/${idItem}`,
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
                } else {
                    refreshTableRent(iFounded)
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function refreshTableRent(selectedRow) {
        const subTotal = numeral(quotationPrice.value).value()
        quotationTable.rows[selectedRow].cells[1].innerText = quotationItemCode.value
        quotationTable.rows[selectedRow].cells[2].innerText = quotationItemName.value
        quotationTable.rows[selectedRow].cells[3].innerText = quotationUsage.value
        quotationTable.rows[selectedRow].cells[4].innerText = quotationPrice.value
        quotationTable.rows[selectedRow].cells[5].innerText = quotationElectricity.value
        quotationTable.rows[selectedRow].cells[6].innerText = subTotal
        recalculateGrandTotalRent()
    }

    function refreshTableSale(selectedRow) {
        const subTotal = numeral(quotationQtySale.value).value() *
            numeral(quotationPriceSale.value).value()
        quotationSaleTable.rows[selectedRow].cells[1].innerText = quotationItemCodeSale.value
        quotationSaleTable.rows[selectedRow].cells[2].innerText = quotationItemNameSale.value
        quotationSaleTable.rows[selectedRow].cells[3].innerText = quotationQtySale.value
        quotationSaleTable.rows[selectedRow].cells[4].innerText = quotationPriceSale.value
        quotationSaleTable.rows[selectedRow].cells[5].innerText = numeral(subTotal).value()
        recalculateGrandTotalSale()
    }

    function recalculateGrandTotalRent() {
        const ttlrows = quotationTable.rows.length - 1
        let grandTotal = 0
        for (let i = 1; i < ttlrows; i++) {
            let subTotal = numeral(quotationTable.rows[i].cells[6].innerText.trim()).value()
            grandTotal += subTotal
        }
        strongGrandTotal.innerText = numeral(grandTotal).format(',')
    }

    function recalculateGrandTotalSale() {
        const ttlrows = quotationSaleTable.rows.length - 1
        let grandTotal = 0
        for (let i = 1; i < ttlrows; i++) {
            let subTotal = numeral(quotationSaleTable.rows[i].cells[5].innerText.trim()).value()
            grandTotal += subTotal
        }
        strongGrandTotalSale.innerText = numeral(grandTotal).format(',')
    }

    function btnRemoveLineSaleOnclick(pthis) {
        const ttlrows = quotationSaleTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (quotationSaleTable.rows[i].title === 'selected') {
                idItem = quotationSaleTable.rows[i].cells[0].innerText.trim()
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
                        url: `quotation/items/${idItem}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Remove line`
                            pthis.disabled = false
                            grandTotal -= numeral(quotationSaleTable.rows[iFounded].cells[5].innerText).value()
                            strongGrandTotal.innerText = numeral(grandTotal).format(',')
                            quotationSaleTable.rows[iFounded].remove()
                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Remove line`
                        }
                    });
                } else {
                    grandTotal -= numeral(quotationSaleTable.rows[iFounded].cells[5].innerText).value()
                    strongGrandTotal.innerText = numeral(grandTotal).format(',')
                    quotationSaleTable.rows[iFounded].remove()
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function btnSaveOnclick(pthis) {
        let itemCode = []
        let itemQty = []
        let itemUsage = []
        let itemPrice = []
        let itemElectricity = []

        let quotationCondition = []
        const NavRental = document.getElementById('nav-rental')
        let FinalQuotationType = '1'
        let ttlrows = 0
        if (NavRental.classList.contains('active')) {
            FinalQuotationType = '1'
            ttlrows = quotationTable.rows.length - 1
            for (let i = 1; i < ttlrows; i++) {
                itemCode.push(quotationTable.rows[i].cells[1].innerText.trim())
                itemUsage.push(quotationTable.rows[i].cells[3].innerText.trim())
                itemQty.push(1)
                itemPrice.push(numeral(quotationTable.rows[i].cells[4].innerText.trim()).value())
                itemElectricity.push(quotationTable.rows[i].cells[5].innerText.trim())
            }
        } else {
            FinalQuotationType = '2'
            ttlrows = quotationSaleTable.rows.length - 1
            for (let i = 1; i < ttlrows; i++) {
                itemCode.push(quotationSaleTable.rows[i].cells[1].innerText.trim())
                itemUsage.push(1)
                itemQty.push(numeral(quotationSaleTable.rows[i].cells[3].innerText.trim()).value())
                itemPrice.push(numeral(quotationSaleTable.rows[i].cells[4].innerText.trim()).value())
                itemElectricity.push(null)
            }
        }

        if (ttlrows === 1) {
            alertify.message('nothing to be saved')
            return
        }
        if (quotationIssueDate.value.length === 0) {
            alertify.message('issue date is required')
            quotationIssueDate.focus()
            return
        }
        if (quotationSubject.value.length === 0) {
            alertify.message('Subject is required')
            quotationSubject.focus()
            return
        }
        if (quotationCode.value.length === 0) {
            let conditionList = quotationConditionContainer.getElementsByTagName('li')
            for (let i = 0; i < conditionList.length; i++) {
                quotationCondition.push(conditionList[i].innerText)
            }
            const data = {
                TQUO_CUSCD: quotationCustomerCode.value.trim(),
                TQUO_ATTN: quotationAttn.value.trim(),
                TQUO_SBJCT: quotationSubject.value.trim(),
                TQUO_ISSUDT: quotationIssueDate.value.trim(),
                TQUO_PROJECT_LOCATION: quotationProjectLocation.value.trim(),
                TQUO_TYPE: FinalQuotationType,
                TQUO_SERVTRANS_COST: quotationServiceCost.value,
                TQUODETA_ITMCD: itemCode,
                TQUODETA_ITMQT: itemQty,
                TQUODETA_USAGE_DESCRIPTION: itemUsage,
                TQUODETA_PRC: itemPrice,
                TQUODETA_ELECTRICITY: itemElectricity,
                TQUOCOND_CONDI: quotationCondition,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "quotation",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        pthis.innerHTML = `<i class="fas fa-save"></i>`
                        alertify.success(response.msg)
                        quotationCode.value = response.doc
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
                TQUO_CUSCD: quotationCustomerCode.value.trim(),
                TQUO_ATTN: quotationAttn.value.trim(),
                TQUO_SBJCT: quotationSubject.value.trim(),
                TQUO_ISSUDT: quotationIssueDate.value.trim(),
                TQUO_PROJECT_LOCATION: quotationProjectLocation.value.trim(),
                TQUO_SERVTRANS_COST: quotationServiceCost.value,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `quotation/${btoa(quotationCode.value)}`,
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
            }
            quotationSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: "quotation",
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
                        newcell.innerHTML = arrayItem['TQUO_QUOCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#quotationModal').modal('hide')
                            quotationCode.value = arrayItem['TQUO_QUOCD']
                            quotationIssueDate.value = arrayItem['TQUO_ISSUDT']
                            quotationSubject.value = arrayItem['TQUO_SBJCT']
                            quotationCustomer.value = arrayItem['MCUS_CUSNM']
                            quotationCustomerCode.value = arrayItem['TQUO_CUSCD']
                            quotationAttn.value = arrayItem['TQUO_ATTN']
                            quotationProjectLocation.value = arrayItem['TQUO_PROJECT_LOCATION']
                            loadQuotationDetail({
                                doc: arrayItem['TQUO_QUOCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TQUO_ISSUDT']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['TQUO_SBJCT']
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
            url: `quotation/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                if (response.dataHeader[0].TQUO_TYPE === '1') {
                    let myContainer = document.getElementById("quotationTableContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = quotationTable.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("quotationTable");
                    let myStrong = myfrag.getElementById("strongGrandTotal");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    grandTotal = 0
                    response.dataItem.forEach((arrayItem) => {
                        const subTotal = numeral(arrayItem['TQUODETA_PRC']).value()
                        newrow = myTableBody.insertRow(-1)
                        newrow.onclick = (event) => {
                            const selrow = quotationTable.rows[event.target.parentElement.rowIndex]
                            if (selrow.title === 'selected') {
                                selrow.title = 'not selected'
                                selrow.classList.remove('table-info')
                                quotationItemCode.value = ''
                                quotationItemName.value = ''
                                quotationUsage.value = ''
                                quotationPrice.value = ''
                                quotationElectricity.value = ''
                            } else {
                                const ttlrows = quotationTable.rows.length
                                for (let i = 1; i < ttlrows; i++) {
                                    quotationTable.rows[i].classList.remove('table-info')
                                    quotationTable.rows[i].title = 'not selected'
                                }
                                selrow.title = 'selected'
                                selrow.classList.add('table-info')
                                quotationItemCode.value = arrayItem['TQUODETA_ITMCD']
                                quotationItemName.value = arrayItem['MITM_ITMNM']
                                quotationUsage.value = arrayItem['TQUODETA_USAGE_DESCRIPTION']
                                quotationPrice.value = arrayItem['TQUODETA_PRC']
                                quotationElectricity.value = arrayItem['TQUODETA_ELECTRICITY']
                            }
                        }
                        newcell = newrow.insertCell(0)
                        newcell.classList.add('d-none')
                        newcell.innerHTML = arrayItem['id']
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['TQUODETA_ITMCD']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MITM_ITMNM']
                        newcell = newrow.insertCell(3)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TQUODETA_USAGE_DESCRIPTION']
                        newcell = newrow.insertCell(4)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_PRC']).format(',')
                        newcell = newrow.insertCell(-1)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TQUODETA_ELECTRICITY']
                        newcell = newrow.insertCell(-1)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(subTotal).format(',')

                        grandTotal += subTotal
                    })
                    myStrong.innerText = numeral(grandTotal).format(',')
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                    let firstTabEl = document.querySelector('#quotation-type-nav-tab button[data-bs-target="#nav-rental"]')
                    let thetab = new bootstrap.Tab(firstTabEl)
                    thetab.show()

                    quotationSaleTable.getElementsByTagName('tbody')[0].innerHTML = ''
                } else {
                    let myContainer = document.getElementById("quotationSaleTableContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = quotationSaleTable.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("quotationSaleTable");
                    let myStrong = myfrag.getElementById("strongGrandTotalSale");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    grandTotal = 0
                    response.dataItem.forEach((arrayItem) => {
                        const subTotal = numeral(arrayItem['TQUODETA_PRC']).value() * arrayItem['TQUODETA_ITMQT']
                        newrow = myTableBody.insertRow(-1)
                        newrow.onclick = (event) => {
                            const selrow = quotationSaleTable.rows[event.target.parentElement.rowIndex]
                            if (selrow.title === 'selected') {
                                selrow.title = 'not selected'
                                selrow.classList.remove('table-info')
                                quotationItemCodeSale.value = ''
                                quotationItemNameSale.value = ''
                                quotationQtySale.value = ''
                                quotationPriceSale.value = ''
                            } else {
                                const ttlrows = quotationSaleTable.rows.length
                                for (let i = 1; i < ttlrows; i++) {
                                    quotationSaleTable.rows[i].classList.remove('table-info')
                                    quotationSaleTable.rows[i].title = 'not selected'
                                }
                                selrow.title = 'selected'
                                selrow.classList.add('table-info')
                                quotationItemCodeSale.value = arrayItem['TQUODETA_ITMCD']
                                quotationItemNameSale.value = arrayItem['MITM_ITMNM']
                                quotationQtySale.value = arrayItem['TQUODETA_ITMQT']
                                quotationPriceSale.value = arrayItem['TQUODETA_PRC']
                            }
                        }
                        newcell = newrow.insertCell(0)
                        newcell.classList.add('d-none')
                        newcell.innerHTML = arrayItem['id']
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['TQUODETA_ITMCD']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MITM_ITMNM']
                        newcell = newrow.insertCell(3)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TQUODETA_ITMQT']
                        newcell = newrow.insertCell(4)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_PRC']).format(',')
                        newcell = newrow.insertCell(5)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(subTotal).format(',')
                        grandTotal += subTotal
                    })
                    myStrong.innerText = numeral(grandTotal).format(',')
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                    let firstTabEl = document.querySelector('#quotation-type-nav-tab button[data-bs-target="#nav-sale"]')
                    let thetab = new bootstrap.Tab(firstTabEl)
                    thetab.show()
                    quotationTable.getElementsByTagName('tbody')[0].innerHTML = ''
                }
                quotationConditionContainer.innerHTML = ''
                response.dataCondition.forEach((arrayItem) => {
                    const liElement = document.createElement('li')
                    liElement.title = arrayItem['id']
                    liElement.classList.add(...['list-group-item', 'd-flex', 'justify-content-between', 'align-items-start'])
                    const childLiElement = document.createElement('div')
                    childLiElement.classList.add(...['ms-2', 'me-auto'])
                    childLiElement.innerHTML = arrayItem['TQUOCOND_CONDI']
                    const childLiElement2 = document.createElement('span')
                    childLiElement2.classList.add(...['badge', 'bg-warning', 'rounded-pill'])
                    childLiElement2.innerHTML = `<i class="fas fa-trash"></i>`
                    childLiElement2.style.cssText = 'cursor:pointer'
                    childLiElement2.onclick = () => {
                        if (confirm(`Are you sure ?`)) {
                            $.ajax({
                                type: "DELETE",
                                url: `quotation/conditions/${liElement.title}`,
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: "json",
                                success: function(response) {
                                    liElement.remove()
                                    alertify.message(response.msg)
                                },
                                error: function(xhr, xopt, xthrow) {
                                    alertify.warning(xthrow);
                                }
                            });
                        }
                    }
                    liElement.appendChild(childLiElement)
                    liElement.appendChild(childLiElement2)
                    quotationConditionContainer.appendChild(liElement)
                    quotationCondition.value = ``
                })
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function btnPrintOnclick() {
        if (quotationCode.value.trim().length === 0) {
            alertify.message('Quotation Code is required')
            return
        }
        window.open(`PDF/quotation/${btoa(quotationCode.value)}`, '_blank');
    }

    function btnShowConditionModal() {
        const myModal = new bootstrap.Modal(document.getElementById('conditionModal'), {})
        myModal.show()
    }

    function loadAllCondition() {
        $.ajax({
            type: "GET",
            url: "condition",
            dataType: "json",
            success: function(response) {
                let myContainer = document.getElementById("conditionTabelContainer");
                let myfrag = document.createDocumentFragment();
                let cln = conditionTabel.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("conditionTabel");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                grandTotal = 0
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newcell = newrow.insertCell(0)
                    const checkBox = document.createElement('input')
                    checkBox.classList.add('form-check-input')
                    checkBox.type = "checkbox"
                    newcell.appendChild(checkBox)
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['MCONDITION_DESCRIPTION']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['MCONDITION_ORDER_NUMBER']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    loadAllCondition()

    function addSelectedConditionsToList() {
        const ttlrows = conditionTabel.rows.length - 1
        let isSelectedRowsFound = false
        let conditions = []
        for (let i = 1; i <= ttlrows; i++) {
            const _elCheckBox = conditionTabel.rows[i].cells[0].getElementsByTagName('input')[0]
            if (_elCheckBox.checked) {
                isSelectedRowsFound = true
                conditions.push(conditionTabel.rows[i].cells[1].innerText)
                addConditionImplementation(conditionTabel.rows[i].cells[1].innerText)
            }
        }
        if (!isSelectedRowsFound) {
            alertify.message('nothing selected')
        } else {
            $("#conditionModal").modal('hide')
            if (quotationCode.value.trim().length != 0) {
                let functionListPhysic_adj = []
                conditions.forEach((dataCondition) => {
                    functionListPhysic_adj.push($.ajax({
                        type: "POST",
                        url: "quotation-condition",
                        data: {
                            TQUOCOND_QUOCD: quotationCode.value,
                            TQUOCOND_CONDI: dataCondition,
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: "JSON",
                        success: function(response) {

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
                            alertify.warning(xthrow);
                        }
                    }))
                })
                $.when.apply($, functionListPhysic_adj).then(function() {
                    loadQuotationDetail({
                        doc: quotationCode.value
                    })
                })
            }
        }
    }

    function addConditionImplementation(data) {
        const liElement = document.createElement('li')
        liElement.title = "go ahead"
        liElement.classList.add(...['list-group-item', 'd-flex', 'justify-content-between', 'align-items-start'])
        const childLiElement = document.createElement('div')
        childLiElement.classList.add(...['ms-2', 'me-auto'])
        childLiElement.innerHTML = data
        const childLiElement2 = document.createElement('span')
        childLiElement2.classList.add(...['badge', 'bg-warning', 'rounded-pill'])
        childLiElement2.innerHTML = `<i class="fas fa-trash"></i>`
        childLiElement2.style.cssText = 'cursor:pointer'
        childLiElement2.onclick = () => {
            if (confirm(`Are you sure ?`)) {
                liElement.remove()
            }
        }
        liElement.appendChild(childLiElement)
        liElement.appendChild(childLiElement2)
        quotationConditionContainer.appendChild(liElement)
        quotationCondition.value = ``
    }

    function btnUpdateLineSaleOnclick(pthis) {
        const ttlrows = quotationSaleTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (quotationSaleTable.rows[i].title === 'selected') {
                idItem = quotationSaleTable.rows[i].cells[0].innerText.trim()
                iFounded = i
                break
            }
        }

        if (iFounded > 0) {
            if (confirm(`Are you sure want to update ?`)) {
                if (idItem.length >= 1) {
                    if (quotationCode.value.length === 0) {
                        alertify.warning(`quotation code is required`)
                        return
                    }
                    pthis.disabled = true
                    pthis.innerHTML = `Please wait`
                    const data = {
                        _token: '{{ csrf_token() }}',
                        TQUODETA_ITMCD: quotationItemCodeSale.value,
                        TQUODETA_ITMQT: quotationQtySale.value,
                        TQUODETA_USAGE_DESCRIPTION: 1,
                        TQUODETA_PRC: quotationPriceSale.value,
                        TQUO_QUOCD: quotationCode.value,
                    }
                    $.ajax({
                        type: "PUT",
                        url: `quotation/items/${idItem}`,
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Update line`
                            pthis.disabled = false
                            if (response.msg === 'OK') {
                                refreshTableSale(iFounded)
                            }
                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Update line`
                        }
                    });
                } else {
                    refreshTableSale(iFounded)
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }
</script>