function formCheck(form, btn) {
    // const form = document.getElementById('signup-form')
    // const btn = document.getElementById('signup-btn')
    form.addEventListener('input', (_) => {
        if (form.checkValidity()) {
            btn.disabled = false
        } else {
            btn.disabled = true
        }
    })
}