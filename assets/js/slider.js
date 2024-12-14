    // xử lý slide
    let list = document.querySelector('.poster .poster__list');
    let items = document.querySelectorAll('.poster .poster__list .poster__item');
    let dots = document.querySelectorAll('.poster .dots li');
    let prev = document.getElementById('prev');
    let next = document.getElementById('next');
    let active = 0;
    let lengthItems = items.length - 1;

    next.onclick = function(){
        if(active + 1 > lengthItems){
            active = 0;
        }
        else{
            active += 1;
        }
        reloadSlider();

        
    }
    prev.onclick = function(){
        if(active - 1 < 0){
            active = lengthItems;
        }
        else{
            active -= 1;
        }
        reloadSlider();
    }
    let refreshSlider = setInterval(() => {next.click()},5000);
    function reloadSlider(){
        let checkLeft = items[active].offsetLeft;
        list.style.left = -checkLeft + 'px';
        let lastActiveDot = document.querySelector('.poster .dots li.active_dot');
        lastActiveDot.classList.remove('active_dot');
        dots[active].classList.add('active_dot');
        clearInterval(refreshSlider);
        refreshSlider = setInterval(() => {next.click()},5000);
    }
    dots.forEach((li,key) => {
        li.addEventListener('click',function(){
            active = key;
            reloadSlider();
        })
    })
    