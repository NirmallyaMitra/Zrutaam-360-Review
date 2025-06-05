const option = document.getElementById("gendergroup");
const inputbox = document.getElementById("self-1");
option.onchange = function () {
  if (option.value == "self-describe") {
    inputbox.style.display = "block";
  } else {
    inputbox.style.display = "none";
  }
};
