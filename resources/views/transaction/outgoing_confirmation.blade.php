<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Outgoing Confirmation</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-1 text-center">
            <button class="btn btn-sm btn-outline-primary" id="btnRefresh" onclick="btnRefreshOnclick(this)"><i class="fas fa-sync"></i></button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-1">
            <table id="tableConfirmation" class="table table-sm table-striped table-bordered table-hover compact" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">DO Number</th>
                        <th class="text-center">Customer</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalConfirmation" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasItemList">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasTopLabel">Item List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
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
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>Stock</th>
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

                <div class="container-fluid">
                    <div class="row">
                        <div class="col mb-1" id="div-alert">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="inputTXID" class="form-label">DO Number</label>
                                <input type="text" class="form-control" id="documentNumber" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab">Item</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-condition" type="button" role="tab"><i class="fa fa-users-rectangle"></i> Accessories</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" tabindex="0">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row border-top" id="quotationDetailRentContainer">
                                            <div class="col-md-12 mb-1">
                                                <div class="table-responsive" id="quotationTableContainer">
                                                    <table id="quotationTable" class="table table-sm table-hover table-bordered caption-top">
                                                        <caption>List of items</caption>
                                                        <thead class="table-light text-center">
                                                            <tr>
                                                                <th class="d-none" rowspan="2">idLine</th>
                                                                <th colspan="3">Request</th>
                                                                <th colspan="2">Actual</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th>Qty</th>
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
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
                                <div class="tab-pane fade" id="nav-condition" role="tabpanel" tabindex="1">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col-md-6 mb-1">
                                                <label for="quotationItemCode" class="form-label">Item Code</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" id="quotationItemCode" class="form-control" placeholder="Item Code" disabled>
                                                    <button class="btn btn-primary" type="button" onclick="btnShowItemModal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasItemList"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label for="quotationItemName" class="form-label">Item Name</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" id="quotationItemName" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label for="quotationItemQty" class="form-label">Quantity</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" id="quotationItemQty" class="form-control">
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
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <div class="table-responsive" id="accessoriesTableContainer">
                                                    <table id="accessoriesTable" class="table table-sm table-hover table-bordered caption-top">
                                                        <caption>List of items</caption>
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th class="d-none">idLine</th>
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th class="text-center">Qty</th>
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="btnConfirmOnClick(this)">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    var DTOutgoingConfirmation;
    var selectedRowIndex = -1
    var selectedColumnIndex = -1
    var selectedDBRowID = -1
    var senderContext = -1

    function btnShowItemModal() {
        senderContext = 2
    }

    function btnConfirmOnClick(pthis) {
        if (confirm("Are you sure ?")) {
            pthis.disabled = true
            pthis.innerHTML = 'Please wait'
            $.ajax({
                type: "POST",
                url: "delivery/confirm",
                data: {
                    id: documentNumber.value,
                    _token: '{{ csrf_token() }}',
                },
                dataType: "json",
                success: function(response) {
                    pthis.innerHTML = 'Confirm'
                    pthis.disabled = false
                    alertify.success(response.msg);
                    btnRefreshOnclick(btnRefresh);
                    $('#modalConfirmation').modal('hide')
                },
                error: function(xhr, xopt, xthrow) {
                    pthis.innerHTML = 'Confirm'
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
    }

    function btnRefreshOnclick(p) {
        p.disabled = true;
        DTOutgoingConfirmation = $('#tableConfirmation').DataTable({
            select: true,
            fixedHeader: true,
            destroy: true,
            scrollX: true,
            scrollY: true,
            ajax: {
                url: 'delivery/unconfirmed',
                dataSrc: function(json) {
                    btnRefresh.disabled = false;
                    return json.data;
                }
            },
            columns: [{
                    data: 'TDLVORD_DLVCD'
                },
                {
                    data: 'MCUS_CUSNM'
                },
                {
                    data: 'MCUS_CUSNM',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<input type="button" class="btn btn-sm btn-success" value="Confirm">';
                    },
                    createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                        $(cell).on("click", "input", rowData, function() {
                            documentNumber.value = rowData.TDLVORD_DLVCD
                            loadDODetail({
                                doc: rowData.TDLVORD_DLVCD
                            })
                            $('#modalConfirmation').modal('show')
                        });
                    }
                }
            ],
            columnDefs: [{

            }]
        });
    }

    function loadDODetail(pdata) {
        quotationTable.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="7" class="text-center">Please wait</td></tr>`
        loadAccessories()
        $.ajax({
            type: "GET",
            url: `delivery/document/${btoa(pdata.doc)}`,
            dataType: "JSON",
            success: function(response) {
                let myContainer = document.getElementById("quotationTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = quotationTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("quotationTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['TDLVORDDETA_ITMCD']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(-1)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TDLVORDDETA_ITMQT']

                    newcell = newrow.insertCell(-1)
                    newcell.onclick = (event) => {
                        selectedDBRowID = arrayItem['id']
                        selectedRowIndex = event.srcElement.parentElement.rowIndex
                        selectedColumnIndex = event.srcElement.cellIndex
                        senderContext = 1
                    }
                    newcell.setAttribute('data-bs-toggle', 'offcanvas')
                    newcell.setAttribute('data-bs-target', '#offcanvasItemList')
                    newcell.style.cssText = 'cursor:pointer'
                    newcell.classList.add('bg-info', 'bg-opacity-10', 'border', 'border-info', 'rounded')
                    newcell.innerHTML = arrayItem['TDLVORDDETA_ITMCD_ACT']

                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['ITMNM_ACT']
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
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
        });
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
                url: "inventory/status",
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
                            if (senderContext === 1) {
                                quotationTable.rows[selectedRowIndex].cells[selectedColumnIndex].innerHTML = 'Please wait'
                                $.ajax({
                                    type: "PUT",
                                    url: `delivery/items-actual/${btoa(selectedDBRowID)}`,
                                    data: {
                                        TDLVORDDETA_ITMCD_ACT: arrayItem['MITM_ITMCD'],
                                        _token: '{{ csrf_token() }}',
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        quotationTable.rows[selectedRowIndex].cells[selectedColumnIndex].innerHTML = arrayItem['MITM_ITMCD']
                                        quotationTable.rows[selectedRowIndex].cells[selectedColumnIndex + 1].innerHTML = arrayItem['MITM_ITMNM']
                                    },
                                    error: function(xhr, xopt, xthrow) {
                                        quotationTable.rows[selectedRowIndex].cells[selectedColumnIndex].innerHTML = 'Please try again'
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
                            } else {
                                quotationItemCode.value = arrayItem['MITM_ITMCD']
                                quotationItemName.value = arrayItem['MITM_ITMNM']
                            }
                        }
                        newcell.setAttribute('data-bs-dismiss', 'offcanvas')
                        newcell = newrow.insertCell(1)
                        newcell.innerHTML = arrayItem['MITM_ITMNM']
                        newcell = newrow.insertCell(2)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = arrayItem['STOCKQT']
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

    offcanvasItemList.addEventListener('shown.bs.offcanvas', () => {
        itemSearch.focus()
    })

    function btnSaveLineOnclick(pthis) {
        if (quotationItemCode.value.trim().length === 0) {
            alertify.warning('Item is required')
            return
        }
        const data = {
            TDLVACCESSORY_DLVCD: documentNumber.value,
            TDLVACCESSORY_ITMCD: quotationItemCode.value,
            TDLVACCESSORY_ITMQT: quotationItemQty.inputmask ? quotationItemQty.inputmask.unmaskedvalue() : quotationItemQty.value.trim(),
            _token: '{{ csrf_token() }}',
        }
        pthis.disabled = true
        pthis.innerHTML = 'Please wait'
        $.ajax({
            type: "POST",
            url: `delivery/accessory-items/${btoa(documentNumber.value)}`,
            data: data,
            dataType: "JSON",
            success: function(response) {
                pthis.innerHTML = 'Save Line'
                pthis.disabled = false
                alertify.success(response.message)
                loadAccessories()
            },
            error: function(xhr, xopt, xthrow) {
                pthis.innerHTML = 'Save Line'
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

    function loadAccessories() {
        accessoriesTable.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please wait</td></tr>`
        $.ajax({
            type: "GET",
            url: `delivery/accessory-items/${btoa(documentNumber.value)}`,
            dataType: "JSON",
            success: function(response) {
                let myContainer = document.getElementById("accessoriesTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = accessoriesTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("accessoriesTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = accessoriesTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                            quotationItemCode.value = ''
                            quotationItemName.value = ''
                            quotationItemQty.value = ''
                        } else {
                            const ttlrows = accessoriesTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                accessoriesTable.rows[i].classList.remove('table-info')
                                accessoriesTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                            quotationItemCode.value = arrayItem['MITM_ITMCD']
                            quotationItemName.value = arrayItem['MITM_ITMNM']
                            Inputmask.setValue(quotationItemQty, numeral(arrayItem['TDLVACCESSORY_ITMQT']).value())
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['MITM_ITMCD']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(-1)
                    newcell.innerHTML = arrayItem['TDLVACCESSORY_ITMQT']
                    newcell.classList.add('text-end')
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                accessoriesTable.getElementsByTagName('tbody')[0].innerHTML = `<tr><td colspan="4">Please reload the page</td></tr>`
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

    Inputmask({
        'alias': 'decimal',
        'groupSeparator': ',',
    }).mask(quotationItemQty);

    function btnRemoveLineOnclick(pthis) {
        const ttlrows = accessoriesTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (accessoriesTable.rows[i].title === 'selected') {
                idItem = accessoriesTable.rows[i].cells[0].innerText.trim()
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
                        url: `delivery/accessory-items/${idItem}`,
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Remove line`
                            pthis.disabled = false
                            accessoriesTable.rows[iFounded].remove()
                            alertify.message(response.msg)
                        },
                        error: function(xhr, xopt, xthrow) {
                            alertify.warning(xthrow);
                            pthis.disabled = false
                            pthis.innerHTML = `Remove line`
                        }
                    });
                } else {
                    accessoriesTable.rows[iFounded].remove()
                }
            }
        } else {
            alertify.message('nothing selected item')
        }
    }

    function btnUpdateLineOnclick(pthis) {
        const ttlrows = accessoriesTable.rows.length
        let idItem = ''
        let iFounded = 0
        for (let i = 1; i < ttlrows; i++) {
            if (accessoriesTable.rows[i].title === 'selected') {
                idItem = accessoriesTable.rows[i].cells[0].innerText.trim()
                iFounded = i
                break
            }
        }

        if (iFounded > 0) {
            if (confirm(`Are you sure want to update ?`)) {
                if (idItem.length >= 1) {
                    pthis.disabled = true
                    pthis.innerHTML = `Please wait`
                    $.ajax({
                        type: "PUT",
                        url: `delivery/accessory-items/${idItem}`,
                        data: {
                            TDLVACCESSORY_ITMCD: quotationItemCode.value,
                            TDLVACCESSORY_ITMQT: quotationItemQty.inputmask ? quotationItemQty.inputmask.unmaskedvalue() : quotationItemQty.value.trim(),
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            pthis.innerHTML = `Update line`
                            pthis.disabled = false
                            alertify.message(response.msg)
                            refreshTableRent(iFounded)
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
        accessoriesTable.rows[selectedRow].cells[1].innerText = quotationItemCode.value
        accessoriesTable.rows[selectedRow].cells[2].innerText = quotationItemName.value
        accessoriesTable.rows[selectedRow].cells[3].innerText = quotationItemQty.value
    }
</script>