<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Approval List</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="coa-form">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3" id="approvalContainer">

        </div>
    </div>
</form>
<script>
    function loadApprovalList() {
        $.ajax({
            type: "GET",
            url: "/approval/quotation",
            dataType: "json",
            success: function(response) {
                let innerHTML = ''
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

                    const elButton2 = document.createElement('button')
                    elButton2.classList.add(...['btn', 'btn-outline-secondary'])
                    elButton2.innerHTML = 'Preview'

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
            }
        });
    }
    loadApprovalList()
</script>