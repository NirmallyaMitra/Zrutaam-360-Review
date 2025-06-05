// let i = 0;
// let form = [];

// for (let i = 0; i < 40; i++) {
//   form[i] = document.getElementById("form" + (i + 1));
//   if (i != 0) {
//     form[i].style.left = "1400px";
//   }
// }

// // form[0] = document.getElementById("form1");
// // form[1] = document.getElementById("form2");
// // form[2] = document.getElementById("form3");
// // form[3] = document.getElementById("form4");
// // form[4] = document.getElementById("form5");
// // form[5] = document.getElementById("form6");
// // form[6] = document.getElementById("form7");
// // form[7] = document.getElementById("form8");
// // form[8] = document.getElementById("form9");
// // form[9] = document.getElementById("form10");
// // form[10] = document.getElementById("form11");
// // form[11] = document.getElementById("form12");
// let submit = document.getElementById("submit-button");

// let next = document.getElementById("next");
// // let next2 = document.getElementById("next2");
// // let next3 = document.getElementById("next3");
// // let next4 = document.getElementById("next4");
// // let next5 = document.getElementById("next5");
// // let next6 = document.getElementById("next6");
// // let next7 = document.getElementById("next7");
// // let next8 = document.getElementById("next8");
// // let next9 = document.getElementById("next9");
// // let next10 = document.getElementById("next10");
// // let next11 = document.getElementById("next11");

// let back = document.getElementById("back");
// // let back2 = document.getElementById("back2");
// // let back3 = document.getElementById("back3");
// // let back4 = document.getElementById("back4");
// // let back5 = document.getElementById("back5");
// // let back6 = document.getElementById("back6");
// // let back7 = document.getElementById("back7");
// // let back8 = document.getElementById("back8");
// // let back9 = document.getElementById("back9");
// // let back10 = document.getElementById("back10");
// // let back11 = document.getElementById("back11");

// next.onclick = function () {
//   if (i >= 0 && i <= 40) {
//     form[i].style.left = "-1400px";
//     form[++i].style.left = "0px";
//   }
//   if (i == 39) {
//     submit.style.display = "inline-block";
//   } else {
//     submit.style.display = "none";
//   }
// };

// // next2.onclick = function () {
// //   form2.style.left = "-1400px";
// //   form3.style.left = "0px";
// // };
// // next3.onclick = function () {
// //   form3.style.left = "-1400px";
// //   form4.style.left = "0px";
// // };
// // next4.onclick = function () {
// //   form4.style.left = "-1400px";
// //   form5.style.left = "0px";
// // };
// // next5.onclick = function () {
// //   form5.style.left = "-1400px";
// //   form6.style.left = "0px";
// // };
// // next6.onclick = function () {
// //   form6.style.left = "-1400px";
// //   form7.style.left = "0px";
// // };
// // next7.onclick = function () {
// //   form7.style.left = "-1400px";
// //   form8.style.left = "0px";
// // };
// // next8.onclick = function () {
// //   form8.style.left = "-1400px";
// //   form9.style.left = "0px";
// // };
// // next9.onclick = function () {
// //   form9.style.left = "-1400px";
// //   form10.style.left = "0px";
// // };
// // next10.onclick = function () {
// //   form10.style.left = "-1400px";
// //   form11.style.left = "0px";
// // };
// // next11.onclick = function () {
// //   form11.style.left = "-1400px";
// //   form12.style.left = "0px";
// // };

// back.onclick = function () {
//   if (i >= 1 && i <= 39) {
//     form[i].style.left = "-1400px";
//     form[--i].style.left = "0px";
//   }
//   if (i == 39) {
//     submit.style.display = "inline-block";
//   } else {
//     submit.style.display = "none";
//   }
// };
// // back2.onclick = function () {
// //   form2.style.left = "0px";
// //   form3.style.left = "-1400px";
// // };
// // back3.onclick = function () {
// //   form3.style.left = "0px";
// //   form4.style.left = "-1400px";
// // };
// // back4.onclick = function () {
// //   form4.style.left = "0px";
// //   form5.style.left = "-1400px";
// // };
// // back5.onclick = function () {
// //   form5.style.left = "0px";
// //   form6.style.left = "-1400px";
// // };
// // back6.onclick = function () {
// //   form6.style.left = "0px";
// //   form7.style.left = "-1400px";
// // };
// // back7.onclick = function () {
// //   form7.style.left = "0px";
// //   form8.style.left = "-1400px";
// // };
// // back8.onclick = function () {
// //   form8.style.left = "0px";
// //   form9.style.left = "-1400px";
// // };
// // back9.onclick = function () {
// //   form9.style.left = "0px";
// //   form10.style.left = "-1400px";
// // };
// // back10.onclick = function () {
// //   form10.style.left = "0px";
// //   form11.style.left = "-1400px";
// // };
// // back11.onclick = function () {
// //   form11.style.left = "0px";
// //   form12.style.left = "-1400px";
// // };

// let i = 0;
// let form = [];
// let commentBox = [];
// const totalQuestions = 40;

// for (let q = 0; q < totalQuestions; q++) {
//   form[q] = document.getElementById("form" + (q + 1));
//   if (q != 0) {
//     form[q].style.left = "1400px";
//   }
//   if ((q + 1) % 4 == 0) {
//     let cb = document.getElementById("commentForm" + (q + 1));
//     if (cb) {
//       commentBox[q] = cb;
//       cb.style.left = "1400px";
//     }
//   }
// }

// let next = document.getElementById("next");
// let back = document.getElementById("back");
// let submit = document.getElementById("submit-button");

// next.onclick = function () {
//   if (i < form.length - 1) {
//     form[i].style.left = "-1400px";
//     i++;

//     if (i % 4 === 0 && commentBox[i - 1]) {
//       commentBox[i - 1].style.left = "0px";
//     } else {
//       form[i].style.left = "0px";
//     }

//     submit.style.display = i === form.length - 1 ? "inline-block" : "none";
//   }
// };

// back.onclick = function () {
//   if (i > 0) {
//     if (i % 4 === 0 && commentBox[i - 1]) {
//       commentBox[i - 1].style.left = "1400px";
//     } else {
//       form[i].style.left = "1400px";
//     }

//     i--;
//     form[i].style.left = "0px";

//     submit.style.display = "none";
//   }
// };

// // Handle comment submission
// document.querySelectorAll(".submit-comment").forEach((btn) => {
//   btn.addEventListener("click", function () {
//     let step = parseInt(this.dataset.step);
//     let textarea = document.getElementById("commentText" + step);
//     let comment = textarea.value.trim();

//     if (comment === "") {
//       alert("Please enter a comment.");
//       return;
//     }

//     // AJAX: Send to PHP
//     fetch("database/save_comment.php", {
//       method: "POST",
//       headers: { "Content-Type": "application/x-www-form-urlencoded" },
//       body: "step=" + step + "&comment=" + encodeURIComponent(comment),
//     })
//       .then((res) => res.text())
//       .then((response) => {
//         console.log(response);
//         commentBox[step - 1].style.left = "-1400px";
//         if (form[step]) {
//           form[step].style.left = "0px";
//           i = step;
//         }
//       });
//   });
// });

let i = 0;
let form = [];
let commentBox = [];
const totalQuestions = 40;
const next = document.getElementById("next");
const back = document.getElementById("back");
const submit = document.getElementById("submit-button");

// Setup all forms
for (let q = 0; q < totalQuestions; q++) {
  const f = document.getElementById("form" + (q + 1));
  if (f) {
    form[q] = f;
    f.style.left = q === 0 ? "0px" : "1400px";
  }

  if ((q + 1) % 4 === 0 || q + 1 === totalQuestions) {
    const cb = document.getElementById("commentForm" + (q + 1));
    if (cb) {
      commentBox[q] = cb;
      cb.style.left = "1400px";
    }
  }
}

function updateNavButtons(show) {
  next.style.display = show ? "inline-block" : "none";
  back.style.display = show && i > 0 ? "inline-block" : "none";
}

// Initial button setup
updateNavButtons(true);
submit.style.display = "none";

// Next Button
next.onclick = function () {
  form[i].style.left = "-1400px";

  if ((i + 1) % 4 === 0 || i + 1 === totalQuestions) {
    commentBox[i].style.left = "0px";
    updateNavButtons(false);
  } else {
    i++;
    form[i].style.left = "0px";
    updateNavButtons(true);
  }

  // Hide submit unless it’s the final form AFTER comment
  submit.style.display = "none";
};

// Back Button
back.onclick = function () {
  if (i > 0) {
    form[i].style.left = "1400px";
    i--;
    form[i].style.left = "0px";
    updateNavButtons(true);
    submit.style.display = "none";
  }
};

// Comment Submit Buttons
document.querySelectorAll(".submit-comment").forEach((btn) => {
  btn.addEventListener("click", function () {
    const step = parseInt(this.dataset.step);
    const textarea = document.getElementById("commentText" + step);
    const comment = textarea.value.trim();

    if (!comment) {
      alert("Please enter a comment.");
      return;
    }

    // AJAX
    fetch("database/save_comment.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "step=" + step + "&comment=" + encodeURIComponent(comment),
    })
      .then((res) => res.text())
      .then((response) => {
        console.log(response);
        commentBox[step - 1].style.left = "-1400px";

        // After final comment, show submit
        if (step === totalQuestions) {
          submit.style.display = "inline-block";
        } else {
          i = step;
          form[i].style.left = "0px";
          updateNavButtons(true);
        }
      });
  });
});
