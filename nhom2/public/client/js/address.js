document.addEventListener("DOMContentLoaded", function () {
    const provinceSelect = document.getElementById("province");
    const districtSelect = document.getElementById("district");
    const wardSelect = document.getElementById("ward");
    const detailAddress = document.getElementById("detail_address");
    const addressInput = document.getElementById("address");

    // Gọi API để lấy danh sách tỉnh/thành phố
    fetch("https://provinces.open-api.vn/api/p/")
        .then(response => response.json())
        .then(data => {
            data.forEach(province => {
                let option = new Option(province.name, province.code);
                provinceSelect.add(option);
            });
        });

    // Khi chọn tỉnh/thành phố, load quận/huyện
    provinceSelect.addEventListener("change", function () {
        let provinceCode = this.value;
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

        if (!provinceCode) return;

        fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
            .then(response => response.json())
            .then(data => {
                data.districts.forEach(district => {
                    let option = new Option(district.name, district.code);
                    districtSelect.add(option);
                });
            });
    });

    // Khi chọn quận/huyện, load phường/xã
    districtSelect.addEventListener("change", function () {
        let districtCode = this.value;
        wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

        if (!districtCode) return;

        fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
            .then(response => response.json())
            .then(data => {
                data.wards.forEach(ward => {
                    let option = new Option(ward.name, ward.code);
                    wardSelect.add(option);
                });
            });
    });

    // Khi có thay đổi, cập nhật giá trị `address`
    function updateAddress() {
        const provinceText = provinceSelect.options[provinceSelect.selectedIndex]?.text || "";
        const districtText = districtSelect.options[districtSelect.selectedIndex]?.text || "";
        const wardText = wardSelect.options[wardSelect.selectedIndex]?.text || "";
        const detailText = detailAddress.value.trim();

        // Kiểm tra và loại bỏ giá trị không hợp lệ
        let fullAddress = [detailText, wardText, districtText, provinceText]
            .filter(item => item !== "" && !item.match(/^\d+$/)) // Loại bỏ các số không mong muốn
            .join(", ");

        addressInput.value = fullAddress;
    }

    provinceSelect.addEventListener("change", updateAddress);
    districtSelect.addEventListener("change", updateAddress);
    wardSelect.addEventListener("change", updateAddress);
    detailAddress.addEventListener("input", updateAddress);
});
