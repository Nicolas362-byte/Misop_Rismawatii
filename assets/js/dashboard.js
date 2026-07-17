/*==========================================
    DASHBOARD.JS
==========================================*/

// Animasi Card

document.addEventListener("DOMContentLoaded",()=>{

    const cards=document.querySelectorAll(".card");

    cards.forEach((card,index)=>{

        card.style.opacity="0";
        card.style.transform="translateY(20px)";

        setTimeout(()=>{

            card.style.transition=".5s";

            card.style.opacity="1";

            card.style.transform="translateY(0px)";

        },index*150);

    });

});

// Hover Card

document.querySelectorAll(".card").forEach(card=>{

    card.addEventListener("mouseenter",()=>{

        card.style.transform="translateY(-6px)";

    });

    card.addEventListener("mouseleave",()=>{

        card.style.transform="translateY(0px)";

    });

});