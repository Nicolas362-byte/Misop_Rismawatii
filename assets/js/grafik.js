/*==========================================
    GRAFIK.JS
==========================================*/

const ctx=document.getElementById("grafikPenjualan");

if(ctx){

new Chart(ctx,{

type:"bar",

data:{

labels:labels,

datasets:[{

label:"Pendapatan",

data:dataPendapatan,

backgroundColor:"#198754",

borderRadius:8,

borderWidth:0

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

display:false

},

tooltip:{

callbacks:{

label:function(context){

return " Rp "+context.raw.toLocaleString("id-ID");

}

}

}

},

scales:{

y:{

beginAtZero:true,

ticks:{

callback:function(value){

return "Rp "+value.toLocaleString("id-ID");

}

}

}

}

}

});

}