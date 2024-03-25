
//Internal Page JS//
jQuery(".hotel-toggle").click(function() {
  jQuery('.hiddenDiv-one').toggle();
});
jQuery("#checkboxid").click(function() {
  jQuery('#autoupdate').toggle(1000);
});

 $('.panel-dropdown .guestspicker').on('click', function(event) {
      $('.panel-dropdown').toggleClass('active');
      event.preventDefault();
    });
    $(window).click(function() {
      $('.panel-dropdown').removeClass('active');
    });
    $('.panel-dropdown').on('click', function(event) {
      event.stopPropagation();
    });
    $(function() {
      $(".plus, .minus").on("click", function() {
        var button = $(this);
        var oldValue = button.parent().find("input").val();
        if (button.hasClass('plus')) {
          
            if(oldValue  < 3){
                 var newVal = parseFloat(oldValue) + 1;
            }
              else{
                var newVal = parseFloat(oldValue);
            }
        } else {
          if (oldValue > 0) {
               if(oldValue  > 1){
            var newVal = parseFloat(oldValue) - 1;
               }
                 else{
                var newVal = parseFloat(oldValue);
            }
          } else {
            newVal = 0;
          }
        }
        button.parent().find("input").val(newVal);
       guest_rooms();
     
      });
});











