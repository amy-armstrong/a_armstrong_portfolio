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

  // my hamburger
  function openMenu() {
    menu.classList.add("open");
  }

  function closeMenu() {
    menu.classList.remove("open");
  }

  // this hides all of my projects
  function hideAllProjects() {
    for (var i = 0; i < allProjects.length; i++) {
      allProjects[i].style.display = "none";
    }
  }

  // show one project id at a time depending what is clicked 
  function showProject(id) {
    if (id && projects[id]) {
      var p = document.querySelector(projects[id]);
      if (p) {
        p.style.display = "block";
      }
    } else {
      console.log("No valid project selected");
    }
  }

  // grabs the id from the url
  function getProjectId() {
    var query = window.location.search; 
    var idStart = query.indexOf("id="); 
    if (idStart !== -1) {
      var id = "";
      for (var i = idStart + 3; i < query.length; i++) {
        id += query[i];
      }
      return id;
    }
    return null;
  }

  // event listeners
  hamburgerButton.addEventListener("click", openMenu);
  closeButton.addEventListener("click", closeMenu);

  // project selection
  hideAllProjects();
  showProject(getProjectId());


  
  gsap.registerPlugin(SplitText, ScrollTrigger);

  // split all elements with class "split"
  let split = new SplitText(".split", { type: "words, chars" });

  // animate characters on scroll
  gsap.from(split.chars, {
    y: 100,
    autoAlpha: 0,
    stagger: 0.03,
    ease: "power3.out",
    scrollTrigger: {
      trigger: ".split",
      start: "top 80%"
    }
  });

})();

  