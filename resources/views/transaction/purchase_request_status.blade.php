<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Purchase Request Status</h1>
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
<script>
    function loadApprovalList() {
        approvalContainer.innerHTML = 'Please wait'
        $.ajax({
            type: "GET",
            url: "/approval/purchase-request",
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
                    <title>Request type</title>
                    <rect width="100%" height="100%" fill="#188273" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">${arrayItem['MPCHREQTYPE_NAME']}</text>
                    </svg>`
                    const elCardBody = document.createElement('div')
                    elCardBody.classList.add('card-body')
                    const elCardBodyText = document.createElement('p')
                    elCardBodyText.classList.add('card-text')
                    elCardBodyText.innerHTML = '<b>' + arrayItem['TPCHREQ_PCHCD'] + '</b><br>' + arrayItem['TPCHREQ_PURPOSE']

                    const elCardBodyText2 = document.createElement('p')
                    let quotationStatus = 0
                    elCardBodyText2.classList.add('card-text')
                    if (!arrayItem['TPCHREQ_APPRVDT'] && !arrayItem['TPCHREQ_REJCTDT'] && arrayItem['TPCHREQ_TYPE'] == '2') {
                        // Jika PR "Auto PO" dan belum di-approve ataupun di-reject
                        elCardBodyText2.innerHTML = '<span class="badge bg-warning">Being reviewed</span>'
                    } else {
                        if (arrayItem['TPCHREQ_TYPE'] == '1') {
                            // Jika PR "Normal", bisa langsung konversi ke PO
                            quotationStatus = 1
                        } else {
                            if (arrayItem['TPCHREQ_APPRVDT']) {
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

                    if (quotationStatus === 1 && arrayItem['TPCHREQ_TYPE'] == '1') {
                        const elButton2 = document.createElement('button')
                        elButton2.classList.add(...['btn', 'btn-outline-primary'])
                        elButton2.innerHTML = 'Create Purchase Order'
                        elButton2.onclick = () => {
                            event.preventDefault()
                            ContentContainer.innerHTML = 'Please wait'
                            $.ajax({
                                type: "GET",
                                url: 'purchase-order/form',
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
            url: `purchase-request/${btoa(data.doc)}`,
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
                    newcell.innerHTML = arrayItem['TPCHREQDETA_ITMCD']
                    newcell = newrow.insertCell(2)
                    newcell.innerHTML = arrayItem['MITM_ITMNM']
                    newcell = newrow.insertCell(3)
                    newcell.classList.add('text-end')
                    newcell.innerHTML = arrayItem['TPCHREQDETA_ITMQT']
                    newcell = newrow.insertCell(4)
                    newcell.classList.add('text-center')
                    newcell.innerHTML = arrayItem['TPCHREQDETA_REQDT']
                    newcell = newrow.insertCell(5)
                    newcell.innerHTML = arrayItem['TPCHREQDETA_REMARK']
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