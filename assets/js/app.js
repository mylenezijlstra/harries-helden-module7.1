// 👉 Categorieën laden
async function loadCategories() {
    const res = await fetch('/harries-helden-module7.1/api/categories.php');
    const categories = await res.json();

    const sidebar = document.querySelector('.sidebar');
    sidebar.innerHTML = '<h3>Categories</h3>';

    categories.forEach(cat => {
        sidebar.innerHTML += `
            <a href="#" class="cat-btn" onclick="loadProducts(${cat.category_id})">
                ${cat.name}
            </a>
        `;
    });
}

// 👉 Producten laden
async function loadProducts(cat = 1) {
    const res = await fetch(`/harries-helden-module7.1/api/products.php?cat=${cat}`);
    const products = await res.json();

    const container = document.querySelector('.products');
    container.innerHTML = '';

    products.forEach(p => {
        container.innerHTML += `
            <div class="card" onclick="openProduct(${p.product_id})">
                <img src="${p.filename}">
                <div class="card-body">
                    <h3>${p.name}</h3>
                    <p>${p.kcal} kcal</p>
                    <div class="card-footer">
                        <span>€${parseFloat(p.price).toFixed(2)}</span>
                        <button onclick="event.stopPropagation(); addToCart(${p.product_id})">+</button>
                    </div>
                </div>
            </div>
        `;
    });
}

// 👉 Toevoegen aan winkelmandje via API
async function addToCart(id) {
    await fetch('/harries-helden-module7.1/api/cart.php', {
        method: "POST",
        body: JSON.stringify({ product_id: id })
    });

    updateCartInfo();
}

// 👉 Toevoegen + popup sluiten
async function addToCartAndClose(id) {
    await addToCart(id);
    closePopup();
}

// 👉 Winkelmandje info updaten
async function updateCartInfo() {
    const res = await fetch('/harries-helden-module7.1/api/order.php');
    const data = await res.json();

    const bar = document.getElementById('cart-info');

    if (data.error) {
        bar.innerHTML = "<strong>0 items</strong> €0.00";
        return;
    }

    bar.innerHTML = `<strong>${data.items.length} items</strong> €${data.total.toFixed(2)}`;
}

// 👉 Product popup openen
function openProduct(id) {
    fetch(`/harries-helden-module7.1/api/product.php?id=${id}`)
        .then(res => res.json())
        .then(p => {
            const overlay = document.getElementById('popup-overlay');
            const popup = document.getElementById('popup');

            const ingredients = p.ingredienten
                ? p.ingredienten.split(',').map(i => i.trim())
                : [];

            overlay.style.display = 'flex';

            popup.innerHTML = `
                <h2>${p.name}</h2>
                <img src="${p.filename}" style="width:100%; border-radius:15px;">
                <p>${p.kcal} kcal</p>
                <p>€${parseFloat(p.price).toFixed(2)}</p>

                <button id="edit-ingredients-btn">Ingrediënten aanpassen</button>

                <div id="ingredient-list" class="ingredient-list" style="display:none; margin-top:20px;">
                    ${ingredients.map(i => `
                        <label>
                            <input type="checkbox" checked value="${i}">
                            ${i}
                        </label>
                    `).join('')}
                </div>

                <button onclick="addToCartAndClose(${p.product_id})" style="margin-top:20px;">
                    Toevoegen aan bestelling
                </button>

                <button onclick="closePopup()" style="margin-top:10px;">Sluiten</button>
            `;

            // 👉 Ingrediënten-knop functionaliteit
            document.getElementById('edit-ingredients-btn').onclick = () => {
                document.getElementById('ingredient-list').style.display = 'block';
            };
        });
}

// 👉 Popup sluiten
function closePopup() {
    document.getElementById('popup-overlay').style.display = 'none';
}

// 👉 Startpagina laden
loadCategories();
loadProducts(1);
updateCartInfo();
