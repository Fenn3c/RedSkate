function autoSubmitConfirm($msg) {
    const autoSubmitForms = document.querySelectorAll('.autosubmit');
    autoSubmitForms.forEach(form => {
        form.addEventListener('change', (e) => {

            if (confirm($msg)) {
                form.submit();
            } else {
                e.preventDefault();
            }

        })
    });
}


function autoSubmit() {
    const autoSubmitForms = document.querySelectorAll('.autosubmit');
    autoSubmitForms.forEach(form => {
        form.addEventListener('change', (e) => {
                form.submit();
        })
    });
}