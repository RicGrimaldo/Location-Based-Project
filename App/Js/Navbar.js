(() => {
    'use strict'
    document.querySelector('#navbarSideCollapse').addEventListener('click', () => {
        document.querySelector('.offcanvas-collapse').classList.toggle('open');
        document.getElementById('navbar').classList.toggle('open');
        document.getElementById('toggleButton').classList.toggle('navbar-toggler-icon');
        var toggleButton = document.getElementById('toggleButton');
        if(toggleButton.classList.contains('navbar-toggler-icon')){
            toggleButton.innerHTML = ``;
        }
        else{
            toggleButton.innerHTML = `<img src="Assets/x-lg.svg" width="30" height="30">`;
        }
    })
})()