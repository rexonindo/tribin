<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Receive Order</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
            <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
        </div>
    </div>
</div>
<form id="order-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Item</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-users-rectangle"></i> Customer</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-4 mb-1">
                                    <label for="orderCode" class="form-label">Code</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderCode" class="form-control" placeholder="RO..." maxlength="17" disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowReceiveModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label for="orderIssueDate" class="form-label">Issue Date</label>
                                    <input type="text" id="orderIssueDate" class="form-control" maxlength="10" readonly>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <label for="orderPlanDeliveryDate" class="form-label">Plan Delivery Date</label>
                                    <input type="text" id="orderPlanDeliveryDate" class="form-control" maxlength="10" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="orderQuotation" class="form-label">Quotation/RO Draft</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderQuotation" class="form-control" placeholder="PNW/SOD" disabled>
                                        <button class="btn btn-primary" type="button" onclick="btnShowQuotationModal()"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="orderPONumber" class="form-label">PO Number</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderPONumber" class="form-control" placeholder="" maxlength="50">
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top">
                                <div class="col-md-12 mb-1 mt-2">
                                    <nav>
                                        <div class="nav nav-tabs" id="quotation-type-nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-rental-tab" data-bs-toggle="tab" data-bs-target="#nav-rental" type="button" role="tab">Rental</button>
                                            <button class="nav-link" id="nav-sale-tab" data-bs-toggle="tab" data-bs-target="#nav-sale" type="button" role="tab">Sale</button>
                                            <button class="nav-link" id="nav-service-tab" data-bs-toggle="tab" data-bs-target="#nav-service" type="button" role="tab">Service</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="quotation-type-nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-rental" role="tabpanel" tabindex="0">
                                            <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <div class="table-responsive" id="orderTableContainer">
                                                            <table id="orderTable" class="table table-sm table-hover table-bordered caption-top">
                                                                <caption>List of items</caption>
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th class="d-none">idLine</th>
                                                                        <th>Item Code</th>
                                                                        <th>Item Name</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">Usage</th>
                                                                        <th class="text-end">Price</th>
                                                                        <th class="text-end">Operator</th>
                                                                        <th class="text-end">MOB DEMOB</th>
                                                                        <th class="text-center">Period From</th>
                                                                        <th class="text-center">Period To</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="orderIssueDate" class="form-label">Period from</label>
                                                        <input type="text" id="orderPeriodFrom" class="form-control form-control-sm" maxlength="10" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="orderIssueDate" class="form-label">Period to</label>
                                                        <input type="text" id="orderPeriodTo" class="form-control form-control-sm" maxlength="10" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Item Code</span>
                                                            <input type="text" id="orderItemCode" class="form-control orderInputItem" placeholder="Item Code" disabled>
                                                            <button class="btn btn-primary" type="button" onclick="btnShowItemModal()"><i class="fas fa-search"></i></button>
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
                                                            <input type="text" id="orderItemQty" class="form-control orderInputItem">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Usage</span>
                                                            <select id="orderUsage" class="form-select">
                                                                @foreach ($usages as $r)
                                                                <option value="{{$r->MUSAGE_ALIAS . ' ' . $r->MUSAGE_DESCRIPTION}}">{{$r->MUSAGE_ALIAS . ' ' . $r->MUSAGE_DESCRIPTION}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Price</span>
                                                            <input type="text" id="orderPrice" class="form-control orderInputItem" title="price per hour">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">Operator Price</span>
                                                            <input type="text" id="orderOperator" class="form-control orderInputItem" title="price per man">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <div class="input-group input-group-sm mb-1">
                                                            <span class="input-group-text">MOBDEMOB</span>
                                                            <input type="text" id="orderMOBDEMOB" class="form-control orderInputItem">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 mb-1 text-center">
                                                        <div class="btn-group btn-group-sm">
                                                            <button type="button" class="btn btn-outline-secondary" id="btnSaveLine" onclick="btnSaveLineOnclick(this)">Save line</button>
                                                            <button type="button" class="btn btn-outline-secondary" id="btnUpdateLine" onclick="btnUpdateLineOnclick(this)">Update line</button>
                                                            <button type="button" class="btn btn-outline-secondary" id="btnRemoveLine" onclick="btnRemoveLineOnclick(this)">Remove line</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-sale" role="tabpanel" tabindex="1">
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
                                                            <button type="button" class="btn btn-outline-secondary" id="btnRemoveLineSale" onclick="btnRemoveLineSaleOnclick(this)">Remove line</button>
                                                            <button type="button" class="btn btn-outline-secondary" id="btnUpdateLineSale" onclick="btnUpdateLineSaleOnclick(this)">Update line</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="nav-service" role="tabpanel" tabindex="2">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col">
                                                        on development
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                        <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label for="orderCustomer" class="form-label">Customer Name</label>
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
                                <div class="col-md-12 mb-1">
                                    <label for="orderCustomer" class="form-label">Destination Name</label>
                                    <div class="input-group mb-1">
                                        <input type="text" id="orderAddressName" class="form-control" maxlength="45">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <label for="orderCustomer" class="form-label">Destination Address</label>
                                    <div class="input-group mb-1">
                                        <textarea id="orderAddress" class="form-control" maxlength="90">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <label for="orderCustomer" class="form-label">Maps</label>
                                    <div class="input-group input-group-sm mb-1">
                                        <textarea id="orderEmbedCodeContainer" class="form-control" maxlength="500">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnPreviewMaps" onclick="btnPreviewMapOnclick(this)">Preview Map</button>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <iframe id="frame1" height="256" frameborder="0" width="100%"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="orderInputMode" value="0">
        <input type="hidden" id="selectedRowAtOrderTable" value="-1">
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
                                    <option value="1">Customer</option>
                                    <option value="2">PO Number</option>
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
                                            <th>Customer</th>
                                            <th>Issue Date</th>
                                            <th>Quotation</th>
                                            <th>PO Number</th>
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
                                    <option value="0">Item Code</option>
                                    <option value="1">Item Name</option>
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
<!-- Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Approved Quotation / RO Draft List</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1">
                            <div class="input-group input-group-sm mb-1">
                                <span class="input-group-text">Source</span>
                                <select id="orderSourceBy" class="form-select" onchange="orderSourceByOnlClick(this)">
                                    <option value="1">Quotation</option>
                                    <option value="2">Sales Order Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
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
                                            <th>Customer PO</th>
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
    orderEmbedCodeContainer.value = ''
    $("#orderIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $("#orderPlanDeliveryDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $("#orderPeriodFrom").datetimepicker({
        format: 'yyyy-mm-dd HH:MM:00',
        autoclose: true,
        uiLibrary: 'bootstrap5',
        footer: true
    })
    $("#orderPeriodTo").datetimepicker({
        format: 'yyyy-mm-dd HH:MM:00',
        autoclose: true,
        uiLibrary: 'bootstrap5',
        footer: true
    })

    function btnShowReceiveCustomerModal() {
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
                            orderCustomerCode.value = arrayItem['MCUS_CUSCD']
                            orderCustomer.value = arrayItem['MCUS_CUSNM']
                            orderAttn.focus()
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

    function btnShowItemModal() {
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
                            orderItemCode.value = arrayItem['MITM_ITMCD']
                            orderItemName.value = arrayItem['MITM_ITMNM']
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

    function btnSaveLineOnclick() {
        if (orderItemCode.value.length === 0) {
            orderItemCode.focus()
            alertify.warning(`Item Code is required`)
            return
        }
        const orderTableBody = orderTable.getElementsByTagName('tbody')[0]
        newrow = orderTableBody.insertRow(-1)
        newrow.title = 'not selected'
        newrow.onclick = (event) => {
            const selrow = orderTable.rows[event.target.parentElement.rowIndex]
            if (selrow.title === 'selected') {
                selrow.title = 'not selected'
                selrow.classList.remove('table-info')
                selectedRowAtOrderTable.value = -1
                orderItemCode.value = ''
                orderItemName.value = ''
                orderItemQty.value = ''
                orderUsage.value = ''
                orderPrice.value = ''
                orderOperator.value = ''
                orderMOBDEMOB.value = ''
                orderPeriodFrom.value = ''
                orderPeriodTo.value = ''
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
                orderItemQty.value = selrow.cells[3].innerText
                orderUsage.value = selrow.cells[4].innerText
                orderPrice.value = selrow.cells[5].innerText
                orderOperator.value = selrow.cells[6].innerText
                orderMOBDEMOB.value = selrow.cells[7].innerText
                orderPeriodFrom.value = selrow.cells[8].innerText
                orderPeriodTo.value = selrow.cells[9].innerText
            }
        }
        newcell = newrow.insertCell(0)
        newcell.classList.add('d-none')

        newcell = newrow.insertCell(1)
        newcell.innerHTML = orderItemCode.value

        newcell = newrow.insertCell(2)
        newcell.innerHTML = orderItemName.value

        newcell = newrow.insertCell(3)
        newcell.innerHTML = orderItemQty.value
        newcell.classList.add('text-center')

        newcell = newrow.insertCell(4)
        newcell.innerHTML = orderUsage.value
        newcell.classList.add('text-center')

        newcell = newrow.insertCell(5)
        newcell.innerHTML = numeral(orderPrice.value).format(',')
        newcell.classList.add('text-end')

        newcell = newrow.insertCell(6)
        newcell.innerHTML = numeral(orderOperator.value).format(',')
        newcell.classList.add('text-end')

        newcell = newrow.insertCell(7)
        newcell.innerHTML = numeral(orderMOBDEMOB.value).format(',')
        newcell.classList.add('text-end')
        newcell = newrow.insertCell(8)
        newcell.innerHTML = orderPeriodFrom.value
        newcell = newrow.insertCell(9)
        newcell.innerHTML = orderPeriodTo.value

        tribinClearTextBoxByClassName('orderInputItem')
    }

    function btnNewOnclick() {
        tribinClearTextBox()
        orderTable.getElementsByTagName('tbody')[0].innerHTML = ``
        orderEmbedCodeContainer.value = ''
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
        let itemUsage = []
        let itemPrice = []
        let itemOperatorPrice = []
        let itemMobDemob = []
        let itemPeriodFrom = []
        let itemPeriodTo = []
        let ttlrows = orderTable.rows.length
        const NavRental = document.getElementById('nav-rental')
        const NavSale = document.getElementById('nav-sale')
        let FinalQuotationType = '1'
        if (NavRental.classList.contains('active')) {
            FinalQuotationType = '1'
            for (let i = 1; i < ttlrows; i++) {
                let price = numeral(orderTable.rows[i].cells[5].innerText.trim()).value()
                let qty = numeral(orderTable.rows[i].cells[3].innerText.trim()).value()
                if (price <= 0) {
                    alertify.warning('Price should not be zero')
                    return
                }
                if (qty <= 0) {
                    alertify.warning('Qty should not be zero')
                    return
                }
                itemCode.push(orderTable.rows[i].cells[1].innerText.trim())
                itemQty.push(orderTable.rows[i].cells[3].innerText.trim())
                itemUsage.push(orderTable.rows[i].cells[4].innerText.trim())
                itemPrice.push(price)
                itemOperatorPrice.push(numeral(orderTable.rows[i].cells[6].innerText.trim()).value())
                itemMobDemob.push(numeral(orderTable.rows[i].cells[7].innerText.trim()).value())
                itemPeriodFrom.push(orderTable.rows[i].cells[8].innerText.trim())
                itemPeriodTo.push(orderTable.rows[i].cells[9].innerText.trim())
            }
        } else if (NavSale.classList.contains('active')) {
            FinalQuotationType = '2'
            ttlrows = quotationSaleTable.rows.length - 1
            for (let i = 1; i < ttlrows; i++) {
                itemCode.push(quotationSaleTable.rows[i].cells[1].innerText.trim())
                itemUsage.push(1)
                itemQty.push(numeral(quotationSaleTable.rows[i].cells[3].innerText.trim()).value())
                itemPrice.push(numeral(quotationSaleTable.rows[i].cells[4].innerText.trim()).value())
                itemOperatorPrice.push(0)
                itemMobDemob.push(0)
                itemPeriodFrom.push(null)
                itemPeriodTo.push(null)
            }
        } else {
            FinalQuotationType = '3'
            ttlrows = 1
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

        if (orderPlanDeliveryDate.value.trim().length <= 1) {
            alertify.message('Plan Delivery date is required')
            orderPlanDeliveryDate.focus()
            return
        }
        if (orderCode.value.length === 0) {
            if (orderPONumber.value.trim().length <= 1) {
                if (!confirm('Leave PO from Customer blank ?')) {
                    orderPONumber.focus()
                    return
                }
            }
            const data = {
                TSLO_CUSCD: orderCustomerCode.value.trim(),
                TSLO_ATTN: orderAttn.value.trim(),
                TSLO_QUOCD: orderQuotation.value.trim(),
                TSLO_POCD: orderPONumber.value.trim(),
                TSLO_ISSUDT: orderIssueDate.value.trim(),
                TSLO_PLAN_DLVDT: orderPlanDeliveryDate.value.trim(),
                TSLO_ADDRESS_NAME: orderAddressName.value.trim(),
                TSLO_ADDRESS_DESCRIPTION: orderAddress.value.trim(),
                TSLO_TYPE: FinalQuotationType,
                TSLO_SERVTRANS_COST: quotationServiceCost.value,
                TSLO_MAP_URL: orderEmbedCodeContainer.value,
                TSLODETA_ITMCD: itemCode,
                TSLODETA_ITMQT: itemQty,
                TSLODETA_USAGE_DESCRIPTION: itemUsage,
                TSLODETA_PRC: itemPrice,
                TSLODETA_OPRPRC: itemOperatorPrice,
                TSLODETA_MOBDEMOB: itemMobDemob,
                TSLODETA_PERIOD_FR: itemPeriodFrom,
                TSLODETA_PERIOD_TO: itemPeriodTo,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to save ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "POST",
                    url: "receive-order",
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
                        orderPONumber.value = response.newPOCode
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
                TSLO_CUSCD: orderCustomerCode.value.trim(),
                TSLO_ATTN: orderAttn.value.trim(),
                TSLO_POCD: orderPONumber.value.trim(),
                TSLO_ISSUDT: orderIssueDate.value.trim(),
                TSLO_PLAN_DLVDT: orderPlanDeliveryDate.value.trim(),
                TSLO_ADDRESS_NAME: orderAddressName.value.trim(),
                TSLO_ADDRESS_DESCRIPTION: orderAddress.value.trim(),
                TSLO_MAP_URL: orderEmbedCodeContainer.value,
                _token: '{{ csrf_token() }}',
            }
            if (confirm(`Are you sure want to update ?`)) {
                pthis.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`
                pthis.disabled = true
                $.ajax({
                    type: "PUT",
                    url: `receive-order/${btoa(orderCode.value)}`,
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
                url: "receive-order",
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
                        newcell.innerHTML = arrayItem['TSLO_SLOCD']
                        newcell.style.cssText = 'cursor:pointer'
                        newcell.onclick = () => {
                            $('#orderModal').modal('hide')
                            orderCode.value = arrayItem['TSLO_SLOCD']
                            orderIssueDate.value = arrayItem['TSLO_ISSUDT']
                            orderQuotation.value = arrayItem['TSLO_QUOCD']
                            orderPONumber.value = arrayItem['TSLO_POCD']
                            orderCustomer.value = arrayItem['MCUS_CUSNM']
                            orderCustomerCode.value = arrayItem['TSLO_CUSCD']
                            orderAttn.value = arrayItem['TSLO_ATTN']
                            orderPlanDeliveryDate.value = arrayItem['TSLO_PLAN_DLVDT']
                            orderAddressName.value = arrayItem['TSLO_ADDRESS_NAME']
                            orderAddress.value = arrayItem['TSLO_ADDRESS_DESCRIPTION']
                            orderEmbedCodeContainer.value = arrayItem['TSLO_MAP_URL']
                            quotationServiceCost.value = arrayItem['TSLO_SERVTRANS_COST']
                            loadReceiveDetail({
                                doc: arrayItem['TSLO_SLOCD']
                            })
                        }
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MCUS_CUSNM']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['TSLO_ISSUDT']
                        newcell = newrow.insertCell(3)
                        newcell.innerHTML = arrayItem['TSLO_QUOCD']
                        newcell = newrow.insertCell(4)
                        newcell.innerHTML = arrayItem['TSLO_POCD']
                        newcell = newrow.insertCell(5)
                        newcell.innerHTML = arrayItem['TSLO_PLAN_DLVDT']
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
            url: `receive-order/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                if (response.dataHeader[0].TSLO_TYPE === '1') {
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
                                orderItemQty.value = ''
                                orderUsage.value = ''
                                orderPrice.value = ''
                                orderOperator.value = ''
                                orderMOBDEMOB.value = ''
                                orderPeriodFrom.value = ''
                                orderPeriodTo.value = ''
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
                                orderItemQty.value = selrow.cells[3].innerText
                                orderUsage.value = selrow.cells[4].innerText
                                orderPrice.value = selrow.cells[5].innerText
                                orderOperator.value = selrow.cells[6].innerText
                                orderMOBDEMOB.value = selrow.cells[7].innerText
                                orderPeriodFrom.value = selrow.cells[8].innerText
                                orderPeriodTo.value = selrow.cells[9].innerText
                            }
                        }
                        newcell = newrow.insertCell(0)
                        newcell.classList.add('d-none')
                        newcell.innerHTML = arrayItem['id']
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['TSLODETA_ITMCD']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MITM_ITMNM']

                        newcell = newrow.insertCell(3)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TSLODETA_ITMQT']
                        newcell = newrow.insertCell(4)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TSLODETA_USAGE_DESCRIPTION']

                        newcell = newrow.insertCell(5)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TSLODETA_PRC']).format(',')
                        newcell = newrow.insertCell(6)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TSLODETA_OPRPRC']).format(',')
                        newcell = newrow.insertCell(7)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TSLODETA_MOBDEMOB']).format(',')
                        newcell = newrow.insertCell(8)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TSLODETA_PERIOD_FR']
                        newcell = newrow.insertCell(9)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TSLODETA_PERIOD_TO']
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                    let firstTabEl = document.querySelector('#quotation-type-nav-tab button[data-bs-target="#nav-rental"]')
                    let thetab = new bootstrap.Tab(firstTabEl)
                    thetab.show()

                    quotationSaleTable.getElementsByTagName('tbody')[0].innerHTML = ''
                    strongGrandTotalSale.innerText = 0
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
                        const subTotal = numeral(arrayItem['TSLODETA_PRC']).value() * arrayItem['TSLODETA_ITMQT']
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
                                quotationItemCodeSale.value = arrayItem['TSLODETA_ITMCD']
                                quotationItemNameSale.value = arrayItem['MITM_ITMNM']
                                quotationQtySale.value = arrayItem['TSLODETA_ITMQT']
                                quotationPriceSale.value = arrayItem['TSLODETA_PRC']

                            }
                        }
                        newcell = newrow.insertCell(0)
                        newcell.classList.add('d-none')
                        newcell.innerHTML = arrayItem['id']
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['TSLODETA_ITMCD']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MITM_ITMNM']
                        newcell = newrow.insertCell(3)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TSLODETA_ITMQT']
                        newcell = newrow.insertCell(4)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TSLODETA_PRC']).format(',')
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
                    orderTable.getElementsByTagName('tbody')[0].innerHTML = ''
                }
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
            quotationSavedTabel.getElementsByTagName('tbody').innerHTML = ''
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
            quotationSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="5">Please wait</td></tr>`
            $.ajax({
                type: "GET",
                url: orderSourceBy.value == '2' ? "sales-order-draft" : "quotation",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    dataToQuotationTable({
                        type: orderSourceBy.value == '2' ? 'sod' : 'quo',
                        data: response.data
                    })
                },
                error: function(xhr, xopt, xthrow) {
                    alertify.warning(xthrow);
                    e.target.disabled = false
                    quotationSavedTabel.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="5"></td></tr>`
                }
            });
        }
    }

    function dataToQuotationTable(param) {
        let myContainer = document.getElementById("quotationSavedTabelContainer");
        let myfrag = document.createDocumentFragment();
        let cln = quotationSavedTabel.cloneNode(true);
        myfrag.appendChild(cln);
        let myTable = myfrag.getElementById("quotationSavedTabel");
        let myTableBody = myTable.getElementsByTagName("tbody")[0];
        myTableBody.innerHTML = ''
        if (param.type == 'sod') {
            param.data.forEach((arrayItem) => {
                newrow = myTableBody.insertRow(-1)
                newcell = newrow.insertCell(0)
                newcell.innerHTML = arrayItem['TSLODRAFT_SLOCD']
                newcell.style.cssText = 'cursor:pointer'
                newcell.onclick = () => {
                    $('#quotationModal').modal('hide')
                    orderQuotation.value = arrayItem['TSLODRAFT_SLOCD']
                    orderCustomer.value = arrayItem['MCUS_CUSNM']
                    orderCustomerCode.value = arrayItem['TSLODRAFT_CUSCD']
                    orderAttn.value = arrayItem['TSLODRAFT_ATTN']
                    orderPONumber.value = arrayItem['TSLODRAFT_POCD']
                    loadSalesDraftDetail({
                        doc: arrayItem['TSLODRAFT_SLOCD']
                    })
                    orderAddressName.value = arrayItem['MCUS_CUSNM']
                    orderAddress.value = arrayItem['MCUS_ADDR1']
                }
                newcell = newrow.insertCell(1)
                newcell.innerHTML = arrayItem['MCUS_CUSNM']
                newcell = newrow.insertCell(2)
                newcell.innerHTML = arrayItem['TSLODRAFT_ISSUDT']
                newcell = newrow.insertCell(3)
                newcell.innerHTML = ''
                newcell = newrow.insertCell(4)
                newcell.innerHTML = arrayItem['TSLODRAFT_POCD']
            })
        } else {
            param.data.forEach((arrayItem) => {
                newrow = myTableBody.insertRow(-1)
                newcell = newrow.insertCell(0)
                newcell.innerHTML = arrayItem['TQUO_QUOCD']
                newcell.style.cssText = 'cursor:pointer'
                newcell.onclick = () => {
                    $('#quotationModal').modal('hide')
                    orderQuotation.value = arrayItem['TQUO_QUOCD']
                    orderCustomer.value = arrayItem['MCUS_CUSNM']
                    orderCustomerCode.value = arrayItem['TQUO_CUSCD']
                    orderAttn.value = arrayItem['TQUO_ATTN']
                    quotationServiceCost.value = arrayItem['TQUO_SERVTRANS_COST']
                    loadQuotationDetail({
                        doc: arrayItem['TQUO_QUOCD']
                    })
                    orderAddressName.value = arrayItem['MCUS_CUSNM']
                    orderAddress.value = arrayItem['MCUS_ADDR1']
                }
                newcell = newrow.insertCell(1)
                newcell.innerHTML = arrayItem['MCUS_CUSNM']
                newcell = newrow.insertCell(2)
                newcell.innerHTML = arrayItem['TQUO_ISSUDT']
                newcell = newrow.insertCell(3)
                newcell.innerHTML = arrayItem['TQUO_SBJCT']
                newcell = newrow.insertCell(4)
                newcell.innerHTML = ''
            })
        }
        myContainer.innerHTML = ''
        myContainer.appendChild(myfrag)
    }

    function loadQuotationDetail(data) {
        $.ajax({
            type: "GET",
            url: `quotation/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                if (response.dataHeader[0].TQUO_TYPE === '1') {
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
                                orderItemQty.value = ''
                                orderUsage.value = ''
                                orderPrice.value = ''
                                orderOperator.value = ''
                                orderMOBDEMOB.value = ''
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
                                orderItemQty.value = selrow.cells[3].innerText
                                orderUsage.value = selrow.cells[4].innerText
                                orderPrice.value = selrow.cells[5].innerText
                                orderOperator.value = selrow.cells[6].innerText
                                orderMOBDEMOB.value = selrow.cells[7].innerText
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
                        newcell.innerHTML = 1
                        newcell = newrow.insertCell(4)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TQUODETA_USAGE_DESCRIPTION']
                        newcell = newrow.insertCell(5)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_PRC']).format(',')
                        newcell = newrow.insertCell(6)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_OPRPRC']).format(',')
                        newcell = newrow.insertCell(7)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_MOBDEMOB']).format(',')
                        newcell = newrow.insertCell(8)
                        newcell = newrow.insertCell(9)
                    })
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                    let firstTabEl = document.querySelector('#quotation-type-nav-tab button[data-bs-target="#nav-rental"]')
                    let thetab = new bootstrap.Tab(firstTabEl)
                    thetab.show()

                    quotationSaleTable.getElementsByTagName('tbody')[0].innerHTML = ''
                    strongGrandTotalSale.innerText = 0
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
                    orderTable.getElementsByTagName('tbody')[0].innerHTML = ''
                }
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function loadSalesDraftDetail(data) {
        $.ajax({
            type: "GET",
            url: `sales-order-draft/document/${btoa(data.doc)}`,
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
                            orderItemQty.value = ''
                            orderUsage.value = ''
                            orderPrice.value = ''
                            orderOperator.value = ''
                            orderMOBDEMOB.value = ''
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
                            orderItemQty.value = selrow.cells[3].innerText
                            orderUsage.value = selrow.cells[4].innerText
                            orderPrice.value = selrow.cells[5].innerText
                            orderOperator.value = selrow.cells[6].innerText
                            orderMOBDEMOB.value = selrow.cells[7].innerText
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['TSLODRAFTDETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = arrayItem['TSLODRAFTDETA_ITMQT']
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = 0
                    newcell = newrow.insertCell(5)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TSLODRAFTDETA_ITMPRC_PER']).format(',')
                    newcell = newrow.insertCell(5)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = 0
                    newcell = newrow.insertCell(7)
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

    function btnUpdateLineOnclick() {
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
                    url: `receive-order/items/${idRow}`,
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
        orderTable.rows[pindex].cells[3].innerText = orderItemQty.value
        orderTable.rows[pindex].cells[4].innerText = orderUsage.value
        orderTable.rows[pindex].cells[5].innerText = orderPrice.value
        orderTable.rows[pindex].cells[6].innerText = orderOperator.value
        orderTable.rows[pindex].cells[7].innerText = orderMOBDEMOB.value
        orderTable.rows[pindex].cells[8].innerText = orderPeriodFrom.value
        orderTable.rows[pindex].cells[9].innerText = orderPeriodTo.value
        tribinClearTextBoxByClassName('orderInputItem')
    }

    function orderSourceByOnlClick(pthis) {
        quotationSearchBy.innerHTML = pthis.value === '1' ? ` <option value="0">Quotation Code</option>
                                    <option value="1">Customer</option>` : `<option value="0">Order Draft Code</option>
                                    <option value="1">Customer Name</option>
                                    <option value="2">Customer PO</option>`
        quotationSearch.focus()
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
                        TSLODETA_ITMCD: quotationItemCodeSale.value,
                        TSLODETA_ITMQT: quotationQtySale.value,
                        TSLODETA_USAGE_DESCRIPTION: 1,
                        TSLODETA_PRC: quotationPriceSale.value,
                    }
                    $.ajax({
                        type: "PUT",
                        url: `receive-order/items/${idItem}`,
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
                        url: `receive-order/items/${idItem}`,
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

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (err) {
            return false;
        }
    }

    function btnPreviewMapOnclick(pthis) {
        if (isValidUrl(orderEmbedCodeContainer.value)) {
            pthis.disabled = true
            pthis.innerText = 'Please wait'
            frame1.src = orderEmbedCodeContainer.value
        } else {
            const parser = new DOMParser()
            try {
                const htmlDoc = parser.parseFromString(orderEmbedCodeContainer.value, 'text/html')
                const htmlIframe = htmlDoc.body.firstChild
                if (isValidUrl(htmlIframe.src)) {
                    pthis.disabled = true
                    pthis.innerText = 'Please wait'
                    frame1.src = htmlIframe.src
                    orderEmbedCodeContainer.value = htmlIframe.src
                } else {
                    alertify.warning('URL is not valid')
                }
            } catch (ex) {
                alertify.warning('could not parsing')
            }
        }
    }

    frame1.addEventListener('load', function() {
        btnPreviewMaps.innerHTML = 'Preview Map'
        btnPreviewMaps.disabled = false
    })
</script>