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

    $('input#omer_teambundle_team_travelAttributes_0_date').attr('placeholder', 'Arrival Date');
    $('input#omer_teambundle_team_travelAttributes_1_date').attr('placeholder', 'Departure Date');
    $('input#omer_userbundle_directoruser_travelAttributes_0_date').attr('placeholder', 'Arrival Date');
    $('input#omer_userbundle_directoruser_travelAttributes_1_date').attr('placeholder', 'Departure Date');

    // (function () {
    //     var mainForm = $('.main-form'),
    //         loginTab = mainForm.find('.login'),
    //         registrationTab = mainForm.find('.registration'),
    //         registrationButtons = mainForm.find('.registration-buttons'),
    //         loginFields = mainForm.find('.login-fields');
    //
    //     loginTab.on('click', function () {
    //         $(this).addClass('active');
    //         registrationTab.removeClass('active');
    //         registrationButtons.hide();
    //         loginFields.show();
    //     });
    //
    //     registrationTab.on('click', function () {
    //         $(this).addClass('active');
    //         loginTab.removeClass('active');
    //         loginFields.hide();
    //         registrationButtons.show();
    //     });
    // })();

    (function () {
        var mainForm = $('.main-form'),
            loginFields = mainForm.find('.login-fields'),
            loginHref = $('.login-href'),
            loginText = mainForm.find('.login-text');

        loginHref.on('click', function () {
            loginText.hide();
            loginFields.show();
        });
    })();

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

    var preferencesInJudgementRow = $('div#omer_userbundle_directoruser_preferences').closest('.row');
    preferencesInJudgementRow.hide();
    $('#omer_userbundle_directoruser_role').on('change', function(){
        if($(this).val() === 'ROLE_JUDGE')
            preferencesInJudgementRow.show();
        else
            preferencesInJudgementRow.hide();
    });

    if(window.location.href.indexOf("news") !== -1) {
        $('html, body').animate({
            scrollTop: $("#news").offset().top
        }, 500);
    }
});