<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Item Master Report</h1>
    <div class="btn-toolbar mb-2 mb-md-0">

    </div>
</div>
<form id="item-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col mb-1" id="div-alert">
            </div>
        </div>        
        <div class="row">
            <div class="col mb-1">
                <div class="btn-group btn-group-sm">                    
                    <button type="button" class="btn btn-outline-primary" id="btnExport" title="Export to spreadsheet file" onclick="btnExportOnclick(this)"><i class="fas fa-file-excel"></i></button>
                </div>
            </div>
        </div>    
    </div>
</form>
<script>
    function btnExportOnclick(p){
        p.disabled = true
        p.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'
        $.ajax({
            type: "GET",
            url: "report/item-master",            
            success: function (response) {                
                const blob = new Blob([response], { type: "application/vnd.ms-excel" })
                const fileName = `Item Master Report.xlsx`
                saveAs(blob, fileName)
                p.innerHTML = '<i class="fas fa-file-excel"></i>'
                p.disabled = false
                alertify.success('Done')
            },
            xhr: function () {
                const xhr = new XMLHttpRequest()
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 2) {
                        if (xhr.status == 200) {
                            xhr.responseType = "blob";
                        } else {
                            p.innerHTML = '<i class="fas fa-file-excel"></i>'
                            p.disabled = false
                            xhr.responseType = "text";
                        }
                    }
                }
                return xhr
            },
        })
    }
</script>