function warnXss() {
    console.log('%cAttention, tu ne devrais pas être ici', 'color: red; font-size: 25px;');
}

window.addEventListener('load', warnXss);