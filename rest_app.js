$(function() {
    //$.ajaxSetup({ cache: false });
    ajaxSelectAll("rest_response.php", 'tags=all');
    
    $('#but_add_tag').click(function(e) {
        var param = {};
        var tag = $('#add_tag').val();
        param['tag'] = tag;
        ajaxAdd("rest_response.php", JSON.stringify(param));
        e.preventDefault();
    });
    
    $('div.box-content').on('click', 'a.tag-delete', function(e) {
        var id = $(this).parent().parent().attr('class').split('_')[1];
        ajaxDelete("rest_response.php?id=" + id, function() {
            var li = $('li.tagItem_' + id);
            li.remove();
        });
        e.preventDefault();
    })
    
    $('div.box-content').on('click', 'a.tag-edit', function(e) {
        var id = $(this).parent().parent().attr('class').split('_')[1];
        var title = $(this).parent().parent().find('span').text();
        var query = prompt('What would you like to change the tag?', title);
        if (query == '' || query == null) {
            return;//это типа exit() в php
        }
        else {title = query;}
        var param = {};
        param['id'] = id;
        param['title'] = title;
        ajaxUpdate("rest_response.php", JSON.stringify(param), function(data) {
            var span = $('li.tagItem_' + id + ' span');
            var new_title = data.title;
            span.text(new_title);
        });
        e.preventDefault();
    })    
})


//Set of functions

function ajaxSelectAll(url, dataToSave, callback) {
    ajaxModify(url, dataToSave, "GET", "All Tags Retrieved.", function(data) {
        var content = {
            tags: data
        };
        var template = Handlebars.compile($('#template_tags').html());
        $('div.box-content').append(template(content));
    });
}


function ajaxAdd(url, dataToSave, callback) {
    ajaxModify(url, dataToSave, "POST", "Tag Added.", function(data) {
        $('#add_tag').val('');
        var content = {
            info: data
        };
        var template = Handlebars.compile($('#template_tag_record').html());
        $('ul#tags_list').append(template(content)).fadeIn(500);
    });
}


function ajaxUpdate(url, dataToSave, successCallback) {
    ajaxModify(url, dataToSave, "PUT", "Tag Updated.", successCallback);
}


function ajaxDelete(url, successCallback) {
    ajaxModify(url, null, "DELETE", "Tag Deleted.", successCallback);
}


//Base AJAX function
function ajaxModify(url, dataToSave, httpVerb, successMessage, callback) {
    $.ajax(url, {
        data: dataToSave,
        type: httpVerb,
        dataType: 'json',
        contentType: 'application/json',
        success: function(data) {
            //console.log(successMessage);
            if (callback !== undefined) {
                callback(data);
            }
          },
        error: function () {
            console.log('Unexpected error');
        }
    });
}
