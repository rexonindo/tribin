<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quotation Status</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="coa-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="approvalContainer">

        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="quotationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Quotation : <span id="labelQuotationInModal"></span></h1>
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
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-condition" type="button" role="tab"><i class="fa fa-users-rectangle"></i> Conditions</button>
                                    <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab"><i class="fa fa-timeline"></i> Approval Histories</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" tabindex="0">
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
                                            <div class="col-md-12 mb-3">
                                                <label for="quotationSubject" class="form-label">Subject</label>
                                                <input type="text" id="quotationSubject" class="form-control" placeholder="Penawaran ..." maxlength="100" disabled>
                                            </div>
                                        </div>
                                        <div class="row border-top" id="quotationDetailRentContainer">
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
                                                                <th class="text-end">Operator</th>
                                                                <th class="text-end">MOB DEMOB</th>
                                                                <th class="text-end">SUB TOTAL</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="6" class="text-end"><strong>Grand Total</strong></td>
                                                                <td class="text-end"><strong id="strongGrandTotal"></strong></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top" id="quotationDetailSalesContainer">
                                            <div class="col-md-12 mb-1">
                                                <div class="table-responsive" id="quotationSaleTableContainer">
                                                    <table id="quotationSaleTable" class="table table-sm table-hover table-bordered caption-top">
                                                        <caption>List of items</caption>
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
                                                                <td class="d-none"></td>
                                                                <td colspan="4" class="text-end"><strong>Grand Total</strong></td>
                                                                <td class="text-end"><strong id="strongSaleGrandTotal"></strong></td>
                                                            </tr>
                                                        </tfoot>
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
                                <div class="tab-pane fade" id="nav-condition" role="tabpanel" tabindex="1">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <ul class="list-group list-group-flush list-group-numbered" id="quotationConditionContainer">
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-history" role="tabpanel" tabindex="2">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <div class="table-responsive" id="approvalHistoryTableContainer">
                                                    <table id="approvalHistoryTable" class="table table-sm table-hover table-bordered caption-top">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Time</th>
                                                                <th>Status</th>
                                                                <th>Remark</th>
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
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" id="btnAction">Action</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" onclick="previewQuotation()">Print Preview</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function previewQuotation() {
        if (labelQuotationInModal.innerText.trim().length === 0) {
            alertify.message('Quotation Code is required')
            return
        }
        window.open(`PDF/quotation/${btoa(labelQuotationInModal.innerText)}`, '_blank');
    }
    function loadApprovalList() {
        approvalContainer.innerHTML = 'Please wait'
        $.ajax({
            type: "GET",
            url: "/approval/quotation",
            dataType: "json",
            success: function(response) {
                let innerHTML = ''
                approvalContainer.innerHTML = ''
                response.dataApproved.forEach((arrayItem) => {
                    const col = document.createElement('div')
                    col.classList.add('col')
                    const elCard = document.createElement('div')
                    elCard.classList.add(...['card', 'shadow-sm'])
                    elCard.innerHTML = `<svg class="bd-placeholder-img card-img-top" width="100%" height="125" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Customer</title>
                    <rect width="100%" height="100%" fill="#188273" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">${arrayItem['MCUS_CUSNM']}</text>
                    </svg>`
                    const elCardBody = document.createElement('div')
                    elCardBody.classList.add('card-body')
                    const elCardBodyText = document.createElement('p')
                    elCardBodyText.classList.add('card-text')
                    elCardBodyText.innerHTML = '<b>' + arrayItem['TQUO_QUOCD'] + '</b><br>' + arrayItem['TQUO_SBJCT']

                    const elCardBodyText2 = document.createElement('p')
                    let quotationStatus = 0
                    elCardBodyText2.classList.add('card-text')
                    if (arrayItem['type']) {
                        if (arrayItem['type'] == '2') {
                            elCardBodyText2.innerHTML = '<span class="badge bg-info">Revision is required</span>'
                            quotationStatus = -2
                        }
                    } else {
                        if (!arrayItem['TQUO_APPRVDT'] && !arrayItem['TQUO_REJCTDT']) {
                            elCardBodyText2.innerHTML = '<span class="badge bg-warning">Being reviewed</span>'
                        } else {
                            if (arrayItem['TQUO_APPRVDT']) {
                                elCardBodyText2.innerHTML = '<span class="badge bg-success">Approved</span>'
                                quotationStatus = 1
                            } else {
                                elCardBodyText2.innerHTML = '<span class="badge bg-danger">Rejected</span>'
                                quotationStatus = -1
                            }
                        }
                    }

                    const elFlex = document.createElement('div')
                    elFlex.classList.add(...['d-flex', 'justify-content-between', 'align-items-center'])

                    const elButtonGrup = document.createElement('div')
                    elButtonGrup.classList.add(...['btn-group', 'btn-group-sm'])

                    if (quotationStatus === 1) {
                        const elButton2 = document.createElement('button')
                        elButton2.classList.add(...['btn', 'btn-outline-primary'])
                        elButton2.innerHTML = 'Create Receive Order'
                        elButton2.onclick = () => {
                            event.preventDefault()
                            ContentContainer.innerHTML = 'Please wait'
                            $.ajax({
                                type: "GET",
                                url: 'receive-order/form',
                                dataType: "text",
                                success: function(response) {
                                    setInnerHTML(ContentContainer, response)
                                    if (!myCollapse.classList.contains('collapsed')) {
                                        mybsCollapse.toggle()
                                    }

                                }
                            });
                        }
                        elButtonGrup.appendChild(elButton2)
                    }

                    if (quotationStatus === -2) {
                        const elButton2 = document.createElement('button')
                        elButton2.classList.add(...['btn', 'btn-outline-primary'])
                        elButton2.innerHTML = 'Preview'
                        elButton2.onclick = () => {
                            event.preventDefault()
                            quotationCustomer.value = arrayItem['MCUS_CUSNM']
                            labelQuotationInModal.innerHTML = arrayItem['TQUO_QUOCD']                            
                            quotationSubject.value = arrayItem['TQUO_SBJCT']
                            branch.value = arrayItem['TQUO_BRANCH']
                            if (arrayItem['TQUO_TYPE'] === '1') {
                                quotationDetailRentContainer.classList.remove('d-none')
                                quotationDetailSalesContainer.classList.add('d-none')
                            } else {
                                quotationDetailRentContainer.classList.add('d-none')
                                quotationDetailSalesContainer.classList.remove('d-none')
                            }
                            const myModal = new bootstrap.Modal(document.getElementById('quotationModal'), {})
                            myModal.show()
                            loadQuotationDetail({
                                doc: arrayItem['TQUO_QUOCD'],
                                docType: arrayItem['TQUO_TYPE']
                            })
                        }
                        elButtonGrup.appendChild(elButton2)
                    }

                    const elSmalltext = document.createElement('small')
                    elSmalltext.classList.add('text-body-secondary')
                    elSmalltext.innerText = moment(arrayItem['CREATED_AT']).startOf('hour').fromNow()

                    // combine                    
                    elFlex.appendChild(elButtonGrup)
                    elFlex.appendChild(elSmalltext)
                    elCardBody.appendChild(elCardBodyText)
                    elCardBody.appendChild(elCardBodyText2)
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

    function loadQuotationDetail(data) {
        $.ajax({
            type: "GET",
            url: `quotation/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                let myContainer = document.getElementById("quotationTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = quotationTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("quotationTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.dataItem.forEach((arrayItem) => {
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
                    newcell.innerHTML = arrayItem['TQUODETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = arrayItem['TQUODETA_USAGE']
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TQUODETA_PRC']).format(',')
                    newcell = newrow.insertCell(5)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TQUODETA_OPRPRC']).format(',')
                    newcell = newrow.insertCell(6)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = numeral(arrayItem['TQUODETA_MOBDEMOB']).format(',')
                })
                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
                quotationConditionContainer.innerHTML = ''
                response.dataCondition.forEach((arrayItem) => {
                    const liElement = document.createElement('li')
                    liElement.classList.add(...['list-group-item', 'd-flex', 'justify-content-between', 'align-items-start'])
                    const childLiElement = document.createElement('div')
                    childLiElement.classList.add(...['ms-2', 'me-auto'])
                    childLiElement.innerHTML = arrayItem['TQUOCOND_CONDI']
                    const childLiElement2 = document.createElement('span')
                    childLiElement2.classList.add(...['badge', 'bg-info', 'rounded-pill'])
                    childLiElement2.innerHTML = `<i class="fas fa-check"></i>`
                    childLiElement2.style.cssText = 'cursor:pointer'
                    liElement.appendChild(childLiElement)
                    liElement.appendChild(childLiElement2)
                    quotationConditionContainer.appendChild(liElement)
                })
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }

    function loadQuotationDetail(data) {
        approvalHistoryTable.getElementsByTagName("tbody")[0].innerHTML = `<tr><td colspan="3" class="text-center">Please wait</td></tr>`
        let notifContainer = document.getElementById('div-alert')
        notifContainer.innerHTML = ''
        quotationTable.getElementsByTagName("tbody")[0].innerHTML = '<tr><td colspan="8">Please wait</td></tr>'
        quotationSaleTable.getElementsByTagName("tbody")[0].innerHTML = '<tr><td colspan="6">Please wait</td></tr>'

        $.ajax({
            type: "GET",
            url: `quotation/${btoa(data.doc)}`,
            dataType: "json",
            success: function(response) {
                if (data.docType === '1') {
                    let myContainer = document.getElementById("quotationTableContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = quotationTable.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("quotationTable");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    let myStrong = myfrag.getElementById("strongGrandTotal");
                    myTableBody.innerHTML = ''
                    let grandTotal = 0
                    response.dataItem.forEach((arrayItem) => {
                        const subTotal = numeral(arrayItem['TQUODETA_PRC']).value() +
                            numeral(arrayItem['TQUODETA_OPRPRC']).value() +
                            numeral(arrayItem['TQUODETA_MOBDEMOB']).value()
                        grandTotal += subTotal
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
                        newcell.innerHTML = arrayItem['TQUODETA_ITMCD']
                        newcell = newrow.insertCell(2)
                        newcell.innerHTML = arrayItem['MITM_ITMNM']
                        newcell = newrow.insertCell(3)
                        newcell.classList.add('text-center')
                        newcell.innerHTML = arrayItem['TQUODETA_USAGE_DESCRIPTION']
                        newcell = newrow.insertCell(4)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_PRC']).format(',')
                        newcell = newrow.insertCell(5)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_OPRPRC']).format(',')
                        newcell = newrow.insertCell(6)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(arrayItem['TQUODETA_MOBDEMOB']).format(',')
                        newcell = newrow.insertCell(7)
                        newcell.classList.add('text-end')
                        newcell.innerHTML = numeral(subTotal).format(',')
                    })
                    myStrong.innerText = numeral(grandTotal).format(',')
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                } else {
                    let myContainer = document.getElementById("quotationSaleTableContainer");
                    let myfrag = document.createDocumentFragment();
                    let cln = quotationSaleTable.cloneNode(true);
                    myfrag.appendChild(cln);
                    let myTable = myfrag.getElementById("quotationSaleTable");
                    let myTableBody = myTable.getElementsByTagName("tbody")[0];
                    myTableBody.innerHTML = ''
                    grandTotal = 0
                    response.dataItem.forEach((arrayItem) => {
                        const subTotal = numeral(arrayItem['TQUODETA_PRC']).value() * arrayItem['TQUODETA_ITMQT']
                        newrow = myTableBody.insertRow(-1)
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
                    myContainer.innerHTML = ''
                    myContainer.appendChild(myfrag)
                    strongSaleGrandTotal.innerText = numeral(grandTotal).format(',')
                }

                quotationConditionContainer.innerHTML = ''
                response.dataCondition.forEach((arrayItem) => {
                    const liElement = document.createElement('li')
                    liElement.classList.add(...['list-group-item', 'd-flex', 'justify-content-between', 'align-items-start'])
                    const childLiElement = document.createElement('div')
                    childLiElement.classList.add(...['ms-2', 'me-auto'])
                    childLiElement.innerHTML = arrayItem['TQUOCOND_CONDI']
                    const childLiElement2 = document.createElement('span')
                    childLiElement2.classList.add(...['badge', 'bg-info', 'rounded-pill'])
                    childLiElement2.innerHTML = `<i class="fas fa-check"></i>`
                    childLiElement2.style.cssText = 'cursor:pointer'
                    liElement.appendChild(childLiElement)
                    liElement.appendChild(childLiElement2)
                    quotationConditionContainer.appendChild(liElement)
                })

                // load approval history
                let myContainer = document.getElementById("approvalHistoryTableContainer");
                let myfrag = document.createDocumentFragment();
                let cln = approvalHistoryTable.cloneNode(true);
                myfrag.appendChild(cln);
                let myTable = myfrag.getElementById("approvalHistoryTable");
                let myTableBody = myTable.getElementsByTagName("tbody")[0];
                myTableBody.innerHTML = ''
                response.approvalHistories.forEach((arrayItem) => {
                    newrow = myTableBody.insertRow(-1)
                    newcell = newrow.insertCell(0)
                    newcell.innerHTML = arrayItem['created_at']
                    newcell = newrow.insertCell(1)
                    newcell.innerHTML = arrayItem['type'] == '2' ? 'Advise for revision' : 'Approved'
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['remark']
                })

                myContainer.innerHTML = ''
                myContainer.appendChild(myfrag)
            },
            error: function(xhr, xopt, xthrow) {
                alertify.warning(xthrow);
            }
        });
    }
</script>