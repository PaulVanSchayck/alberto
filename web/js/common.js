

function parseRuleField(field, data, postfix) {

    if (postfix == undefined) {
        postfix = '';
    }

    if (field === false) {
        return false;
    }

    if (field == 'no-data') {
        return 'no-data';
    }

    if (data[field]) {
        return data[field + postfix];
    }
}
