        const scrollWidth = 180;
        const slider = document.getElementById('slider')
        const right = document.getElementById('slider-right')
        const left = document.getElementById('slider-left')
        right.addEventListener('click', () => {
            slider.scrollLeft += scrollWidth;
        })
        left.addEventListener('click', () => {
            slider.scrollLeft -= scrollWidth;
        })