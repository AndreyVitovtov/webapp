function page(data) {
    if(data.sc) {
        console.log(data);
        let content = document.querySelector('div.content');
        updateContent(data);
        function updateContent(data, direction = 'left') {
            let content = document.querySelector('div.content');

            let oldContent = document.createElement('div');
            oldContent.classList.add('old-content');
            oldContent.innerHTML = content.innerHTML;

            let newContent = document.createElement('div');
            newContent.classList.add('new-content');
            newContent.innerHTML = data.html;

            let wrapper = document.createElement('div');
            wrapper.classList.add('content-wrapper');
            wrapper.appendChild(oldContent);
            wrapper.appendChild(newContent);

            content.innerHTML = '';
            content.appendChild(wrapper);

            if (direction === 'left') {
                wrapper.style.transform = 'translateX(0%)';
                setTimeout(() => {
                    wrapper.style.transform = 'translateX(-50%)';
                }, 10);
            } else {
                wrapper.style.transform = 'translateX(-50%)';
                wrapper.style.flexDirection = 'row-reverse';
                setTimeout(() => {
                    wrapper.style.transform = 'translateX(0%)';
                }, 10);
            }

            setTimeout(() => {
                content.innerHTML = newContent.innerHTML;
            }, 500);
        }
    }
}