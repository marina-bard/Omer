'use strict';

$(document).ready(function ($) {
    $('body').find('input.datepicker').addClass('form-control input-inline');

    /**
     * Установка параметров датапикера при фокусе в области инпута, отвечающего за дату
     */
    $('body').on('focus', 'input.datepicker', function () {
        //вытягивает параметры для датапикера из атрибутов инпута
        var startDate = $(this).attr('data-date-start-date'),
            dateFormat = $(this).attr('data-date-format'),
            endDate = $(this).attr('data-date-end-date'),
            dateViewMode = $(this).attr('data-date-view-mode'),
            dateLanguage = $(this).attr('data-date-locale');

        $(this).attr('readonly', true);
        $(this).datetimepicker({
            viewMode: dateViewMode,
            format: dateFormat,
            language: dateLanguage,
            defaultDate: startDate,
            minDate: startDate,
            maxDate: endDate,
            pickTime: false
        }).on('change', function(){
            $('.bootstrap-datetimepicker-widget').hide();
        });
    });
});