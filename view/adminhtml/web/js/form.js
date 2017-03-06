require([
    "jquery",
    'mage/template'
], function ($, mageTemplate) {

    $('#addBtn').click(function () {
        var progressTmpl = mageTemplate('#customer-template'),
            tmpl;
        tmpl = progressTmpl({
            data: {
                name: this['name'],
                salary: this['salary'],
                location: this['location'],
            }
        });
        $('#config-container').after(tmpl);
    });
});