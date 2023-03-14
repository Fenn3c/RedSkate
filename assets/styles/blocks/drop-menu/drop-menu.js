const menus = document.querySelectorAll(".drop-menu");

menus.forEach(menu => {
    menu.addEventListener('click', (e) => {
        const list = menu.querySelector('.drop-menu__list')
        list.classList.toggle('drop-menu__list_hidden')
    })
})