require('./bootstrap');
window.app = {};
"use strict";
$(function() {

    app.datatable = {}

    app.datatable.tables = [];

    app.reset = function(element){
        $('form', element).trigger('reset');
        $('.select2', element).trigger('change');
        $('.custom-file-label', element).html('Choose file');
        $('[reset-src]', element).each(function( index ) {
            $(this).attr('src', $(this).attr('reset-src'));
        });
    }

    var config = {
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        respond : function(act, element, json){
            if (json.datatable) {
                if(json.datatable.reload){
                    $.each(app.datatable.tables, function (index, table) {
                        table.draw();
                    });
                }
            }

            if (json.reset) {
                app.reset();
            }

            if (json.modal) {
                if(json.modal.hide){
                    $(json.modal.hide).modal('hide');
                }
                if(json.modal.show){
                    $(json.modal.show).modal('show');
                }
            }
        },
        init : function(act, element){
            $('[type="submit"]', element).prop('disabled', false);
            $('.select2', element).select2();

            Inputmask({ placeholder: '' }).mask( $('.input-mask'));

            $('.datepicker').datepicker({
                'format' : 'yyyy-mm-dd'
            });

            $('[data-bs-toggle="tooltip"]').on('mouseover', function () {
                $(this).tooltip({ trigger: 'manual' }).tooltip('show');
            });

            $('[data-bs-toggle="tooltip"]').on('mouseleave', function () {
                $(this).tooltip({ trigger: 'manual' }).tooltip('hide');
            });

            $('.editor', element).each(function () {
                let editorFor = $(this).attr('for');

                ClassicEditor
                .create( this ,{
                    toolbar: {
                      items: [
                        'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|','|','undo', 'redo'
                      ]
                    },
                    table: {
                      contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
                    },
                    language: 'en'
                  })
                .then( editor => {
                    var editor  = editor;
                    editor.ui.focusTracker.on( 'change:isFocused', ( evt, name, isFocused ) => {
                        if ( !isFocused ) {
                            $( "[name='" + editorFor + "']").val(editor.getData());
                        }
                    } );
                } )
                .catch( err => {
                    console.error( err.stack );
                });
            });

            $('.custom-file-input', element).change(function(e){
                if (e.target.files && e.target.files[0]) {
                    var reader = new FileReader();
                    var target = $(this).closest('.custom-file');
                    target.find('.custom-file-label').html(e.target.files[0].name);
                    reader.onload = function(e) {
                        target.find('.custom-file-preview').attr('src', e.target.result);
                        target.find('.custom-file-preview').hide().fadeIn(650);
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            $('[slug-generate]', element).on('change', function(){
                event.preventDefault();
                let element =  $(this).attr('slug-generate');
                let value   =  $(this).val();

                value = value.replace(/^\s+|\s+$/g, ''); // trim
                value = value.toLowerCase();

                // remove accents, swap ñ for n, etc
                var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
                var to   = "aaaaeeeeiiiioooouuuunc------";
                for (var i=0, l=from.length ; i<l ; i++) {
                    value = value.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }

                value = value.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes

                $(element).val(value);
            });

        }
    }

    $('html').act(config);

    $('[act-datatable]').each(function () {

        var datatableElement = $(this);
        var datatableUrl = $(this).attr("act-datatable");
        var datatableSort = $(this).attr("act-sort");

        if(datatableSort){
            datatableSort = JSON.parse(datatableSort);
        }else{
            datatableSort = [[ 0, "desc"]];
        }

        var datatableSearch = $(this).attr("search");
        var columns = [];
        var count = $('thead tr th', datatableElement).length;
        $('thead tr th', datatableElement).each(function (i) {
            var nameAttr = $(this).attr('name');
            var responsivePriority = $(this).attr('priority');

            if(responsivePriority === 'undefined'){
                responsivePriority = 0;
            }

            columns.push({
            'data': nameAttr,
            'name': nameAttr,
            'responsivePriority': responsivePriority
            });

            if (i + 1 === count) {
            var datatableObj = datatableElement.DataTable({
                processing: true,
                serverSide: true,
                bLengthChange: false,
                responsive: true,
                autoWidth: false,
                iDisplayLength: 10,
                order: datatableSort,
                searchDelay: 1000,
                oSearch: {
                'sSearch': $(datatableSearch).val()
                },
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: datatableUrl,
                    data : function ( d ) {

                        $('.datatable-fliter').each(function () {
                            d[$(this).attr('name')] = $(this).val();
                        });

                    },
                    type: 'POST',
                    error: function error(jqXHR, textStatus, errorThrown) {
                        $('.dataTables_processing').hide();
                    }
                },
                drawCallback: function (settings) {
                   $('#' + settings.sTableId).act(config);

                   $('.dtlink .view-btn').each(function() {
                        let link = $( this ).attr('href');
                        $(this).closest('tr').find('td:not(:first-child)').click(function(){
                            window.location.href = link;
                        });
                  });

                },
                columns: columns,
                aaSorting: [[0, 'desc']],
            });

            if (datatableSearch) {
                $(datatableSearch).on('change, keyup', function (e) {
                    if(e.which == 13) {
                        datatableObj.search($(this).val()).draw();
                    }
                });
            }

            $('.datatable-fliter').on('change', function () {
                datatableObj.draw();
            });

            app.datatable.tables.push(datatableObj);
            }
        });

    });

    $('.repeater').each(function (){

        let initEmpty = false;
        if($(this).attr('data-init-empty') == 'true'){
            initEmpty = true;
        }
        $(this).repeater({
            initEmpty: initEmpty,
            show: function () {
                $(this).act(config);
                $(this).slideDown();

                $('.repeater-item:last .custom-file .preview img').each(function (){
                    $(this).attr('src', $(this).attr('default-src'));
                });
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },
            repeaters: [{
                selector: '.inner-repeater',
                show: function () {
                    $(this).act(config);
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                },
                isFirstItemUndeletable: true
            }],
            isFirstItemUndeletable: true
        });

    });


    var current = window.location.href;
    var origin = window.location.origin;
    var linkcount = $('.nav-item .nav-link').length;

    $("[href='" +  current +"']").addClass('active')
    $("[href='" +  current +"']").closest('.nav-item').addClass('active');

    if($("[href='" +  current +"']").length == 0){
        $('.nav-item .nav-link').each(function(i){
            var $this  = $(this);

            if(current.indexOf($this.attr('href')) !== -1){
                if( $this.attr('href').length <= current.length ){
                    if($this.attr('href').replace(origin,'')){
                        $("[href='" +  $this.attr('href').replace(current,'') +"']").addClass('active')
                        $("[href='" +  $this.attr('href').replace(current,'') +"']").closest('.nav-item').addClass('active');
                    }
                 }
            }

            if (i+1 === linkcount) {
                if(! $('.menu-item .nav-item').hasClass('active') ){
                    $("[data-bs-target='#navigation']").closest('.nav-item').addClass('active');
                }
            }
        });
    }else{
        if(! $('.menu-item .nav-item').hasClass('active') ){
            $("[data-bs-target='#navigation']").closest('.nav-item').addClass('active');
        }
    }


    setInterval(function(){
      let now = new Date();
      let hours = now.getHours();
      let minutes = now.getMinutes();
      let seconds = now.getSeconds();

      let drawSeconds = ((seconds / 60) * 360) + 90;
      let drawMinutes = ((minutes / 60) * 360) + 90;
      let drawHours = ((hours / 12) * 360) + 90;

      if (drawSeconds === 444 || drawSeconds === 90) {
        $('.clock .hours').css('transition', "all 0s ease 0s");
      } else {
        $('.clock .hours').css('transition', "all 0.05s cubic-bezier(0, 0, 0.52, 2.51) 0s");
      }

      $('.clock .hours').css('transform', "rotate("+  drawHours  +"deg)");
      $('.clock .minutes').css('transform', "rotate("+ drawMinutes +"deg)");
      $('.clock .seconds').css('transform', "rotate("+ drawSeconds +"deg)");

      $('.clock .hand').show();
    }, 1000);
});


