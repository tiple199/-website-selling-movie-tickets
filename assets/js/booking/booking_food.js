// Lấy phần tử hiển thị số
const valueElement = document.getElementById("value");
let currentValue = 0;

// Nút giảm
document.getElementById("decrease").addEventListener("click", () => {
    if (currentValue > 0) { // Đảm bảo không giảm xuống dưới 0
        currentValue--;
        valueElement.textContent = currentValue;
    }
});

// Nút tăng
document.getElementById("increase").addEventListener("click", () => {
    currentValue++;
    valueElement.textContent = currentValue;
});
