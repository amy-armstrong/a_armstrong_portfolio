(() => {
    const menu = document.querySelector("#menu");
    const hamburgerButton = document.querySelector("#hamburger");
    const closeButton = document.querySelector("#close");
  
    const projects = {
      project1: "#project-1",
      project2: "#project-2",
      project3: "#project-3"
    };
    const allProjects = document.querySelectorAll(".project-detail");
  
    // my hambuurger
    function openMenu() {
      menu.classList.add("open");
    }
  
    function closeMenu() {
      menu.classList.remove("open");
    }
  
// this is for my projects page

//this hides all of my projects
function hideAllProjects() {
    for (var i = 0; i < allProjects.length; i++) {
      allProjects[i].style.display = "none";
    }
  }

  // this is showing my project, but one project id at a time depending what is clicked 
  function showProject(id) {
    if (id && projects[id]) {
      var p = document.querySelector(projects[id]); //var pointing to the html element
      if (p) {
        p.style.display = "block";
      }
    } else {
      console.log("No valid project selected");
    }
  }
  
  //grabs the id from the url
  function getProjectId() {
    var query = window.location.search; // "?id=project2"
    var idStart = query.indexOf("id="); //its where the id starts in url
    if (idStart !== -1) {
      var id = "";
      for (var i = idStart + 3; i < query.length; i++) {//grabs everything after the id=
        id += query[i];
      }
      return id;
    }
    return null;
  }
  
  
    // event Listeners
    hamburgerButton.addEventListener("click", openMenu);
    closeButton.addEventListener("click", closeMenu);
  
    // project selection
    hideAllProjects();
    showProject(getProjectId()); //gets id from url then shows only the porject that matches the id
  })();
  