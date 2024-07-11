<script>
    var app_url = window.location.origin
    $(document).ready(function() {

        $('.panel-dropdown .guestspicker').on('click', function(event) {
      $('.panel-dropdown').toggleClass('active');
      event.preventDefault();
    });

        // search suggestion for home page
        $("#location_search").keyup(function() {
            let keyword=$(this).val();
            $.ajax({
                url: `${app_url}/location-search`,
                data: {
                    'keyword': keyword,
                },
                success: function(data) {
                    let html = '<ul class="custom-scrollbar">';
                    data.forEach(function(value, index) {

                        if (value.type=='hotel') {
                                 icon =
                            ' <i class="fas fa-home" style="top:3px!important;margin-left:2px;font-size:18px;"></i>'
                        }else{
                            icon =`<i class="fas fa-map-marker-alt" style="top:3px!important;margin-left:2px;font-size:18px;"></i>`;
                        }
                                html+=`<li class="my-1 pb-1">
                                    <a href="#"  class="my-0 py-0" data-name="${value.name}" data-id="${value.id}" data-slug="${value.slug}" data-type="${value.type}">
                                    <span>
                                    ${value.name}</span>
                                    <a class="my-0 py-0 px-4 custom-fs-12 w-75 text-capitilize" ><small>${value.address.substr(0,50)}</small>
                                    </a>
                                    <a class="my-0 py-0 custom-fs-12 text-capitilize"><small>${value.count!=0?value.count+' Properties':''} </small>
                                    </a>
                                    </a>
                                    <a href="" class="text-capitilize">${value.type}  <span>
                                   ${icon} </span>
                                    </a>
                                 </li>`;


                    });
                    html += '</ul>';

                    $('.search-result').html(html);
                    $('.search-suggestions').fadeIn();

                },
                error: function(e) {
                    console.log(e);
                }
            });
        });


        $(document).on('click', '.search-result li a', function (e) {
                e.preventDefault();
                let id = e.currentTarget.getAttribute('data-id');
                let slug = e.currentTarget.getAttribute('data-slug');
                let type = e.currentTarget.getAttribute('data-type');
                let name = e.currentTarget.getAttribute('data-name');


                if (type=='hotel') {
                    location.href = app_url + '/hotels/' + slug;
                } else {
                        $('#search_type').val(type);
                        $('#search_id').val(id);
                }
                $('input[name="location_search"]').val(name);
                $('.search-suggestions').hide();
                $('#serach_form_btn').attr('disabled',false)
            });



        let room = sessionStorage.getItem("room");
        if (room && room !== 'undefined') {
            $('#room').html(parseInt(room));
            if (room <= 5) {
                for (let index = 0; index <= room; index++) {
                    $(`#room${index}`).removeClass('d-none');
                }
            }
        }
        budget = sessionStorage.getItem("budget");
        if (budget && budget !== 'undefined') {
            $('#budget').val(budget);
        }
        guest = sessionStorage.getItem("guest");
        if (guest) {
            $('.gueststotal').text(guest);
        }
        var date = new Date();
        var end_date = (moment(date).add(1, 'days'));
        start_date_db = sessionStorage.getItem("start_date");
        start_end_db = sessionStorage.getItem("end_date");
        if (start_date_db != null && start_end_db != null) {
            var date = new Date(start_date_db);
            var end_date = new Date(start_end_db);
        }

        $('#checkInOut').daterangepicker({
            "minDate": new Date(),
            "autoUpdateInput": true,
            "autoApply": true,
            "parentEl": "datecontiner",
            "startDate": moment(date),
            "endDate": end_date,
        }, function(start, end, label) {
            // console.log('New date range selected: ' + start.format('DD/MM/YYYY') + ' to ' + end.format('DD/MM/YYYY') + ' (predefined range: ' + label + ')');
            sessionStorage.setItem("start_date", start.format('D MMMM, YYYY'));
            sessionStorage.setItem("end_date", end.format('D MMMM, YYYY'));
        });
    });

    // prevent from submit search form
    $(document).ready(function() {
        $(document).on('click', '#serach_form_btn', function(e) {
            e.preventDefault();
            let city = $('#city').val();
            let area = $('#area').val();
            let budget = $('#budget').val();
            sessionStorage.setItem('budget', budget);
            $('#total_guest').val(sessionStorage.getItem('guest'));
            $('#total_room').val(sessionStorage.getItem('room'));
            $('.check-in-field').val(sessionStorage.getItem('start_date'));
            $('.check-out-field').val(sessionStorage.getItem('end_date'));
            $('#search-hotel').submit();
        });
    });
</script>

<script>
    var x = 0;
    var timer = setInterval(function() {
        if (jQuery('body > div.sweet-alert.showSweetAlert.visible > p:contains(Thank)').is(":visible")) {
            if (x == 0) {
                gtag('event', 'conversion', {
                    'send_to': 'AW-315826411/8aaXCLHh0o4DEOvBzJYB'
                });
                x = 1;
            }
            clearInterval(timer);
        }
    })
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

    function guest_room() {
        var room = parseFloat($('#room').text());
        guest
        var gueststotal = parseFloat($('.gueststotal').text());
        var gueststotal0 = parseFloat($('#guest').val());
        if (gueststotal0 >= 3) {
            $('#guest').val(3);
            toastr.error('3 Person Allowed In 1 Room');
        }
        var gueststotal1 = parseFloat($('#guest1').val());
        if (gueststotal1 >= 3) {
            $('#guest1').val(3);
            toastr.error('3 Person Allowed In One Room');
        }
        var gueststotal2 = parseFloat($('#guest2').val());
        if (gueststotal2 >= 3) {
            $('#guest2').val(3);
            toastr.error('3 Person Allowed In One Room');
        }
        var gueststotal3 = parseFloat($('#guest3').val());
        if (gueststotal3 >= 3) {
            $('#guest3').val(3);
            toastr.error('3 Person Allowed In One Room');
        }
        var gueststotal4 = parseFloat($('#guest4').val());
        if (gueststotal4 >= 3) {
            $('#guest4').val(3);
            toastr.error('3 Person Allowed In One Room');
        }
        var total = 0;
        var max_guest = room * 3;
        if (gueststotal < max_guest) {
            var aa = 1;
        } else {
            if (gueststotal0 != 'NaN') {
                total = total + gueststotal;
            }
            if (gueststotal1 != 'NaN') {
                total = total + gueststotal1;
            }
            if (gueststotal2 != 'NaN') {
                total = total + gueststotal2;
            }
            if (gueststotal3 != 'NaN') {
                total = total + gueststotal3;
            }
            if (gueststotal4 != 'NaN') {
                total = total + gueststotal4;
            }
            $('.gueststotal').text(total);
        }
    };


    function add() {
        var room = parseFloat($('#room').text());
        var total = 0;
        if (room < 5) {
            $('#room').text(room + 1);
            var room = parseFloat($('#room').text());
            if (room == 2) {
                $('#room2').removeClass('d-none');
            }
            if (room == 3) {
                $('#room3').removeClass('d-none');
            }
            if (room == 4) {
                $('#room4').removeClass('d-none');
            }
            if (room == 5) {
                $('#room5').removeClass('d-none');
            }
        } else {
            toastr.error('Max 5 Room You Can Select');
        }
        var gueststotal0 = parseFloat($('#guest').val());
        var gueststotal1 = parseFloat($('#guest1').val());
        var gueststotal2 = parseFloat($('#guest2').val());
        var gueststotal3 = parseFloat($('#guest3').val());
        var gueststotal4 = parseFloat($('#guest4').val());
        if (gueststotal0 != 'NaN') {
            total = total + gueststotal0;
        }
        if (gueststotal1 != 'NaN') {
            total = total + gueststotal1;
        }
        if (gueststotal2 != 'NaN') {
            total = total + gueststotal2;
        }
        if (gueststotal3 != 'NaN') {
            total = total + gueststotal3;
        }
        if (gueststotal4 != 'NaN') {
            total = total + gueststotal4;
        }
        $('.gueststotal').text(total);
        sessionStorage.setItem('room', room)
    };

    function del_room() {
        var room = parseFloat($('#room').text());
        if (room > 1) {
            $('#room').text(room - 1);
            var room = parseFloat($('#room').text());
            if (room == 1) {
                $('#room2').addClass('d-none');
                $('#room3').addClass('d-none');
                $('#room4').addClass('d-none');
                $('#room5').addClass('d-none');
                $('#guest1').val(0);
                $('#guest2').val(0);
                $('#guest3').val(0);
                $('#guest4').val(0);
            }
            if (room == 2) {
                $('#room3').addClass('d-none');
                $('#room4').addClass('d-none');
                $('#room5').addClass('d-none');
                $('#guest2').val(0);
                $('#guest3').val(0);
                $('#guest4').val(0);
            }
            if (room == 3) {
                $('#room4').addClass('d-none');
                $('#room5').addClass('d-none');
                $('#guest3').val(0);
                $('#guest4').val(0);
            }
            if (room == 4) {
                $('#room5').addClass('d-none');
                $('#guest4').val(0);
            }
        } else {
            toastr.error('Room Should Not Be Less Than 1')
        }
        var gueststotal0 = parseFloat($('#guest').val());
        var gueststotal1 = parseFloat($('#guest1').val());
        var gueststotal2 = parseFloat($('#guest2').val());
        var gueststotal3 = parseFloat($('#guest3').val());
        var gueststotal4 = parseFloat($('#guest4').val());
        var total = 0;
        if (gueststotal0 != 'NaN') {
            total = total + gueststotal0;
        }
        if (gueststotal1 != 'NaN') {
            total = total + gueststotal1;
        }
        if (gueststotal2 != 'NaN') {
            total = total + gueststotal2;
        }
        if (gueststotal3 != 'NaN') {
            total = total + gueststotal3;
        }
        if (gueststotal4 != 'NaN') {
            total = total + gueststotal4;
        }
        $('.gueststotal').text(total);

        sessionStorage.setItem('room', room)

    };

    $('.mobilebtn').click(function () {
    $(this).toggleClass("click");
    $('.sidebar').toggleClass("show");
});
</script>
