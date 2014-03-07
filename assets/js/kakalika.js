var kakalika = {
    addUploadField : function()
    {
        $('#issue-attachments').append($('#upload-field').html());
    }
};

$(function(){
  
  var shownSomething = false;
  
  $(document).click(function(){
    if(typeof shownSomething === 'function'){
      shownSomething();
    }
  });
  
  // Create a new issue menu
  $('#sub-menu').hover(function(){
    $('#sub-menu').css({backgroundColor:'#f0f0f0'});
    $('#sub-sub-menu').css({left:($('#sub-menu').offset().left - ($('#sub-sub-menu').width() - $('#sub-menu').width()))});
    $('#sub-sub-menu').fadeIn('fast');
    shownSomething = function(){
      $('#sub-sub-menu').fadeOut('fast');
      $('#sub-menu').css({backgroundColor:'#fafafa'});
    };
  });
  
});

