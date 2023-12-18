const navbarCollapseButton = document.querySelector(".nav-collapse");

navbarCollapseButton.addEventListener("click", () => {
  let navListItems = document.querySelectorAll(".navbar-li");
  navListItems.forEach((item) => {
    item.classList.toggle("active");
  });
});

function changeMode() {
  seekerOption = document.querySelector("#seeker-option");
  if (seekerOption.checked) {
    document.querySelector("label[for='country-field']").innerHTML =
      "Nationality";
    document.querySelector(".company-group").style.display = "none";
    document.querySelector(".company-type-group").style.display = "none";
    document.querySelector(".company-description-group").style.display = "none";

    let nameGroup = document.querySelectorAll(".name-group");

    for (let i = 0; i < nameGroup.length; i++) {
      nameGroup[i].style.display = "block";
    }
    document.querySelector("#company-field").disabled = true;
    document.querySelector("#company-field").value = "";

    document.querySelector("#firstname-field").disabled = false;
    document.querySelector("#lastname-field").disabled = false;

    document.querySelector("label[for='birth-date-field']").innerHTML =
      "Birth Date";

    document.querySelector("#description-field").disabled = true;
    document.querySelector("#description-field").value = "";
  } else {
    document.querySelector("label[for='country-field']").innerHTML = "Country";

    document.querySelector(".company-group").style.display = "block";
    document.querySelector(".company-type-group").style.display = "block";
    document.querySelector(".company-description-group").style.display =
      "block";

    let nameGroup = document.querySelectorAll(".name-group");
    for (let i = 0; i < nameGroup.length; i++) {
      nameGroup[i].style.display = "none";
    }

    document.querySelector("#company-field").disabled = false;

    document.querySelector("#firstname-field").disabled = true;
    document.querySelector("#firstname-field").value = "";
    document.querySelector("#lastname-field").disabled = true;
    document.querySelector("#lastname-field").value = "";

    document.querySelector("label[for='birth-date-field']").innerHTML =
      "Date Created";

    document.querySelector("#description-field").disabled = false;
  }
}

function changePanel(index) {
  let allPanels = document.querySelectorAll(".panel");
  allPanels.forEach((panel) => {
    panel.style.display = "none";
  });
  allPanels[index].style.display = "block";
}

const deleteJobBtn = document.querySelectorAll(".job-delete-btn");
deleteJobBtn.forEach((btn) => {
  btn.addEventListener("click", function () {
    var deleteModal = document.querySelector("#delete-job-modal");
    deleteModal.style.display = "block";
    var span = document.getElementsByClassName("close")[0];
    var confirmBtn = document.querySelector(".btn-confirm");
    var closeModalBtn = document.querySelector(".btn-close-modal");
    span.onclick = function () {
      deleteModal.style.display = "none";
    };
    confirmBtn.onclick = function () {
      deleteModal.style.display = "none";
    };
    closeModalBtn.onclick = function () {
      deleteModal.style.display = "none";
    };
    window.onclick = function (event) {
      if (event.target == deleteModal) {
        deleteModal.style.display = "none";
      }
    };
  });
});

const removeBookmarkBtn = document.querySelectorAll(".btn-remove-bookmark");
removeBookmarkBtn.forEach((btn) => {
  btn.addEventListener("click", function () {
    var removeModal = document.querySelector("#remove-bookmark-modal");
    removeModal.style.display = "block";
    var span = document.getElementsByClassName("close")[0];
    var confirmBtn = document.querySelector(".btn-confirm");
    var closeModalBtn = document.querySelector(".btn-close-modal");
    span.onclick = function () {
      removeModal.style.display = "none";
    };
    confirmBtn.onclick = function () {
      removeModal.style.display = "none";
    };
    closeModalBtn.onclick = function () {
      removeModal.style.display = "none";
    };
    window.onclick = function (event) {
      if (event.target == removeModal) {
        removeModal.style.display = "none";
      }
    };
  });
});

const reviewBtn = document.querySelector(".btn-review");
if(reviewBtn){
  reviewBtn.addEventListener("click", function () {
    var reviewModel = document.querySelector("#review-company-modal");
    reviewModel.style.display = "block";
    var span = document.getElementsByClassName("close")[0];
    var confirmBtn = document.querySelector(".btn-confirm");
    var closeModalBtn = document.querySelector(".btn-close-modal");
    span.onclick = function () {
      reviewModel.style.display = "none";
    };
    confirmBtn.onclick = function () {
      reviewModel.style.display = "none";
    };
    closeModalBtn.onclick = function () {
      reviewModel.style.display = "none";
    };
    window.onclick = function (event) {
      if (event.target == reviewModel) {
        reviewModel.style.display = "none";
      }
    };
  });
}


const bookInterviewBtn = document.querySelector(".btn-book-interview");
if(bookInterviewBtn){
  bookInterviewBtn.addEventListener("click", function () {
    var interviewModal = document.querySelector("#interview-job-modal");
    interviewModal.style.display = "block";
    var span = document.getElementsByClassName("close")[0];
    var confirmBtn = document.querySelector(".btn-confirm");
    var closeModalBtn = document.querySelector(".btn-close-modal");
    span.onclick = function () {
      interviewModal.style.display = "none";
    };
    confirmBtn.onclick = function () {
      interviewModal.style.display = "none";
    };
    closeModalBtn.onclick = function () {
      interviewModal.style.display = "none";
    };
    window.onclick = function (event) {
      if (event.target == interviewModal) {
        interviewModal.style.display = "none";
      }
    };
  });  
}
