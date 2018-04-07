// 页面提示
var noticeToUser =function(message,type) {
  $('#update-remind').text(message);
  if ( type == 1 ) {
    $('#update-remind').css('backgroundColor','#7fd67d');
  } else {
    $('#update-remind').css('backgroundColor','#d80202');
  }
  $('#update-remind').slideDown(500);
  window.setTimeout(function(){
    $('#update-remind').slideUp(500);
  },3000);
}
// DOM 准备好之后，如果有待提示的语句，进行提示
$( document ).ready(function() {
  if (localStorage.getItem('remindMessage') ) {
    type = localStorage.getItem('remindType');
    pre_color = $('#update-remind').css('background-color');
    if ( type == 'success' ) {
      $('#update-remind').css({'background-color':'#00a65a'});
      $('#update-remind').text(localStorage.getItem('remindMessage'));
      $('#update-remind').slideDown(500);
      window.setTimeout(function(){
        $('#update-remind').slideUp(500,function(){
          $('#update-remind').css({'background-color':pre_color});
        });
      },3000);
    }
    noticeToUser(localStorage.getItem('remindMessage'),1);
    localStorage.removeItem('remindMessage');
  }
});