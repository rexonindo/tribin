<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">SPK Approval</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="coa-form">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3" id="approvalContainer">

        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delivery Order : <span id="labelQuotationInModal"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col mb-1" id="div-alert">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab">Item</button>
                                    <button class="nav-link" id="nav-cost-tab" data-bs-toggle="tab" data-bs-target="#nav-cost" type="button" role="tab">Costs</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col-md-6 mb-1">
                                                <label for="quotationCustomer" class="form-label">Customer Name</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" id="quotationCustomer" class="form-control" maxlength="50" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label for="quotationCustomer" class="form-label">Address Name</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" id="quotationAddressName" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label for="quotationCustomer" class="form-label">Address Description</label>
                                                <div class="input-group input-group-sm mb-1">
                                                    <textarea id="quotationAddressDescription" class="form-control" disabled>
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top">
                                            <div class="col-md-12 mb-1">
                                                <div class="table-responsive" id="quotationTableContainer">
                                                    <table id="quotationTable" class="table table-sm table-hover table-bordered caption-top">
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
                                        <div class="row">
                                            <div class="col">
                                                <input type="hidden" id="branch" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-cost" role="tabpanel" aria-labelledby="nav-cost-tab" tabindex="1">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col mb-1" id="div-alert-cost">
                                            </div>
                                        </div>
                                        <fieldset class="border rounded-3 p-2">
                                            <legend class="float-none w-auto px-3">Orang</legend>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">PIC As</span>
                                                        <select class="form-select" id="PICAs" disabled>
                                                            <option value="-">-</option>
                                                            <option value="DRIVER">DRIVER</option>
                                                            <option value="MECHANIC">MECHANIC</option>
                                                            <option value="OPERATOR">OPERATOR</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">PIC Name</span>
                                                        <input type="text" id="PICName" class="form-control" maxlength="70" readonly disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Tugas</span>
                                                        <input type="text" id="tugas" class="form-control orderInputItem" maxlength="70" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border rounded-3 p-2">
                                            <legend class="float-none w-auto px-3">Kendaraan</legend>
                                            <div class="row">
                                                <div class="col-md-3 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">KM</span>
                                                        <input type="number" id="KM" class="form-control orderInputItem" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Jenis</span>
                                                        <input type="text" id="jenisKendaraan" class="form-control orderInputItem" maxlength="35" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Jumlah Roda</span>
                                                        <select class="form-select" id="Wheels" disabled>
                                                            <option value="4">4</option>
                                                            <option value="6">6</option>
                                                            <option value="10">10</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-1">
                                                    <label class="form-label">Solar Supplier</label>
                                                    <select class="form-select form-select-sm" id="Supplier" disabled>
                                                        <option value="SPBU">SPBU</option>
                                                        <option value="JAT">JAT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-1">
                                                    <label class="form-label">Liters (Existing)</label>
                                                    <input type="number" id="litersExisting" class="form-control form-control-sm orderInputItem" disabled>
                                                </div>
                                                <div class="col-md-4 mb-1">
                                                    <label class="form-label">Liters</label>
                                                    <input type="number" id="liters" class="form-control form-control-sm orderInputItem" disabled>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="border rounded-3 p-2">
                                            <legend class="float-none w-auto px-3">Biaya</legend>
                                            <div class="row">
                                                <div class="col-md-12 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Uang Jalan</span>
                                                        <input type="number" id="uangJalan" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Makan</span>
                                                        <input type="number" id="uangMakan" class="form-control orderInputItem" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Mandah</span>
                                                        <input type="number" id="uangMandah" class="form-control orderInputItem" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Pengawalan</span>
                                                        <input type="number" id="uangPengawalan" class="form-control orderInputItem" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Penginapan</span>
                                                        <input type="number" id="uangPenginapan" class="form-control orderInputItem" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-1">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">Lain<sup>2</sup></span>
                                                        <input type="number" id="uangLain" class="form-control orderInputItem" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="border rounded-3 p-2 mb-2">
                                            <legend class="float-none w-auto px-3">Waktu</legend>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <label for="tanggalBerangkat" class="form-label">Berangkat</label>
                                                    <input type="text" id="tanggalBerangkat" class="form-control orderInputItem" maxlength="20" readonly disabled>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <label for="tanggalKembali" class="form-label">Kembali</label>
                                                    <input type="text" id="tanggalKembali" class="form-control orderInputItem" maxlength="20" readonly disabled>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" id="btnAction">Action</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" onclick="approveQuotation(this)"><i class="fas fa-check text-success"></i> Approve</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="selectedRowAtOrderTable">
<input type="hidden" id="idSPK">
<script>
    function loadApprovalList() {
        approvalContainer.innerHTML = 'Please wait'
        $.ajax({
            type: "GET",
            url: "/approval/spk",
            dataType: "json",
            success: function(response) {
                let innerHTML = ''
                approvalContainer.innerHTML = ''
                response.data.forEach((arrayItem) => {
                    const col = document.createElement('div')
                    col.classList.add('col')
                    const elCard = document.createElement('div')
                    elCard.classList.add(...['card', 'shadow-sm'])
                    elCard.innerHTML = `<svg class="bd-placeholder-img card-img-top" width="100%" height="125" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Customer</title>
                    <rect width="100%" height="100%" fill="#188273" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">${arrayItem['USER_PIC_NAME']}</text>
                    </svg>`
                    const elCardBody = document.createElement('div')
                    elCardBody.classList.add('card-body')
                    const elCardBodyText = document.createElement('p')
                    elCardBodyText.classList.add('card-text')
                    elCardBodyText.innerHTML = '<b>' + arrayItem['CSPK_DOCNO'] + '</b>'

                    const elFlex = document.createElement('div')
                    elFlex.classList.add(...['d-flex', 'justify-content-between', 'align-items-center'])

                    const elButtonGrup = document.createElement('div')
                    elButtonGrup.classList.add(...['btn-group', 'btn-group-sm'])

                    const elButtonGrup2 = document.createElement('div')
                    elButtonGrup2.classList.add(...['btn-group', 'btn-group-sm'])

                    const elButton2 = document.createElement('button')
                    elButton2.classList.add(...['btn', 'btn-outline-primary'])
                    elButton2.innerHTML = 'Review'
                    elButton2.onclick = () => {
                        event.preventDefault()
                        idSPK.value = arrayItem['id']
                        quotationCustomer.value = arrayItem['MCUS_CUSNM']

                        labelQuotationInModal.innerHTML = arrayItem['CSPK_REFF_DOC']
                        branch.value = arrayItem['CSPK_BRANCH']
                        PICAs.value = arrayItem['CSPK_PIC_AS']
                        PICName.value = arrayItem['USER_PIC_NAME']
                        tugas.value = arrayItem['CSPK_JOBDESK']
                        KM.value = arrayItem['CSPK_KM']
                        jenisKendaraan.value = arrayItem['CSPK_VEHICLE_TYPE']
                        Wheels.value = arrayItem['CSPK_WHEELS']
                        Supplier.value = arrayItem['CSPK_SUPPLIER']
                        litersExisting.value = arrayItem['CSPK_LITER_EXISTING']
                        liters.value = arrayItem['CSPK_LITER']

                        uangMakan.value = arrayItem['CSPK_UANG_MAKAN']
                        uangMandah.value = arrayItem['CSPK_UANG_MANDAH']
                        uangPengawalan.value = arrayItem['CSPK_UANG_PENGAWALAN']
                        uangPenginapan.value = arrayItem['CSPK_UANG_PENGINAPAN']
                        uangLain.value = arrayItem['CSPK_UANG_LAIN2']
                        uangJalan.value = arrayItem['CSPK_UANG_JALAN']

                        tanggalBerangkat.value = arrayItem['CSPK_LEAVEDT']
                        tanggalKembali.value = arrayItem['CSPK_BACKDT']

                        const myModal = new bootstrap.Modal(document.getElementById('quotationModal'), {})
                        myModal.show()
                        loadQuotationDetail({
                            doc: arrayItem['CSPK_REFF_DOC'],
                            branch: arrayItem['CSPK_BRANCH']
                        })
                    }

                    const elSmalltext = document.createElement('small')
                    elSmalltext.classList.add('text-body-secondary')
                    elSmalltext.innerText = moment(arrayItem['created_at']).startOf('hour').fromNow()

                    // combine
                    elButtonGrup.appendChild(elButton2)
                    elFlex.appendChild(elButtonGrup)
                    elFlex.appendChild(elSmalltext)
                    elCardBody.appendChild(elCardBodyText)
                    elCardBody.appendChild(elFlex)
                    elCard.appendChild(elCardBody)
                    col.appendChild(elCard)
                    approvalContainer.appendChild(col)
                })
            },
            error: function(xhr, xopt, xthrow) {
                approvalContainer.innerHTML = xthrow
            }
        });
    }
    loadApprovalList()

    function approveQuotation(pthis) {
        if (confirm('Are you sure ?')) {
            btnAction.disabled = true
            $.ajax({
                type: "PUT",
                url: `approval/approve-spk/${idSPK.value}`,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                dataType: "json",
                success: function(response) {
                    $("#quotationModal").modal('hide')
                    btnAction.disabled = false
                    loadApprovalList()
                    showNotificationToApprove()
                },
                error: function(xhr, xopt, xthrow) {
                    btnAction.disabled = false
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

    function loadQuotationDetail(data) {
        quotationAddressName.value = 'Please wait'
        quotationAddressDescription.value = 'Please wait'
        $.ajax({
            type: "GET",
            url: `delivery/document/${btoa(data.doc)}`,
            data: {
                TDLVORDDETA_BRANCH: data.branch
            },
            dataType: "json",
            success: function(response) {
                quotationAddressName.value = response.SalesOrder[0].TSLO_ADDRESS_NAME
                quotationAddressDescription.value = response.SalesOrder[0].TSLO_ADDRESS_DESCRIPTION
                let myContainer = document.getElementById("quotationTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = quotationTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("quotationTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                let grandTotal = 0
                response.data.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newrow.onclick = (event) => {
                        const selrow = quotationTable.rows[event.target.parentElement.rowIndex]
                        if (selrow.title === 'selected') {
                            selrow.title = 'not selected'
                            selrow.classList.remove('table-info')
                        } else {
                            const ttlrows = quotationTable.rows.length
                            for (let i = 1; i < ttlrows; i++) {
                                quotationTable.rows[i].classList.remove('table-info')
                                quotationTable.rows[i].title = 'not selected'
                            }
                            selrow.title = 'selected'
                            selrow.classList.add('table-info')
                        }
                    }
                    newcell = newrow.insertCell(0)
                    newcell.classList.add('d-none')
                    newcell.innerHTML = arrayItem['id']
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
                quotationAddressName.value = ''
                quotationAddressDescription.value = ''
            }
        });
    }
</script>