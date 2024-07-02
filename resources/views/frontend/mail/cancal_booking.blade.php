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
                       <p>Booking Cancellation for NSN Hotels</p>
<p>Hello Mr.{{$email}} ,</p>
<p><br />This is a confirmation of your cancellation of your hotel booking with NSN Hotels _______________________for your upcoming stay.</p>
<p>To help you get started, we have created an online concierge with options for filling your future stay preferences, <br />buying upgrades and viewing area information.</p>
<p>Your Cancellation Details</p>
<p><br />Cancellation Confirmation # {{$booking_id}}</p>
<p>Hotel Name $<br />Guest Name</p>
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
