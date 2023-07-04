<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Purchase Request</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="purchaseRequest-form">
    <div class="container">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label for="purchaseRequestCode" class="form-label">Purchase Request Code</label>
                <div class="input-group mb-1">
                    <input type="text" id="purchaseRequestCode" class="form-control" placeholder="PCR..." maxlength="17" disabled>
                    <button class="btn btn-primary" type="button" onclick="btnShowPurchaseModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <label for="purchaseRequestIssueDate" class="form-label">Issue Date</label>
                <input type="text" id="purchaseRequestIssueDate" class="form-control" maxlength="10" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Purpose</span>
                    <input type="text" class="form-control" id="purpose" list="purposeList">
                    <datalist id="purposeList">
                        <option value="Bengkel">
                        <option value="Kendaraan">
                        <option value="Perawatan Mesin">
                        <option value="Perlengkapan Kantor">
                    </datalist>
                </div>
            </div>
        </div>
        <div class="row border-top">
            <div class="col-md-12 mb-1">
                <div class="table-responsive" id="purchaseRequestTableContainer">
                    <table id="purchaseRequestTable" class="table table-sm table-hover table-bordered caption-top">
                        <caption>List of items</caption>
                        <thead class="table-light">
                            <tr>
                                <th class="d-none">idLine</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th class="text-end">Qty</th>
                                <th class="text-center">Required Date</th>
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
                    <input type="text" id="purchaseRequestItemCode" class="form-control purchaseRequestInputItem" placeholder="Item Code" disabled>
                    <button class="btn btn-primary" type="button" onclick="btnShowItemModal()"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 mb-1">
                <div class="input-group input-group-sm mb-1">
                    <span class="input-group-text">Item Name</span>
                    <input type="text" id="purchaseRequestItemName" class="form-control purchaseRequestInputItem" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-1">
                <label class="form-label">Qty</label>
                <input type="text" id="purchaseRequestQty" class="form-control form-control-sm purchaseRequestInputItem">
            </div>
            <div class="col-md-6 mb-1">
                <label for="purchaseRequestRequiredDate" class="form-label">Required Date</label>
                <input type="text" id="purchaseRequestRequiredDate" class="form-control form-control-sm" maxlength="10" readonly>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-1 text-center">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" id="btnSaveLine" onclick="btnSaveLineOnclick(this)">Save line</button>
                    <button type="button" class="btn btn-outline-secondary" id="btnRemoveLine" onclick="btnRemoveLineOnclick(this)">Remove line</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col mt-1 mb-1">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary" id="btnNew" onclick="btnNewOnclick(this)" title="New"><i class="fas fa-file"></i></button>
                    <button type="button" class="btn btn-outline-primary" id="btnSave" onclick="btnSaveOnclick(this)" title="Save"><i class="fas fa-save"></i></button>
                    <button type="button" class="btn btn-outline-primary" id="btnPrint" onclick="btnPrintOnclick(this)" title="Print"><i class="fas fa-print"></i></button>
                </div>
            </div>
        </div>
        <input type="hidden" id="purchaseRequestInputMode" value="0">
    </div>

</form>
<!-- Modal -->
<div class="modal fade" id="purchaseRequestModal" tabindex="-1">
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
                                <select id="purchaseRequestSearchBy" class="form-select" onchange="purchaseRequestSearch.focus()">
                                    <option value="0">Quotation Code</option>
                                    <option value="1">Customer</option>
                                </select>
                                <input type="text" id="purchaseRequestSearch" class="form-control" maxlength="50" onkeypress="purchaseRequestSearchOnKeypress(event)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive" id="purchaseRequestSavedTabelContainer">
                                <table id="purchaseRequestSavedTabel" class="table table-sm table-striped table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Issue Date</th>
                                            <th>Purpose</th>
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
    $("#purchaseRequestIssueDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5'
    })
    $("#purchaseRequestRequiredDate").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        uiLibrary: 'bootstrap5',
        size : 'small'
    })

    function btnShowPurchaseModal() {

    }
</script>