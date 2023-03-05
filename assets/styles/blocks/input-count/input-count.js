const inputsGroups = document.querySelectorAll('.input-count')
inputsGroups.forEach((group) => {
    const input = group.querySelector('.input-count__input')
    group.querySelector('.input-count__dec').addEventListener('click', () => {
        if (Number(input.value) - 1 >= input.min) {
            input.value = Number(input.value) - 1
        }
    })
    group.querySelector('.input-count__inc').addEventListener('click', () => {
        if (Number(input.value) + 1 <= input.max) {
            input.value = Number(input.value) + 1
        }
    })

})