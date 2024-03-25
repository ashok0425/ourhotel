@php
    $table_style = "style='width:100%;margin-left:auto;marrgin-right:auto;'";
    $font_size_14 = "style='font-size:14px'";
    $w100 = "style='width:100%'";
@endphp
<html>
<head>
    <title>Email new booking</title>
</head>
<body>
<table {!! $table_style !!}>
    <tbody>
    <tr>
        <td align="center" {!! $font_size_14 !!}>
            <table {!! $w100 !!}>
                <tbody>
                <tr>
                    <td>
                       <p>Booking Confirmation for NSN Hotels</p>
<p>Hello Mr.{{$name}} ,</p>
<p><br />Thank you for booking with NSN Hotels {{$place}} for your upcoming stay. We accept your patronage and really look forward <br />to welcoming you.</p>
<p>To help you get started, we have created an online concierge with options for filling your stay preferences, <br />buying upgrades and viewing area information.</p>
<p>Your Reservation Details</p>
<p><br />Booking Confirmation # 00321</p>
<p>Hotel Name {{$place}}  <br />Guest Name {{$name}} <br />Arrival Date {{$start_date}}<br />Departure Date {{$end_date}}_<br />Number of Guest 00<br />Number of days 2 <br />Meal Plan null<br />Total Price</p><br>
 <a href = "https://nsnhotels.com/recipt/{{$book_id}}"> Click here For Recipt<a>
                            <em>
                                Email from system,<br />
                                {{setting('app_name')}}
                            </em>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>