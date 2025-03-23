var formatJCYesNoNice = function(col, row){
    var cell = $('td:eq('+col+')', row),
        value = cell.text()
    // Convert to string and trim to handle any whitespace
    value = String(value).trim()
    // Convert to number for comparison
    var numValue = parseInt(value, 10)
    // Use numeric comparison
    value = numValue === 1 ? mr.label(i18n.t('yes'), 'success') : mr.label(i18n.t('no'), 'danger')
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
