<div id="jamf_connect-tab"></div>

<div id="lister" style="font-size: large; float: right;">
    <a href="/show/listing/jamf_connect/jamf_connect" title="List">
        <i class="btn btn-default tab-btn fa fa-list"></i>
    </a>
</div>
<div id="report_btn" style="font-size: large; float: right;">
    <a href="/show/report/jamf_connect/jamf_connect" title="Report">
        <i class="btn btn-default tab-btn fa fa-th"></i>
    </a>
</div>
<h2><i class="fa fa-link"></i> <span data-i18n="jamf_connect.title"></span></h2>

<table id="jamf_connect-tab-table" style="max-width:475px;"><tbody></tbody></table>


<script>
$(document).on('appReady', function(){
    $.getJSON(appUrl + '/module/jamf_connect/get_data/' + serialNumber, function(data){
        var table = $('#jamf_connect-tab-table');
        $.each(data, function(key,val){
            // Skip empty values
            if (!val && val !== 0) {
                return true;
            }
            var th = $('<th>').text(i18n.t('jamf_connect.column.' + key));
            var td;
            if(key === "password_current" || key === "first_run_done") {
              td = $('<td>').html(val == 1 ? '<span class="label label-success">'+i18n.t('yes')+'</span>' : '<span class="label label-danger">'+i18n.t('no')+'</span>');
            } else {
              td = $('<td>').text(val);
            }
            table.append($('<tr>').append(th, td));
        });
    });
});
</script>

