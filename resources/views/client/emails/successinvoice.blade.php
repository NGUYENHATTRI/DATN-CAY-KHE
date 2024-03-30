<div
    style="background-color:#e2e2e2;; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
    <div style="padding: 1px 0px 25px 0px; margin:0px auto; max-width: 600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
            style="border-collapse:collapse;MARGIN-TOP: 27PX;background-color: #ffffff;border-radius: 0px;">
            <tbody>
                <tr>
                    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                        <div style="padding-top:20px;text-align:center; margin:0 60px 34px 60px">
                            <!--begin:Logo-->
                            <div style="margin-bottom: 10px">
                                <a href="{{ route('home') }}" rel="noopener" target="_blank">
                                    <img alt="NHATTRI" src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Shopee.svg/1200px-Shopee.svg.png" style="height:35px" />
                                </a>
                            </div>

                            <div
                                style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                <p style="margin-bottom:9px; color:#181C32; font-size: 18px; font-weight:700">Xin chào
                                    {{ $name }},
                                    Đây là tin nhắn từ SHOP !</p>
                                <p style="margin-bottom:2px; color:#7E8299">Cảm ơn bạn đã thanh toán hóa đơn:
                                    #INV{{ $id }}</p>
                            </div>
                            <p style="font-size: 14px; font-weight: 500;margin-bottom:2px; color:#7E8299">Ngày tạo hóa
                                đơn: {{ $order_date }}</p>
                            <p style="font-size: 14px; font-weight: 500;margin-bottom:2px; color:#7E8299"><b>Trạng thái
                                    hóa đơn:</b> Đã thanh toán </p>
                            <p style="font-size: 14px; font-weight: 500;margin-bottom:2px; color:#7E8299"><b>Tổng
                                    tiền:</b> {{ formatPrice($total) }} </p>
                            <p style="font-size: 14px; font-weight: 500;margin-bottom:2px; color:#7E8299">Bạn có thể xem
                                hóa đơn theo đường dẫn sau: <a
                                    href="{{ route('checkout.invoice', ['code' => $id]) }}">INV{{ $id }}</a></p>
                        </div>
                    </td>
                </tr>
                <tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
                    <td align="start" valign="start" style="padding-bottom: 10px;">
                        <p style="color:#181C32; font-size: 18px; font-weight: 600; margin-bottom:13px">Bạn đã thanh
                            toán, nhưng vẫn thấy hóa đơn này?</p>
                        <div style="background: #F9F9F9; border-radius: 0px; padding:5px 30px">
                            <div style="display:flex">
                                <div>
                                    <div>
                                        <p
                                            style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">
                                            Nếu bạn đã thanh toán, hãy bỏ qua mail này.</p>
                                    </div>
                                    <div class="separator separator-dashed" style="margin:10px 0 15px 0"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <div>
                    <tr style="background:#212121;height:100%;">
                        <td align="center" valign="center"
                            style="font-size: 13px; text-align:center; padding: 15px; font-weight: 500; color: #e4e4e4; font-family:Arial,Helvetica,sans-serif">
                            <p style="color:#e4e4e4; font-size: 16px; font-weight: 600; margin-bottom:9px">Chăm sóc
                                khách
                                hàng</p>
                            <a href="https://facebook.com"><img src="https://i.imgur.com/hQ5rUx9.png"
                                    style="height:15px"></a>
                            <p style="margin-bottom:2px">Số điện thoại: +84999999999</p>
                            <p style="margin-bottom:4px;color: #e4e4e4;">Mail:
                                <a
                                    style="font-weight: 600;text-decoration: none;color: #e4e4e4;">admin@gmail.com</a>.
                            </p>
                            <p>Thời gian làm việc 7:00 - 20:00</p>
                            <p style="margin-top:10px;">&copy; Copyright by
                                <a href="https://facebook.com" rel="noopener" target="_blank"
                                    style="font-weight: 600; font-family:Arial,Helvetica,sans-serif;text-decoration: none;color:#EA4C3B">
                                    Nhật Trí</a>
                            </p>
                        </td>
                    </tr>
                </div>

            </tbody>
        </table>
    </div>
</div>
