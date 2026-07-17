/*==========================================
    KASIR.JS
==========================================*/

let cart = [];

/*==========================================
    ELEMENT
==========================================*/

const cartList = document.getElementById("cartList");

const subtotalText = document.getElementById("subtotalText");
const diskonText = document.getElementById("diskonText");
const pajakText = document.getElementById("pajakText");
const totalText = document.getElementById("totalText");

const subtotalInput = document.getElementById("subtotal");
const diskonInput = document.getElementById("diskon");
const pajakInput = document.getElementById("pajak");
const totalInput = document.getElementById("total");

const cartData = document.getElementById("cartData");

const customer = document.getElementById("customer");

const metode = document.getElementById("metode");

const bayar = document.getElementById("bayar");

const kembalian = document.getElementById("kembalian");

const formKasir = document.getElementById("formKasir");

const btnSimpan = document.getElementById("btnSimpan");

/*==========================================
    QRIS
==========================================*/

const qrisModal = document.getElementById("qrisModal");

const totalQris = document.getElementById("totalQris");

const timerQris = document.getElementById("timerQris");

const btnKonfirmasi = document.getElementById("btnKonfirmasi");

const btnBatal = document.getElementById("btnBatal");

let countdown = null;

let sisaDetik = 60;

let qrisSelesai = false;

/*==========================================
    TAMBAH MENU
==========================================*/

document.querySelectorAll(".tambah").forEach(btn=>{

    btn.addEventListener("click",function(){

        const card = this.parentElement;

        const id = parseInt(card.dataset.id);

        const nama = card.dataset.nama;

        const harga = parseInt(card.dataset.harga);

        const stok = parseInt(card.dataset.stok);

        const cek = cart.find(item=>item.id===id);

        if(cek){

            if(cek.qty < stok){

                cek.qty++;

            }

        }else{

            cart.push({

                id:id,

                nama:nama,

                harga:harga,

                stok:stok,

                qty:1

            });

        }

        renderCart();

    });

});
/*==========================================
    RENDER CART
==========================================*/

function renderCart(){

    cartList.innerHTML="";

    if(cart.length===0){

        cartList.innerHTML='<p class="empty">Belum ada menu dipilih.</p>';

        hitungTotal();

        return;

    }

    cart.forEach((item,index)=>{

        cartList.innerHTML += `

        <div class="cart-item">

            <div>

                <b>${item.nama}</b><br>

                Rp ${item.harga.toLocaleString("id-ID")}

            </div>

            <div class="qty-control">

                <button
                    type="button"
                    class="qty-btn"
                    onclick="kurang(${index})">

                    -

                </button>

                <span>${item.qty}</span>

                <button
                    type="button"
                    class="qty-btn"
                    onclick="tambah(${index})">

                    +

                </button>

            </div>

        </div>

        `;

    });

    hitungTotal();

}

/*==========================================
    QUANTITY
==========================================*/

function tambah(index){

    if(cart[index].qty < cart[index].stok){

        cart[index].qty++;

    }

    renderCart();

}

function kurang(index){

    cart[index].qty--;

    if(cart[index].qty<=0){

        cart.splice(index,1);

    }

    renderCart();

}

/*==========================================
    HITUNG TOTAL
==========================================*/

function hitungTotal(){

    let subtotal=0;

    cart.forEach(item=>{

        subtotal += item.harga * item.qty;

    });

    let diskon=0;

    if(subtotal>=100000){

        diskon=Math.round(subtotal*0.05);

    }

    let setelahDiskon=subtotal-diskon;

    let pajak=Math.round(setelahDiskon*0.10);

    let total=setelahDiskon+pajak;

    subtotalText.innerHTML="Rp "+subtotal.toLocaleString("id-ID");

    diskonText.innerHTML="Rp "+diskon.toLocaleString("id-ID");

    pajakText.innerHTML="Rp "+pajak.toLocaleString("id-ID");

    totalText.innerHTML="Rp "+total.toLocaleString("id-ID");

    subtotalInput.value=subtotal;

    diskonInput.value=diskon;

    pajakInput.value=pajak;

    totalInput.value=total;

    cartData.value=JSON.stringify(cart);

    /*=========================
        TOTAL QRIS
    =========================*/

    totalQris.innerHTML="Rp "+total.toLocaleString("id-ID");

    hitungKembalian();

}

/*==========================================
    HITUNG KEMBALIAN
==========================================*/

bayar.addEventListener("keyup",hitungKembalian);

bayar.addEventListener("change",hitungKembalian);

metode.addEventListener("change",function(){

    if(this.value==="QRIS"){

        bayar.disabled=true;

        bayar.style.background="#e9ecef";

        bayar.placeholder="Pembayaran melalui QRIS";

        kembalian.disabled=true;

        kembalian.value="-";

        kembalian.style.background="#e9ecef";

    }else{

        bayar.disabled=false;

        bayar.placeholder="Masukkan nominal pembayaran";

        bayar.style.background="#fff";

        kembalian.disabled=false;

        kembalian.style.background="#fff";

        hitungKembalian();

    }

});

function hitungKembalian(){

    if(metode.value==="QRIS"){

        return;

    }

    const total=parseInt(totalInput.value)||0;

    const uang=parseInt(bayar.value)||0;

    let kembali=uang-total;

    if(kembali<0){

        kembali=0;

    }

    kembalian.value="Rp "+kembali.toLocaleString("id-ID");

}
/*==========================================
    VALIDASI FORM
==========================================*/

formKasir.addEventListener("submit", function(e){

    if(cart.length===0){

        alert("Keranjang masih kosong!");

        e.preventDefault();

        return;

    }

    if(customer.value.trim()===""){

        alert("Nama customer belum diisi!");

        customer.focus();

        e.preventDefault();

        return;

    }

    /*==================================
        PEMBAYARAN QRIS
    ==================================*/

    if(metode.value==="QRIS"){

        e.preventDefault();

        totalQris.innerHTML=
        "Rp "+Number(totalInput.value).toLocaleString("id-ID");

        qrisModal.style.display="flex";

        mulaiTimer();

        return;

    }

    /*==================================
        PEMBAYARAN TUNAI
    ==================================*/

    const total=Number(totalInput.value);

    const uang=Number(bayar.value);

    if(uang<total){

        alert("Nominal pembayaran kurang!");

        bayar.focus();

        e.preventDefault();

        return;

    }

});

/*==========================================
    TIMER QRIS
==========================================*/

function mulaiTimer(){

    clearInterval(countdown);

    sisaDetik=60;

    updateTimer();

    countdown=setInterval(function(){

        sisaDetik--;

        updateTimer();

        if(sisaDetik<=0){

            clearInterval(countdown);

            alert("QRIS Expired!");

            qrisModal.style.display="none";

        }

    },1000);

}

function updateTimer(){

    let menit=Math.floor(sisaDetik/60);

    let detik=sisaDetik%60;

    timerQris.innerHTML=

    String(menit).padStart(2,"0")

    +

    ":"

    +

    String(detik).padStart(2,"0");

}

/*==========================================
    QRIS BERHASIL
==========================================*/

btnKonfirmasi.addEventListener("click",function(){

    clearInterval(countdown);

    qrisModal.style.display="none";

    bayar.disabled = false;

    bayar.value = totalInput.value;

    formKasir.submit();

});

/*==========================================
    QRIS DIBATALKAN
==========================================*/

btnBatal.addEventListener("click",function(){

    clearInterval(countdown);

    qrisModal.style.display="none";

});

/*==========================================
    TUTUP MODAL
==========================================*/

window.addEventListener("click",function(e){

    if(e.target===qrisModal){

        clearInterval(countdown);

        qrisModal.style.display="none";

    }

});

/*==========================================
    LOAD
==========================================*/

renderCart();