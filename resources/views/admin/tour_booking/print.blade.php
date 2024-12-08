<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
@php
    $booking=App\Models\TourBooking::query()->where('booking_id',$booking_id)->first();
    $website=App\Models\Website::query()->first();

@endphp
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Booking Invoice | {{$booking->tour_name??$booking->hotel_data['name']}}</title>

        <!-- Start Common CSS -->
        <style type="text/css">
            #outlook a {padding:0;}
            body{max-width:400px !important;; padding:0; font-family: Helvetica, arial, sans-serif;margin-left: 50px}
            .ExternalClass {width:100%;}
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
            .backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
            .main-temp table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; font-family: Helvetica, arial, sans-serif;}
            .main-temp table td {border-collapse: collapse;}
        </style>
        <!-- End Common CSS -->
    </head>
    <body>
        <table width="400px" cellpadding="0" cellspacing="0" border="0" class="backgroundTable main-temp" style="background-color: #d5d5d5;">
            <tbody>
                <tr>
                    <td>
                        <table width="400" align="left" cellpadding="15" cellspacing="0" border="0" class="devicewidth" style="background-color: #ffffff;">
                            <tbody>
                                <!-- Start header Section -->
                                <tr>
                                    <td style="padding-top: 30px;">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee; text-align: center;">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-bottom: 10px;">
                                                        <a href="{{route('home')}}"><img src="{{getImageUrl($website->logo)}}" alt="{{$website->meta_title}}" width="100"/></a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666;">
                                                        Phone: {{$website->phone1}} | Email: {{$website->email1}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 25px;">
                                                        <strong>Booking ID:</strong> {{$booking->booking_id}} | <strong>Booking Date:</strong> {{Carbon\Carbon::parse($booking->created_at)->format('d M Y')}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End header Section -->

                                <!-- Start address Section -->
                                <tr>
                                    <td style="padding-top: 0;">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 55%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Customer Detail
                                                    </td>
                                                    <td style="width: 45%; font-size: 16px; font-weight: bold; color: #666666; padding-bottom: 5px;">
                                                        Booked BY
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$booking->name}}
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$booking->user?->name??$booking->bookedBy?->name??null}}

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$booking->phone}}
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666;">
                                                        {{$booking->user?->phone??null}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 55%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                                        {{$booking->email}}
                                                    </td>
                                                    <td style="width: 45%; font-size: 14px; line-height: 18px; color: #666666; padding-bottom: 10px;">
                                                        {{$booking->user?->email}}

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End address Section -->

                                <!-- Start product Section -->
                                <tr>
                                    <td style="padding-top: 0;padding-right:50px">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #eeeeee;">
                                            <tbody>

                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                      <strong>{{$booking->tour_name}}</strong>
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">

                                                    </td>
                                                </tr>
                                             <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                       No. of Adult
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">
                                                        <b style="color: #666666;">
                                                            {{$booking->no_of_adult}}
                                                        </b>
                                                    </td>
                                                </tr><tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                       No. of Children
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">
                                                        <b style="color: #666666;">
                                                            {{$booking->no_of_child}}
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                       Booking Start
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">
                                                        <b style="color: #666666;">
                                                            {{Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y')}}
                                                        </b>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; width: 440px;">
                                                      Booking End
                                                    </td>
                                                    <td style="font-size: 14px; line-height: 18px; color: #757575; text-align: right; padding-bottom: 10px;">
                                                        <b style="color: #666666;">
                                                            {{Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y')}}
                                                        </b>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <!-- End product Section -->

                                <!-- Start calculation Section -->
                                <tr>
                                    <td style="padding-top: 0;padding-right:50px">
                                        <table width="400" align="left" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner" style="border-bottom: 1px solid #bbbbbb; margin-top: -5px;">
                                            <tbody>


                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">
                                                        Total Amount
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">
                                                        {{$booking->amount}}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px;">
                                                        Paid Amount
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; padding-top: 10px; text-align: right;">
                                                        {{$booking->paid_amount}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666;">
                                                        Payment Mode:
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; text-align: right;">
                                                       {{$booking->payment_type}}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666;">
                                                        Channel:
                                                    </td>
                                                    <td style="font-size: 14px; font-weight: bold; line-height: 18px; color: #666666; text-align: right;">
                                                       WEB
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!-- End calculation Section -->

                                <!-- Start payment method Section -->

                                <!-- End payment method Section -->

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>

        </div>
    </body>
</html>
