try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.bootstrap = require('bootstrap5');
    window.Swal = require('sweetalert2')
    window.Inputmask = require('inputmask');
    window.ApexCharts = require('apexcharts');
    require( 'datatables.net-bs4' );
    require( 'datatables.net-buttons-bs4' );       
    require( 'datatables.net-responsive-bs4' ); 
    require('select2');
    require('jquery.repeater');
    require('bootstrap-datepicker');
    window.Compressor = require('compressorjs');
    window.ClassicEditor = require('@ckeditor/ckeditor5-build-classic');
 
} catch (e) {}

"use strict";

var identity = function (x) {
    return x;
};

var isArray = function (value) {
    return $.isArray(value);
};

var isObject = function (value) {
    return !isArray(value) && (value instanceof Object);
};

var isNumber = function (value) {
    return value instanceof Number;
};

var isFunction = function (value) {
    return value instanceof Function;
};

var indexOf = function (object, value) {
    return $.inArray(value, object);
};

var inArray = function (array, value) {
    return indexOf(array, value) !== -1;
};

var foreach = function (collection, callback) {
    for(var i in collection) {
        if(collection.hasOwnProperty(i)) {
            callback(collection[i], i, collection);
        }
    }
};


var last = function (array) {
    return array[array.length - 1];
};

var argumentsToArray = function (args) {
    return Array.prototype.slice.call(args);
};

var extend = function () {
    var extended = {};
    foreach(argumentsToArray(arguments), function (o) {
        foreach(o, function (val, key) {
            extended[key] = val;
        });
    });
    return extended;
};

var mapToArray = function (collection, callback) {
    var mapped = [];
    foreach(collection, function (value, key, coll) {
        mapped.push(callback(value, key, coll));
    });
    return mapped;
};

var mapToObject = function (collection, callback, keyCallback) {
    var mapped = {};
    foreach(collection, function (value, key, coll) {
        key = keyCallback ? keyCallback(key, value) : key;
        mapped[key] = callback(value, key, coll);
    });
    return mapped;
};

var map = function (collection, callback, keyCallback) {
    return isArray(collection) ?
        mapToArray(collection, callback) :
        mapToObject(collection, callback, keyCallback);
};

var pluck = function (arrayOfObjects, key) {
    return map(arrayOfObjects, function (val) {
        return val[key];
    });
};

var filter = function (collection, callback) {
    var filtered;

    if(isArray(collection)) {
        filtered = [];
        foreach(collection, function (val, key, coll) {
            if(callback(val, key, coll)) {
                filtered.push(val);
            }
        });
    }
    else {
        filtered = {};
        foreach(collection, function (val, key, coll) {
            if(callback(val, key, coll)) {
                filtered[key] = val;
            }
        });
    }

    return filtered;
};

var call = function (collection, functionName, args) {
    return map(collection, function (object, name) {
        return object[functionName].apply(object, args || []);
    });
};

//execute callback immediately and at most one time on the minimumInterval,
//ignore block attempts
var throttle = function (minimumInterval, callback) {
    var timeout = null;
    return function () {
        var that = this, args = arguments;
        if(timeout === null) {
            timeout = setTimeout(function () {
                timeout = null;
            }, minimumInterval);
            callback.apply(that, args);
        }
    };
};


var mixinPubSub = function (object) {
    object = object || {};
    var topics = {};

    object.publish = function (topic, data) {
        foreach(topics[topic], function (callback) {
            callback(data);
        });
    };

    object.subscribe = function (topic, callback) {
        topics[topic] = topics[topic] || [];
        topics[topic].push(callback);
    };

    object.unsubscribe = function (callback) {
        foreach(topics, function (subscribers) {
            var index = indexOf(subscribers, callback);
            if(index !== -1) {
                subscribers.splice(index, 1);
            }
        });
    };

    return object;
};

$.fn.repeater = function (fig) {
    fig = fig || {};

    var setList;

    $(this).each(function () {

        var $self = $(this);

        var show = fig.show || function () {
            $(this).show();
        };

        var hide = fig.hide || function (removeElement) {
            removeElement();
        };

        var $list = $self.find('[data-repeater-list]').first();

        var $filterNested = function ($items, repeaters) {
            return $items.filter(function () {
                return repeaters ?
                    $(this).closest(
                        pluck(repeaters, 'selector').join(',')
                    ).length === 0 : true;
            });
        };

        var $items = function () {
            return $filterNested($list.find('[data-repeater-item]'), fig.repeaters);
        };

        var $itemTemplate = $list.find('[data-repeater-item]')
                                .first().clone().hide();

        var $firstDeleteButton = $filterNested(
            $filterNested($(this).find('[data-repeater-item]'), fig.repeaters)
            .first().find('[data-repeater-delete]'),
            fig.repeaters
        );

        if(fig.isFirstItemUndeletable && $firstDeleteButton) {
            $firstDeleteButton.remove();
        }

        var getGroupName = function () {
            var groupName = $list.data('repeater-list');
            return fig.$parent ?
                fig.$parent.data('item-name') + '[' + groupName + ']' :
                groupName;
        };

        var initNested = function ($listItems) {
            if(fig.repeaters) {
                $listItems.each(function () {
                    var $item = $(this);
                    foreach(fig.repeaters, function (nestedFig) {
                        $item.find(nestedFig.selector).repeater(extend(
                            nestedFig, { $parent: $item }
                        ));
                    });
                });
            }
        };

        var $foreachRepeaterInItem = function (repeaters, $item, cb) {
            if(repeaters) {
                foreach(repeaters, function (nestedFig) {
                    cb.call($item.find(nestedFig.selector)[0], nestedFig);
                });
            }
        };

        var setIndexes = function ($items, groupName, repeaters) {
            $items.each(function (index) {
                var $item = $(this);
                $item.data('item-name', groupName + '[' + index + ']');
               

                $filterNested($item.find('[id]'), repeaters)
                .each(function () {
                    var $input = $(this);
                    // match non empty brackets (ex: "[foo]")
                    var matches = $input.attr('id').match(/\[[^\]]+\]/g);

                    var name = matches ?
                        // strip "[" and "]" characters
                        last(matches).replace(/\[|\]/g, '') :
                        $input.attr('id');


                    var newName = groupName + '[' + index + '][' + name + ']' +
                        ($input.is(':checkbox') || $input.attr('multiple') ? '[]' : '');

      
                    $input.attr('id', newName);
 
                    $foreachRepeaterInItem(repeaters, $item, function (nestedFig) {
                        var $repeater = $(this);
                        setIndexes(
                            $filterNested($repeater.find('[data-repeater-item]'), nestedFig.repeaters || []),
                            groupName + '[' + index + ']' +
                                        '[' + $repeater.find('[data-repeater-list]').first().data('repeater-list') + ']',
                            nestedFig.repeaters
                        );
                    });
                });


                $filterNested($item.find('[for]'), repeaters)
                .each(function () {
                    var $input = $(this);
                    // match non empty brackets (ex: "[foo]")
                    var matches = $input.attr('for').match(/\[[^\]]+\]/g);

                    var name = matches ?
                        // strip "[" and "]" characters
                        last(matches).replace(/\[|\]/g, '') :
                        $input.attr('for');


                    var newName = groupName + '[' + index + '][' + name + ']' +
                        ($input.is(':checkbox') || $input.attr('multiple') ? '[]' : '');

      
                    $input.attr('for', newName);
 
                    $foreachRepeaterInItem(repeaters, $item, function (nestedFig) {
                        var $repeater = $(this);
                        setIndexes(
                            $filterNested($repeater.find('[data-repeater-item]'), nestedFig.repeaters || []),
                            groupName + '[' + index + ']' +
                                        '[' + $repeater.find('[data-repeater-list]').first().data('repeater-list') + ']',
                            nestedFig.repeaters
                        );
                    });
                });
               
                $filterNested($item.find('[name]'), repeaters)
                .each(function () {
                    var $input = $(this);
                    // match non empty brackets (ex: "[foo]")
                    var matches = $input.attr('name').match(/\[[^\]]+\]/g);

                    var name = matches ?
                        // strip "[" and "]" characters
                        last(matches).replace(/\[|\]/g, '') :
                        $input.attr('name');


                    var newName = groupName + '[' + index + '][' + name + ']' +
                        ($input.is(':checkbox') || $input.attr('multiple') ? '[]' : '');

      
                    $input.attr('name', newName);
 
                    $foreachRepeaterInItem(repeaters, $item, function (nestedFig) {
                        var $repeater = $(this);
                        setIndexes(
                            $filterNested($repeater.find('[data-repeater-item]'), nestedFig.repeaters || []),
                            groupName + '[' + index + ']' +
                                        '[' + $repeater.find('[data-repeater-list]').first().data('repeater-list') + ']',
                            nestedFig.repeaters
                        );
                    });
                });

            });

            $list.find('input[name][checked]')
                .removeAttr('checked')
                .prop('checked', true);
        };

        setIndexes($items(), getGroupName(), fig.repeaters);
        initNested($items());
        if(fig.initEmpty) {
            $items().remove();
        }

        if(fig.ready) {
            fig.ready(function () {
                setIndexes($items(), getGroupName(), fig.repeaters);
            });
        }

        var appendItem = (function () {
            var setItemsValues = function ($item, data, repeaters) {
                if(data || fig.defaultValues) {
                    var inputNames = {};
                    $filterNested($item.find('[name]'), repeaters).each(function () {
                        var key = $(this).attr('name').match(/\[([^\]]*)(\]|\]\[\])$/)[1];
                        inputNames[key] = $(this).attr('name');
                    });

                    $item.inputVal(map(
                        filter(data || fig.defaultValues, function (val, name) {
                            return inputNames[name];
                        }),
                        identity,
                        function (name) {
                            return inputNames[name];
                        }
                    ));
                }


                $foreachRepeaterInItem(repeaters, $item, function (nestedFig) {
                    var $repeater = $(this);
                    $filterNested(
                        $repeater.find('[data-repeater-item]'),
                        nestedFig.repeaters
                    )
                    .each(function () {
                        var fieldName = $repeater.find('[data-repeater-list]').data('repeater-list');
                        if(data && data[fieldName]) {
                            var $template = $(this).clone();
                            $repeater.find('[data-repeater-item]').remove();
                            foreach(data[fieldName], function (data) {
                                var $item = $template.clone();
                                setItemsValues(
                                    $item,
                                    data,
                                    nestedFig.repeaters || []
                                );
                                $repeater.find('[data-repeater-list]').append($item);
                            });
                        }
                        else {
                            setItemsValues(
                                $(this),
                                nestedFig.defaultValues,
                                nestedFig.repeaters || []
                            );
                        }
                    });
                });

            };

            return function ($item, data) {
                $list.append($item);
                setIndexes($items(), getGroupName(), fig.repeaters);
                $item.find('[name]').each(function () {
                    $(this).inputClear();
                });
                setItemsValues($item, data || fig.defaultValues, fig.repeaters);
            };
        }());

        var addItem = function (data) {
            var $item = $itemTemplate.clone();
            appendItem($item, data);
            if(fig.repeaters) {
                initNested($item);
            }
            show.call($item.get(0));
        };

        setList = function (rows) {
            $items().remove();
            foreach(rows, addItem);
        };

        $filterNested($self.find('[data-repeater-create]'), fig.repeaters).click(function () {
            addItem();
        });

        $list.on('click', '[data-repeater-delete]', function () {
            var self = $(this).closest('[data-repeater-item]').get(0);
            hide.call(self, function () {
                $(self).remove();
                setIndexes($items(), getGroupName(), fig.repeaters);
            });
        });
    });

    this.setList = setList;

    return this;
};

(function( $ ) {
 
    $.fn.act = function(options) {
        var act = {};
        
        var settings = $.extend({ 
            headers : {}, 
            respond : function(act, element, json){},
            init : function(act, element, json){}
        }, options);

        act.loading = function (element, status){
            if(status === true){

                $(element).addClass('processing');
                $('[type="submit"]', element).prop('disabled', true);

            }else{

                $(element).removeClass('processing');
                $('[type="submit"]', element).prop('disabled', false);
            }
        }

        act.respond = function(element, json){
 
            if (json.errors) {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                $.each(json.errors, function (name, errors) {
                    var nameSplit = name.split('.');
                    var field = nameSplit.length == 1 ? name : (nameSplit[0] + '[' + nameSplit.splice(1).join('][') + ']');
                    $("[name='" + field + "']", element).addClass("is-invalid");
                    $("[name='" + field + "']", element).closest('div').append( $('<div/>').addClass('invalid-feedback').html(errors[0]));
                    $("[name='" + field + "']", element).closest('div').find('.invalid-feedback').show();
                    $("[name='" + field + "']", element).on('change', function(){
                        $(this).removeClass('is-invalid').closest('div').find('.invalid-feedback').remove();
                    });
                });
            }
 
            if (json.jquery) {
                if (json.jquery.element && json.jquery.method) {
                  if (json.jquery.value) {
                    if (Array.isArray(json.jquery.value)) {
                      $(json.jquery.element)[json.jquery.method](...json.jquery.value);
                    } else {
                      $(json.jquery.element)[json.jquery.method](json.jquery.value);
                    }
                  } else {
                    $(json.jquery.element)[json.jquery.method]();
                  }
                } else {
                  $.each(json.jquery, function (index, uiTarget) {
                    if (uiTarget.element && uiTarget.method) {
                      if (uiTarget.value) {
                        if (Array.isArray(uiTarget.value)) {
                          $(uiTarget.element)[uiTarget.method](...uiTarget.value);
                        } else {
                          $(uiTarget.element)[uiTarget.method](uiTarget.value);
                        }
                      } else {
                        $(uiTarget.element)[uiTarget.method]();
                      }
                    }
                  });
                }
            }
 
            settings.respond(act,element, json);

            if (json.alert) {
                let swalconfig = {
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000,
                }

                Object.assign(swalconfig, json.alert)

                Swal.fire(swalconfig).then(function(result) {
                    if(json.alert.redirect){
                        window.location.href = json.alert.redirect;
                    } 
                });
            }  

 
            if (json.init) {
                $.each(json.init, function (index, element) {
                    $(element).act(settings);
                });
            }

            if (json.redirect) {
                window.location.href = json.redirect;
            }

            if (json.reload) {
                location.reload()
            }

        };

        act.request = function (element, url, data) {

            function compress(file) {
                return new Promise((resolve, reject) => {
                   new Compressor(file, {
                     quality: 1,
                     success: resolve,
                     error: reject
                  });
               });
            }
         
            async function asyncCall(element, url, data) {

                var imageCompress = $(element).attr('act-image-compress');
                if(imageCompress){

                    if(imageCompress.includes(', ')){
                        var images = imageCompress.split(', ');
                    }else{
                        var images = [];
                        images.push( imageCompress );
                    }

                    async function asyncForEach(array, callback) {
                        for (let index = 0; index < array.length; index++) {
                          await callback(array[index], index, array);
                        }
                    }
    
                    await asyncForEach(images, async (item, index) => {
                        var imageData = data.get(item);
                        if(imageData.name){
                            let result = await compress(imageData);
                            data.delete(item)
                            data.append(item, result, result.name);
                        }
                    })
                }
 
                act.loading(element, true);
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                
                $.ajax({
                    headers : settings.headers,
                    url: url,
                    type: 'post',
                    data: data,
                    cache:false,
                    contentType: false,
                    processData: false
                }).done(function (json) {
    
                    act.respond(element, json);
    
                    act.loading(element, false);
    
                }).fail(function (jqXHR, textStatus) {  
    
                    if(jqXHR.status == 422){
                        act.respond(element, jqXHR.responseJSON);
                    }
    
                    if($(element).attr("act-respond") && $(element).attr("act-request")){ 
                        let respond = $(element).attr('act-respond');  
                        try {
                            act.respond(element, JSON.parse(respond));
                        }catch(err) {
                            if($(element).attr('name')){
                                console.error('Invalid input ' + $(element).attr('name') + ' act-respond json');
                                console.error(err);
                            }else{
                                console.error(err);
                            }
                        }
                    }
                    
                    act.loading(element, false);
                });
            }
            
            asyncCall(element, url, data);
        };

        act.on = function(element, action){
            let data = false;
            if(action == 'submit'){
                data = new FormData(element);
            }else{
                data = new FormData();

                if($(element).val()){
                    data.append('value', $(element).val());
                }
            }

            $.each(element.attributes, function() {
                data.append(this.name, this.value);
            });

            if($(element).attr("act-with")){  
                
                let actWith = $(element).attr("act-with");

                $(element).closest('[act-group="' + actWith + '"]').find('[act-related="' + actWith + '"]').each(function(){
                    if( $(element).attr('name') != $(this).attr('name') ){
                        data.append('related[' + $(this).attr('name') + ']', $(this).val());
                    }
                });
            }

            if($(element).attr("act-request")){     
                let request = $(element).attr('act-request');
                act.request(element, request, data)
            }

            if($(element).attr("act-respond") && !$(element).attr("act-request")){      
                let respond = $(element).attr('act-respond');  
                try {
                    act.respond(element, JSON.parse(respond));
                }catch(err) {
                    if($(element).attr('name')){
                        console.error('Invalid input ' + $(element).attr('name') + ' act-respond json');
                        console.error(err);
                    }else{
                        console.error(err);
                    }
                }
            }
        }

        $('[act-on]', this).each(function(){
            let action =  $(this).attr('act-on');
 
            if(action == 'load'){
                act.on(this, action)
            }

            $(this).on(action, function(event){
                event.preventDefault();

                if( $(this).attr('act-confirm') ){

                    Swal.fire({
                        title: 'Are you sure?',
                        text: $(this).attr('act-confirm'),
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#663259',
                        cancelButtonColor: '#f64e60',
                        confirmButtonText: 'Yes, Proceed'
                      }).then((result) => {
                            if(result.isConfirmed){
                                act.on(this, action)
                            }   
                      });

                }else{
                    act.on(this, action)
                }
                
            });
        });

        settings.init(act, this);
    };
 
}( jQuery ));