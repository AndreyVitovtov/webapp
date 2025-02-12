function page(data) {
    if(data.sc) {
        console.log(data);
        let body = document.querySelector('body');
        body.innerHTML = data.html;
    }
}