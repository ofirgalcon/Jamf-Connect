var formatJCYesNoNice = function(col, row){
    var cell = $('td:eq('+col+')', row),
        value = cell.text()
    value = value == '0' ? mr.label(i18n.t('no'), 'danger') :
        (value === '1' ? mr.label(i18n.t('yes'), 'success') : '')
    cell.html(value)
}

// Filters

var password_current = function(colNumber, d){
    // Look for 'not current' keyword
    if(d.search.value.match(/^password_not_current$/))
    {
        // Add column specific search
        d.columns[colNumber].search.value = '!= 1';
        // Clear global search
        d.search.value = '';
    }

    // Look for 'current' keyword
    if(d.search.value.match(/^password_current$/))
    {
        // Add column specific search
        d.columns[colNumber].search.value = '= 1';
        // Clear global search
        d.search.value = '';
    }
}
