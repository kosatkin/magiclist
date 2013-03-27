/**
 * Created with JetBrains PhpStorm.
 * User: Стас
 * Date: 22.03.13
 * Time: 23:13
 */

var timestamp = 0;
var isSend = false;

$(document).ready(function(){
  list_startup();
  event_startup();
});

function event_startup()
{
  // Посылаем запросы с проверкой изменения базы
  if(!isSend)
  {
    isSend = true;
    $.ajax({
      url: '?page=event',
      type: 'POST',
      dataType: 'json',
      data: {timestamp: timestamp},
      success: function(response){
        isSend = false;
        if(response.timestamp){
          timestamp = response.timestamp;
          $('.content').html('Refresh...');
          $.ajax({
            url: document.location.href,
            type: 'GET',
            success: function(resp){
              $('.content').html(resp);
              list_startup();
            }
          });
        }
        event_startup();
      }
    });
  }
}

function list_startup()
{
  $('.edit-action').click(function(){
    $('.content').html('Loading...');
    $.ajax({
      url: this.href,
      type: 'GET',
      success: function(response){
        $('.content').html(response);
        edit_startup();
      }
    });
    event_startup();
    return false;
  });

  $('.delete-action').click(function(){
    $('.content').html('Loading...');
    $.ajax({
      url: this.href,
      type: 'GET',
      success: function(response){
        console.log(response);
        var result = $.parseJSON( response );
        if(result.status == 'success')
        {
          $.ajax({
            url: document.location.href,
            type: 'GET',
            success: function(response){
              $('.content').html(response);
              list_startup();
            }
          });
        }
      }
    });
    return false;
  });
}

function edit_startup()
{
  $('#hide').click(function(){
    $('.content').html('Loading...');
    $.ajax({
      url: document.location.href,
      type: 'GET',
      success: function(response){
        $('.content').html(response);
        list_startup();
      }
    });
    return false;
  });

  $('#submit').click(function(){
    var len = $('#edit-form input').length;
    var formData = {};
    for(var i=0;i<len;i++)
    {
      var key = $('#edit-form input').eq(i).attr('name');
      formData[key] = $('#edit-form input').eq(i).val();
    }
    var actionUrl = $('#edit-form').attr('action');
    $('.content').html('Loading...');
    $.ajax({
      url: actionUrl,
      type: 'POST',
      data: formData,
      dataType: 'json',
      complete: function(response) {
        if(response.readyState == 4)
        {
          if(response.statusText == 'OK')
          {
            $.ajax({
              url: '/',
              type: 'GET',
              success: function(response){
                $('.content').html(response);
                list_startup();
              }
            });
          }
        }
      }

    });

    return false;
  });
}