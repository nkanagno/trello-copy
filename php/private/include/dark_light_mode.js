
const toggle = document.getElementById('dark');
const body = document.querySelector('body');
const a = document.querySelectorAll('nav ul li a');
const navbar = document.querySelector('nav');
const logo = document.querySelector('label');
const footer = document.querySelector('footer');
const dropdownItems = document.querySelectorAll('.dropdown li');
const i = document.querySelector('i');



// dark mode
let background_dark_mode = "rgb(8, 217, 207)";
let color_dark_mode = "rgb(9, 30, 66)";

// light mode
let background_light_mode = "rgb(9, 30, 66)";
let color_light_mode = "rgb(8, 217, 207)";

let color = color_light_mode;
let background = background_light_mode;
// Check if there is a saved preference for dark mode in localStorage
const darkModePreference = localStorage.getItem('darkMode');
    
// Set initial dark mode based on localStorage or default to light mode
if (darkModePreference === 'true') {
    enableDarkMode();
} else {
    enableLightMode();
}

// Toggle dark mode when the toggle button is clicked
toggle.addEventListener('click', function () {
    if (this.classList.toggle('bi-brightness-high-fill')) {
        enableLightMode();
        localStorage.setItem('darkMode', 'false'); // Save the preference in localStorage
    } else {
        enableDarkMode();
        localStorage.setItem('darkMode', 'true'); // Save the preference in localStorage
    }
});

// Function to enable dark mode
function enableDarkMode() {

    // define variables
    color =color_dark_mode;
    background =background_dark_mode;  

    

    
    // main colors
    body.style.background = color;
    body.style.color = 'rgb(211, 236, 245)';
    body.style.transition = '2s';

    // icon
    toggle.classList.add('bi-moon');
    i.style.color = color;

    //footer
    footer.style.background = background;
    footer.style.color = color;
    footer.style.transition = '2s'; 


    
    // Navbar, logo, a, dropdown items
    navbar.style.background = background;
    navbar.style.transition = '2s';
    logo.style.color = color;
    logo.style.transition = '2s';
    a.forEach(anchor => {
        anchor.style.color = color;
        anchor.style.transition = '2s';
    });
    dropdownItems.forEach(item => {
        item.style.color = color;
        item.style.background = background;
    });
    
    try{
        const profile_container = document.getElementsByClassName('profile-container');
        for (let i = 0; i < profile_container.length; i++) {
            profile_container[i].style.color = 'black';
        }

    }catch (error) {}

    //home
    try{
        const HomeImg = document.getElementById('Home-img')
       HomeImg.style.backgroundImage = "url('../assets/home-dark.webp')";

    }catch (error) {}

     try{
        const accordion_item = document.querySelectorAll('.accordion-item');
        const accordion_header = document.querySelectorAll('.accordion-header');
        const accordion_content = document.querySelectorAll('.accordion-content');
        const imgSVG = document.querySelectorAll("span > img");
        imgSVG.forEach(item => {
            item.src= '../assets/arrows-dark.svg';
        });

        accordion_item.forEach(item => {
            item.style.background = color;
            item.style.boxShadow = '0px 0px 10px 0px rgb(8, 217, 207)';
        });
        accordion_header.forEach(item => {
            item.style.color = "rgb(211, 236, 245)";
        });
        accordion_content.forEach(item => {
            item.style.color = "rgb(211, 236, 245)";
        });
    }catch (error) {}

}

// Function to enable light mode
function enableLightMode() {
    color = color_light_mode;
    background = background_light_mode; 
    toggle.classList.remove('bi-moon');

    i.style.color = color;
    body.style.background = 'rgb(211, 236, 245)';
    body.style.color = '#020202';
    body.style.transition = '2s';
    
    navbar.style.background = background;
    navbar.style.transition = '2s';

    logo.style.color = color;
    logo.style.transition = '2s';


    dropdownItems.forEach(item => {
        item.style.color = color;
        item.style.background = background;
    });
    
    a.forEach(anchor => {
        anchor.style.color = color;
        anchor.style.transition = '2s';
    });

    footer.style.background = background;
    footer.style.color = color;
    footer.style.transition = '2s';

    try{
        const HomeImg = document.getElementById('Home-img')
        HomeImg.style.backgroundImage = "url('../assets/home-light.webp')";

    }catch (error) {}

     try{
        const accordion_item = document.querySelectorAll('.accordion-item');
        const accordion_header = document.querySelectorAll('.accordion-header');
        const accordion_content = document.querySelectorAll('.accordion-content');

        const imgSVG = document.querySelectorAll("span > img");
        imgSVG.forEach(item => {
            item.src= '../../assets/arrows-light.svg';
        });

        accordion_item.forEach(item => {
            
            item.style.background = "white";
            item.style.boxShadow = '';

        });

        accordion_header.forEach(item => {
            item.style.color = background;
            
            

        });
        accordion_content.forEach(item => {
            item.style.color = background;
            
            
        });


    }catch (error) {}


}


a.forEach(anchor => {
    anchor.addEventListener('mouseover', function() {
        this.style.color = 'white';

        this.style.transition = '0.5s';
    });
    
    anchor.addEventListener('mouseout', function() {
        this.style.color = color; // Reset to default color
        this.style.transition = '0.5s';
    });
});

try{
const accordionHeaders = document.querySelectorAll('.accordion-header');

accordionHeaders.forEach(header => {
    header.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const isVisible = content.style.display === 'block';

        document.querySelectorAll('.accordion-content').forEach(item => item.style.display = 'none');

        if (!isVisible) {
            content.style.display = 'block';
        }
    });
});
}catch (error) {}