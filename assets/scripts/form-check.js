function formCheck(form, btn) {
    form.addEventListener('input', (_) => {
        if (form.checkValidity()) {
            btn.disabled = false
        } else {
            btn.disabled = true
        }
    })
}