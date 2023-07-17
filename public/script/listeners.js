const navbar = document.querySelector('.navbar');
const burger = document.querySelector('.burger');

var listenerFunctions = {
 
    toggleMenu: (event)=> {  
        navbar.classList.toggle('show-nav');
    }
}

var setupListeners= () =>{
    
    burger.onclick = listenerFunctions.toggleMenu;

} 