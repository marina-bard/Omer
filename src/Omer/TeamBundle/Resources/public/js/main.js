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

    $('a.page-scroll').bind('click', function (event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 50
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });

//убрать после появления рабочих ссылок
    $('#schedule a').on('click', function (e) {
        e.preventDefault();
    });

    $('input#omer_teambundle_team_travelAttributes_0_date').attr('placeholder', 'Arrival Date');
    $('input#omer_teambundle_team_travelAttributes_1_date').attr('placeholder', 'Departure Date');

    $('input[id$="_time"]').mask('AB:CD', {
        translation: {
            'A': {
                pattern: /[0-2]/
            },
            'B': {
                pattern: /[0-9]/
            },
            'C': {
                pattern: /[0-5]/
            },
            'D': {
                pattern: /[0-9]/
            }
        }
    });
});