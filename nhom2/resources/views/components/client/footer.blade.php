<!-- Bắt đầu Footer -->
<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <h5 class="text-secondary text-uppercase mb-4">Liên Hệ Với Chúng Tôi</h5>
            <p class="mb-4">Không có nỗi đau nào mà không có ý nghĩa. Hãy đến và khám phá những điều tuyệt vời tại cửa
                hàng của chúng tôi.</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Đường ABC, TP. HCM, Việt Nam</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Mua Sắm Nhanh</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Trang Chủ</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Cửa Hàng</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Chi Tiết Sản
                            Phẩm</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Giỏ Hàng</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Thanh Toán</a>
                        <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Liên Hệ</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Tài Khoản Của Tôi</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Trang Chủ</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Cửa Hàng</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Chi Tiết Sản
                            Phẩm</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Giỏ Hàng</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Thanh Toán</a>
                        <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Liên Hệ</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Bản Tin</h5>
                    <p>Nhận thông tin mới nhất về sản phẩm và ưu đãi từ chúng tôi.</p>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Địa chỉ Email của bạn">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Đăng ký</button>
                            </div>
                        </div>
                    </form>
                    <h6 class="text-secondary text-uppercase mt-4 mb-3">Theo Dõi Chúng Tôi</h6>
                    <div class="d-flex">
                        <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-secondary">
                &copy; <a class="text-primary" href="#">Tên Miền Của Bạn</a>. Mọi quyền được bảo lưu. Thiết kế bởi
                <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                <br>Phân phối bởi: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="{{ asset('client/img/payments.png') }}" alt="Phương thức thanh toán">
        </div>
    </div>
</div>
<!-- Kết thúc Footer -->

<!-- Nút quay về đầu trang -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- Thư viện JavaScript -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('client/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('client/lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- File JavaScript liên hệ -->
<script src="{{ asset('client/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('client/mail/contact.js') }}"></script>

<!-- File JavaScript chính -->
<script src="{{ asset('client/js/main.js') }}"></script>
@stack('scripts')

<!-- Thư viện bổ sung -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>