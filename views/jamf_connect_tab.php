<div id="jamf_connect-tab"></div>
<h2 data-i18n="jamf_connect.title"></h2>

<table id="jamf_connect-tab-table" style="max-width:475px;"><tbody></tbody></table>


<script>
$(document).on('appReady', function(){
    $.getJSON(appUrl + '/module/jamf_connect/get_data/' + serialNumber, function(data){
        var table = $('#jamf_connect-tab-table');
        $.each(data, function(key,val){
            var th = $('<th>').text(i18n.t('jamf_connect.column.' + key));
            var td;
            if(key === "password_current") {
              td = $('<td>').text(val == 1 ? "Yes" : "No");
              if (val != 1) {
                td.css('color', 'red');
              }
            } else {
              td = $('<td>').text(val);
            }
            table.append($('<tr>').append(th, td));
        });
    });
});
</script>

