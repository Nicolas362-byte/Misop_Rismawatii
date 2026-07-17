/*====================================
    MENU.JS
====================================*/

// Pencarian Menu

const search=document.getElementById("searchMenu");

if(search){

search.addEventListener("keyup",function(){

let keyword=this.value.toLowerCase();

document.querySelectorAll("tbody tr").forEach(row=>{

let text=row.innerText.toLowerCase();

row.style.display=text.includes(keyword)?"":"none";

});

});

}

// Hover gambar

document.querySelectorAll("table img").forEach(img=>{

img.addEventListener("mouseenter",()=>{

img.style.transform="scale(1.15)";

img.style.transition=".3s";

});

img.addEventListener("mouseleave",()=>{

img.style.transform="scale(1)";

});

});

// Animasi tabel

document.querySelectorAll("tbody tr").forEach((row,index)=>{

row.style.opacity="0";

row.style.transform="translateY(15px)";

setTimeout(()=>{

row.style.transition=".4s";

row.style.opacity="1";

row.style.transform="translateY(0px)";

},index*70);

});