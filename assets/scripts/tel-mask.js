const phones = document.querySelectorAll('.phone');
phones.forEach((phone) => {
    IMask(phone, {
        mask: '+{7} (000) 000-00-00'
    });
})