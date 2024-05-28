document.querySelectorAll('li button').forEach(button => {
    button.addEventListener('click', e => {
        let fd = new FormData();
        let csrf = document.getElementById('csrf').value;
        fd.append('id', button.getAttribute('data-ProductId'));
        fd.append('btnType', button.getAttribute('data-BtnType'));
        fd.append('csrf', csrf);
        fetch('/Api/api', {
            method: 'POST',
            body: fd
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                document.getElementById('item' + button.getAttribute('data-ProductId')).innerText = JSON.parse(data.nbItems);
                document.getElementById('subTotal').innerText = JSON.parse(data.subTotal).toFixed(2) + '$';
                document.getElementById('tps').innerText = JSON.parse(data.tps).toFixed(2) + '$';
                document.getElementById('tvq').innerText = JSON.parse(data.tvq).toFixed(2) + '$';
                document.getElementById('total').innerText = JSON.parse(data.total).toFixed(2) + '$';
                document.getElementById('nbitems').innerText = JSON.parse(data.totalItems) + ' articles';
                if (!data.inventory)
                    document.getElementById('cartProduct' + button.getAttribute('data-ProductId')).setAttribute('class', 'd-none');
            })
    });
})
