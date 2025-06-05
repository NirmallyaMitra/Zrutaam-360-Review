let i = 0;
let form = [];

for (let i = 0; i < 40; i++) {
  form[i] = document.getElementById("form" + (i + 1));
  if (i != 0) {
    form[i].style.left = "1400px";
  }
}

// form[0] = document.getElementById("form1");
// form[1] = document.getElementById("form2");
// form[2] = document.getElementById("form3");
// form[3] = document.getElementById("form4");
// form[4] = document.getElementById("form5");
// form[5] = document.getElementById("form6");
// form[6] = document.getElementById("form7");
// form[7] = document.getElementById("form8");
// form[8] = document.getElementById("form9");
// form[9] = document.getElementById("form10");
// form[10] = document.getElementById("form11");
// form[11] = document.getElementById("form12");
let submit = document.getElementById("submit-button");

let next = document.getElementById("next");
// let next2 = document.getElementById("next2");
// let next3 = document.getElementById("next3");
// let next4 = document.getElementById("next4");
// let next5 = document.getElementById("next5");
// let next6 = document.getElementById("next6");
// let next7 = document.getElementById("next7");
// let next8 = document.getElementById("next8");
// let next9 = document.getElementById("next9");
// let next10 = document.getElementById("next10");
// let next11 = document.getElementById("next11");

let back = document.getElementById("back");
// let back2 = document.getElementById("back2");
// let back3 = document.getElementById("back3");
// let back4 = document.getElementById("back4");
// let back5 = document.getElementById("back5");
// let back6 = document.getElementById("back6");
// let back7 = document.getElementById("back7");
// let back8 = document.getElementById("back8");
// let back9 = document.getElementById("back9");
// let back10 = document.getElementById("back10");
// let back11 = document.getElementById("back11");

next.onclick = function () {
  if (i >= 0 && i <= 40) {
    form[i].style.left = "-1400px";
    form[++i].style.left = "0px";
  }
  if (i == 39) {
    submit.style.display = "inline-block";
  } else {
    submit.style.display = "none";
  }
};

// next2.onclick = function () {
//   form2.style.left = "-1400px";
//   form3.style.left = "0px";
// };
// next3.onclick = function () {
//   form3.style.left = "-1400px";
//   form4.style.left = "0px";
// };
// next4.onclick = function () {
//   form4.style.left = "-1400px";
//   form5.style.left = "0px";
// };
// next5.onclick = function () {
//   form5.style.left = "-1400px";
//   form6.style.left = "0px";
// };
// next6.onclick = function () {
//   form6.style.left = "-1400px";
//   form7.style.left = "0px";
// };
// next7.onclick = function () {
//   form7.style.left = "-1400px";
//   form8.style.left = "0px";
// };
// next8.onclick = function () {
//   form8.style.left = "-1400px";
//   form9.style.left = "0px";
// };
// next9.onclick = function () {
//   form9.style.left = "-1400px";
//   form10.style.left = "0px";
// };
// next10.onclick = function () {
//   form10.style.left = "-1400px";
//   form11.style.left = "0px";
// };
// next11.onclick = function () {
//   form11.style.left = "-1400px";
//   form12.style.left = "0px";
// };

back.onclick = function () {
  if (i >= 1 && i <= 39) {
    form[i].style.left = "-1400px";
    form[--i].style.left = "0px";
  }
  if (i == 39) {
    submit.style.display = "inline-block";
  } else {
    submit.style.display = "none";
  }
};
// back2.onclick = function () {
//   form2.style.left = "0px";
//   form3.style.left = "-1400px";
// };
// back3.onclick = function () {
//   form3.style.left = "0px";
//   form4.style.left = "-1400px";
// };
// back4.onclick = function () {
//   form4.style.left = "0px";
//   form5.style.left = "-1400px";
// };
// back5.onclick = function () {
//   form5.style.left = "0px";
//   form6.style.left = "-1400px";
// };
// back6.onclick = function () {
//   form6.style.left = "0px";
//   form7.style.left = "-1400px";
// };
// back7.onclick = function () {
//   form7.style.left = "0px";
//   form8.style.left = "-1400px";
// };
// back8.onclick = function () {
//   form8.style.left = "0px";
//   form9.style.left = "-1400px";
// };
// back9.onclick = function () {
//   form9.style.left = "0px";
//   form10.style.left = "-1400px";
// };
// back10.onclick = function () {
//   form10.style.left = "0px";
//   form11.style.left = "-1400px";
// };
// back11.onclick = function () {
//   form11.style.left = "0px";
//   form12.style.left = "-1400px";
// };
