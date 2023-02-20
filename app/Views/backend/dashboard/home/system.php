<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body  ">
                <main class="ct-docs-content-col" role="main">
                    <div class="ct-docs-page-title">
                        <h1 class="ct-docs-page-h1-title" id="content"><?php echo $title ?></h1>
                        <div class="avatar-group mt-3"></div>
                    </div>
                    <div class="setup-openserver">
                        <h2 class="ct-docs-page-h2-title" >Hướng dẫn cài đặt OpenServer</h2>
                        <p>
                            Bước 1: Bạn truy cập https://ospanel.io/ và chọn 1 file cài đặt và file cấu hình tương ứng để tải về và cài đặt, các file đó như sau:
                        </p>
                        <ul>
                            <li>
                                profiles_openserver_5.2.2.zip – file cấu hình cho openserver
                            </li>
                            <li>open_server_5_2_2_ultimate.exe – Bản cài đặt đầy đủ nhất, bao gồm gần 40 phần mềm tiện ích đi kèm.</li>
                            <li>open_server_5_2_2_premium.exe – Bản cài đặt rút gọn, lược bỏ đi phần mềm tiện ích</li>
                            <li>
                                open_server_5_2_2_basic.exe – Bản cài đặt cơ bản, sẽ thiếu rất nhiều thứ như Git, MongoDB, Rockmongo, PostgreSQL and PhpPgAdmin, module ImageMagick ...
                            </li>
                        </ul>
                        <p>Bước 2: Sau khi tải về ta sẽ có 1 file với tên open_server_***.exe, bạn chạy file để bắt đầu cài đặt.</p>
                        <ul>
                            <li>
                                Ở hộp thoại đầu tiên, bạn nhập vào đường dẫn sẽ cài đặt openserver. Lưu ý đường dẫn sẽ tự động được nối thêm \OpenServer. Ví dụ như trong hình, sau khi openserver cài đặt thì phần mềm sẽ nằm trong thư mục D:\Website\OpenServer
                            </li>
                            <li>
                                Nhấn OK và đợi quá trình cài đặt, sau khi cài đặt thành công thì hộp thoại sẽ tự biến mất. Để chạy OpenServer thì bạn vào thư mục đã cài (ví dụ D:\Website\OpenServer) và mở phiên bản phù hợp (x64 cho máy 64bit và x86 cho máy 32bit) với quyền administrator:
                            </li>
                            <li>Ở lần chạy đầu tiên, phần mềm yêu cầu ta chọn ngôn ngữ, chọn English.</li>
                            <li>
                                Sau khi chọn ngôn ngữ sẽ có 1 hộp hiện ra yêu cầu cài đặt C++ Runtime & Patches, nhấn OK để cài. Bạn chỉ cần biết nó cần để chạy 1 số ứng dụng trong openserver.
                            </li>
                            <li>
                                Sau khi cài xong bạn được yêu cầu khởi động lại máy, nhấn OK để khởi động lại.
                            </li>
                        </ul>
                        <p>Bước 3: Vào folder cài đặt (ví dụ D:\Website\OpenServer) khởi chạy file Open Server.exe.</p>
                        <div class="text-center mb-3">
                            <img src="resources/img/setup-openserver.png" alt="Open Server">
                        </div>
                        <ul>
                            <li>Sau khi chạy sẽ hiển thị hình lá cờ màu đỏ ở góc trái màn hình, chuột phải chúng ta sẽ hiển thị toàn bộ tác vụ</li>
                            <li>Chọn setting => Modules và setup như trong hình</li>
                            <li class="text-center mb-3" style="list-style: none;">
                                <img src="resources/img/setup-setting.png" alt="">
                            </li>
                            <li>Tiếp đến ở màn hình tác vụ, ta chọn Advanced => Configuration => PHP_7.4 </li>
                            <li>Chúng ta thay đổi ;extension = intl => extension = intl (bỏ dấu “;”) </li>
                            <li>
                                Và thêm 2 extension <br>
                                extension = mongodb <br>
                                extension = mongodb.so
                            </li>
                            <li>Save lại và run server, nếu cờ chuyển sang màu xanh là thành công. </li>
                        </ul>
                    </div>
                    <div class="setup-nodejs">
                        <h2 class="ct-docs-page-h2-title" >Hướng dẫn cài đặt NodeJS</h2>
                        <p>
                            Để download NodeJS bạn cần truy cập vào địa chỉ dưới đây: https://nodejs.org/en/download/
                        </p>
                        <div class="text-center mb-3"><img src="resources/img/nodejs.png" alt=""></div>
                        <ul>
                            <li>
                                Sau khi download thành công bạn có một file và chạy file đó.
                            </li>
                            <li>Cài đặt NodeJS trên Windows rất đơn giản, chấp nhận các tùy chọn mặc định và nhấn "Next .. Next" cho tới bước cuối cùng.</li>
                        </ul>
                    </div>
                    <div class="setup-composer">
                        <h2 class="ct-docs-page-h2-title" >Hướng dẫn cài đặt Composer</h2>
                        <div class="section">
                            <div class="inner mb40">
                                <p>Download trực tiếp từ trang chính: <a class="outLink" href="https://getcomposer.org/download/" target="_blank">https://getcomposer.org/download/</a></p>
                                <p>Do trong phạm vi bài hướng dẫn, composer sẽ được sử dụng cùng với Xampp, nên các bạn lựa chọn download file về cài đặt nhe.</p>
                                <p>Trường hợp các bạn không sử dụng chung với Xampp (ví dụ tự cài đặt từ VPS, Vagrant, ...), thì có thể chọn cách cài đặt bằng Command-line.</p>
                            </div>
                            <div class="inner mb40">
                                <p>Double click vào file vừa download, tiến hành cài đặt theo hình bên dưới.</p>
                                <ul class="text">
                                    <li>Click "Next" để tiến hành cài đặt.</li>
                                    <li>Lưu ý: Trong quá trình cài đặt, nếu có xuất hiện lỗi nào đó thì có thể bỏ qua bằng cách click "Next" để tiếp tục cài.</li>
                                </ul>
                                <p class="alignC mt10 mb20 text-center"><img src="resources/img/img_laravel01.jpg" alt="Cài đặt và cấu hình Composer"></p>
                                <ul class="text">
                                    <li>Giữ mặt định để chọn folder cài đặt và tiếp tục click "Next".</li>
                                </ul>
                                <p class="alignC mt10 mb20 text-center"><img src="resources/img/img_laravel02.jpg" alt="Cài đặt và cấu hình Composer"></p>
                                <ul class="text">
                                    <li>
                                        Chọn khu vực chứa file chạy PHP và tiếp tục Click "Next".
                                    </li>
                                    <li>
                                        OpenServer\modules\php\PHP_7.4\php.exe
                                    </li>
                                </ul>
                                <p class="alignC mt10 mb20 text-center"><img src="resources/img/img_laravel03.jpg" alt="Cài đặt và cấu hình Composer"></p>
                                <ul class="text">
                                    <li>Phần setting Proxy bỏ trống và tiếp tục Click "Next".</li>
                                </ul>
                                <p class="alignC mt10 mb20 text-center"><img src="resources/img/img_laravel04.jpg" alt="Cài đặt và cấu hình Composer"></p>
                                <ul class="text">
                                    <li>Xem lại lựa chọn lần cuối trước khi Click "Install" để tiến hành cài đặt.</li>
                                </ul>
                                <p class="alignC mt10 mb20 text-center"><img src="resources/img/img_laravel05.jpg" alt="Cài đặt và cấu hình Composer"></p>
                                <ul class="text">
                                    <li>Bảng thông tin hướng dẫn, Click "Next".</li>
                                </ul>
                                <p class="alignC mt10 mb20 text-center"><img src="resources/img/img_laravel06.jpg" alt="Cài đặt và cấu hình Composer"></p>
                                <ul class="text">
                                    <li>Tới đây là kết thúc quá trình cài đặt, Click "Finish" để kết thúc.</li>
                                </ul>
                                <p class="alignC mt10 mb20 text-center"><img src="resources/img/img_laravel07.jpg" alt="Cài đặt và cấu hình Composer"></p>
                            </div>
                        </div>
                    </div>
                    <div class="setup-system">
                        <h2 class="ct-docs-page-h2-title" >Hướng dẫn cài đặt hệ thống</h2>
                        <ul>
                            <li>Tải code từ Github: <a href="https://github.com/zuzuvocup-2000/vfit.crawl.com.git">https://github.com/zuzuvocup-2000/vfit.crawl.com.git</a></li>
                            <li>Giải nén code vào folder domains</li>
                            <li>
                                Vào folder code chạy cmd và chạy lệnh: "composer install"
                            </li>
                            <li>
                                Vào folder code chạy cmd và chạy lệnh: 
                                <br>
                                "cd backend" <br>
                                "npm install"
                            </li>
                            <li>
                                Sau khi cài đặt thành công, chúng ta chạy dòng lệnh để khởi tạo môi trường
                                <br>
                                "cd backend" 
                                <br>
                                "npm run watch"

                            </li>
                            <li>
                                Domain ảo để vào hệ thống là tên folder trong folder domain chứa code, ví dụ: <a href="http://vfit.crawl.com/">http://vfit.crawl.com/</a>
                            </li>
                        </ul>
                    </div>
                </main>
            </div>
        </div>
    </div>
</div>