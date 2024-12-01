document.addEventListener('DOMContentLoaded',function(){
    const btn_play = document.getElementById('button_play');
    const show_trailer = document.getElementById('show_trailer');
    btn_play.addEventListener("click",function(){
        show_trailer.style.display = "block";
        overlay.style.display="block";
    })

    overlay.onclick = function() {
        
        overlay.style.display = 'none';
        loginModal.style.display = 'none';
        registerModal.style.display = 'none';
        show_trailer.style.display = "none";
        show_trailer.src = show_trailer.src;
    }
})
