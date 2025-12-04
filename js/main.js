(() => {
    
    const menu = document.querySelector("#menu");
    const hamburger = document.querySelector("#hamburger");
    const closebutton = document.querySelector("#close");
    const menuLinks = document.querySelectorAll("#menu nav ul li a");

    function toggleMenu() {
        menu.classList.toggle("open");
    }

    closebutton.addEventListener("click", toggleMenu);

    menuLinks.forEach(link=>{
        link.addEventListener("click", toggleMenu);
    })
    hamburger.addEventListener("click", toggleMenu);

})();