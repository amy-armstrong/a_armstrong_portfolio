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

  function openMenu() {
    menu.classList.add("open");
  }

  function closeMenu() {
    menu.classList.remove("open");
  }

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

  function hideAllProjects() {
    for (var i = 0; i < allProjects.length; i++) {
      allProjects[i].style.display = "none";
    }
  }

  function showProject(id) {
    if (id && projects[id]) {
      var p = document.querySelector(projects[id]);
      if (p) {
        p.style.display = "block";
        
              runAnimations();
      }
    } else {
      console.log("No valid project selected");
    }
  }

  function runAnimations() {
    gsap.registerPlugin(SplitText, ScrollTrigger);
    let split = new SplitText(".split", { type: "words, chars" });

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
  }

  // Event Listeners
  hamburgerButton.addEventListener("click", openMenu);
  closeButton.addEventListener("click", closeMenu);

  hideAllProjects();
  
  // This turns "2" into "project2" to match 'projects' id keys
  var rawId = getProjectId();
  showProject("project" + rawId);

})();

  