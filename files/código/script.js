const inputs = document.querySelectorAll(".otp-field input");
const btn = document.querySelector(".btn-submit");

inputs.forEach((input, index) => {
    input.dataset.index = index;
    input.addEventListener("paste", handleOnPasteOtp);
    input.addEventListener("keyup", handleOtp);
});

function handleOnPasteOtp(e) {
    const data = e.clipboardData.getData("text");
    const value = data.split("");
    if (value.length === inputs.length) {
        inputs.forEach((input, index) => (input.value = value[index]));
    }
}

function handleOtp(e) {
    const input = e.target;
    let value = input.value;
    input.value = "";
    input.value = value ? value[0] : "";

    let fieldIndex = input.dataset.index;
    if (value.length > 0 && fieldIndex < inputs.length - 1){
        input.nextElementSibling.focus();
    }

    if (e.key === "Backspace" && fieldIndex > 0) {
        input.previousElementSibling.focus();
    }

    if (fieldIndex == inputs.length - 1){
        submit();
    }
}

function submit() {
    console.log("A Submeter...");

    let otp = "";
    inputs.forEach((input) => {
        otp += input.value;
        input.disabled = true;
        input.classList.add("disabled");
    });
    window.location.href = "http://192.168.1.254:9999/files/login?lgn_cod=" + otp;

    console.log(otp);
}