document.querySelectorAll('p + button').forEach(button => {
    button.addEventListener('click', e => {
        let fd = new FormData();
        let csrf = document.getElementById('csrf').value;
        fd.append('id', button.getAttribute('data-ProductId'));
        fd.append('btnType', 'addCart');
        fd.append('csrf', csrf);
        fetch('/Api/api', {
            method: 'POST',
            body: fd
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                let element = document.getElementById('nbitems');
                element.innerHTML = "" + JSON.parse(data.nbItems) + " articles";
                if (!(data.error == '')) {
                    document.getElementById('errorAlert').innerHTML = data.error;
                    document.getElementById('errorAlert').setAttribute('class', "alert alert-danger");
                } else {
                    document.getElementById('errorAlert').setAttribute('class', "alert alert-danger d-none");
                }
            })
    });
})

