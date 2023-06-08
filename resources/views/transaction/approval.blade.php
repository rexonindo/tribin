<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Approval List</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="coa-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3" id="approvalContainer">

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
                        <div class="col">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab">Item</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-condition" type="button" role="tab"><i class="fa fa-users-rectangle"></i> Conditions</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
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
                                                                <th class="text-center">Usage</th>
                                                                <th class="text-end">Price</th>
                                                                <th class="text-end">Operator</th>
                                                                <th class="text-end">MOB DEMOB</th>
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
                                <div class="tab-pane fade" id="nav-condition" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                                    <div class="container-fluid mt-2 border-start border-bottom rounded-start">
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
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadApprovalList() {
        approvalContainer.innerHTML = 'Please wait'
        $.ajax({
            type: "GET",
            url: "/approval/quotation",
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
                    <rect width="100%" height="100%" fill="#188273" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">${arrayItem['MCUS_CUSNM']}</text>
                    </svg>`
                    const elCardBody = document.createElement('div')
                    elCardBody.classList.add('card-body')
                    const elCardBodyText = document.createElement('p')
                    elCardBodyText.classList.add('card-text')
                    elCardBodyText.innerHTML = '<b>' + arrayItem['TQUO_QUOCD'] + '</b><br>' + arrayItem['TQUO_SBJCT']

                    const elFlex = document.createElement('div')
                    elFlex.classList.add(...['d-flex', 'justify-content-between', 'align-items-center'])

                    const elButtonGrup = document.createElement('div')
                    elButtonGrup.classList.add(...['btn-group', 'btn-group-sm'])

                    const elButton1 = document.createElement('button')
                    elButton1.classList.add(...['btn', 'btn-outline-secondary'])
                    elButton1.innerHTML = 'Approve'
                    elButton1.onclick = () => {
                        event.preventDefault()
                        if (confirm('Are you sure ?')) {
                            elButton1.disabled = true
                            $.ajax({
                                type: "PUT",
                                url: `approve/quotations/${btoa(arrayItem['TQUO_QUOCD'])}`,
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                dataType: "json",
                                success: function(response) {
                                    elButton1.disabled = false
                                    loadApprovalList()
                                    showNotificationToApprove()
                                },
                                error: function(xhr, xopt, xthrow) {
                                    elButton1.disabled = false
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

                    const elButton2 = document.createElement('button')
                    elButton2.classList.add(...['btn', 'btn-outline-secondary'])
                    elButton2.innerHTML = 'Preview'
                    elButton2.onclick = () => {
                        event.preventDefault()
                        labelQuotationInModal.innerHTML = arrayItem['TQUO_QUOCD']
                        const myModal = new bootstrap.Modal(document.getElementById('quotationModal'), {})
                        myModal.show()
                        loadQuotationDetail({
                            doc: arrayItem['TQUO_QUOCD']
                        })
                    }

                    const elSmalltext = document.createElement('small')
                    elSmalltext.classList.add('text-body-secondary')
                    elSmalltext.innerText = moment(arrayItem['CREATED_AT']).startOf('hour').fromNow()

                    // combine
                    elButtonGrup.appendChild(elButton1)
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
</script>