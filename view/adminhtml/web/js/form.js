define([
    "jquery",
    'mage/template'
], function ($, mageTemplate) {
    'use strict';

    return function (config) {

        var redirectConfiguration = {
            configContainer: $('#config-container'),
            configTemplate: mageTemplate('#config-template'),
            rowCount: 0,

            appendRow: function (data) {
                var isNewRow = false;

                if (typeof data.store == 'undifined') {
                    isNewRow = true;
                }

                var row_number = ++this.rowCount;

                var progressTmpl = this.configTemplate({
                    data: {
                        'row_number': row_number
                    }
                });

                this.configContainer.append(progressTmpl);

                if (!isNewRow) {
                    $('#countries_' + row_number).val(data.countries);
                    $('#store_' + row_number).val(data.store);
                }
            },

            renderData: function (data) {
                var self = this;
                $.each(data, function (index, value) {
                    self.appendRow({"store": index, "countries": value});
                });
            },
            removeRow: function (event) {
                var element = event.currentTarget;
                element.closest('tr').remove();
            }
        };


        $(document).ready(function () {
            redirectConfiguration.renderData(config.data);
        });

        $('#addBtn').on('click', function () {
            redirectConfiguration.appendRow({});
        });

        $(document).on('click', 'button.delete', function (event) {
            redirectConfiguration.removeRow(event);
        })
    };
});