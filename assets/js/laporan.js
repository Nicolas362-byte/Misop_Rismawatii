/*==========================================
    LAPORAN.JS
==========================================*/

// Animasi tabel
document.addEventListener("DOMContentLoaded",()=>{

    document.querySelectorAll("tbody tr").forEach((row,index)=>{

        row.style.opacity="0";
        row.style.transform="translateY(20px)";

        setTimeout(()=>{

            row.style.transition=".35s";

            row.style.opacity="1";

            row.style.transform="translateY(0)";

        },index*60);

    });

});

// Hover
document.querySelectorAll("tbody tr").forEach(row=>{

    row.addEventListener("mouseenter",()=>{

        row.style.background="#f8fff9";

    });

    row.addEventListener("mouseleave",()=>{

        row.style.background="";

    });

});

// Konfirmasi reset filter

const form=document.querySelector(".filter");

if(form){

form.addEventListener("reset",()=>{

location.href="laporan.php";

});

}