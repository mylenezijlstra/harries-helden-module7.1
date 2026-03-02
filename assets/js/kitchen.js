// =============================
// Kitchen Display System (KDS)
// =============================

const BASE_URL = '/harries-helden-module7.1/api';
const REFRESH_INTERVAL = 5000; // 5 seconds

// Fetch all orders and render them
async function loadKitchenOrders() {
    try {
        const res = await fetch(`${BASE_URL}/kitchen.php`);
        const orders = await res.json();

        const placed = orders.filter(o => o.order_status_id == 2);
        const preparing = orders.filter(o => o.order_status_id == 3);
        const ready = orders.filter(o => o.order_status_id == 4);

        renderColumn('orders-placed', placed, 3, kitchenTranslations.btn_start);
        renderColumn('orders-preparing', preparing, 4, kitchenTranslations.btn_ready);
        renderColumn('orders-ready', ready, 5, kitchenTranslations.btn_picked);

        document.getElementById('count-placed').textContent = placed.length;
        document.getElementById('count-preparing').textContent = preparing.length;
        document.getElementById('count-ready').textContent = ready.length;
    } catch (err) {
        console.error('Failed to load kitchen orders:', err);
    }
}


// Render order cards into a column
function renderColumn(containerId, orders, nextStatusId, btnLabel) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';

    orders.forEach(order => {
        const card = document.createElement('div');
        card.className = 'order-card';

        const elapsed = getElapsedTime(order.datetime);

        const productList = order.products.map(p =>
            `<li>${p.name}</li>`
        ).join('');

        card.innerHTML = `
            <div class="order-card-header">
                <span class="order-number">#${String(order.pickup_number).padStart(3, '0')}</span>
                <span class="order-time">${elapsed}</span>
            </div>
            <ul class="order-products">${productList}</ul>
            <div class="order-card-footer">
                <span class="order-total">€${parseFloat(order.price_total).toFixed(2)}</span>
                <button class="status-btn" onclick="advanceOrder(${order.order_id}, ${nextStatusId})">${btnLabel}</button>
            </div>
        `;

        container.appendChild(card);
    });
}


// Advance an order to the next status
async function advanceOrder(orderId, newStatusId) {
    try {
        await fetch(`${BASE_URL}/update_status.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                order_id: orderId,
                new_status_id: newStatusId
            })
        });

        // Immediately reload after status change
        loadKitchenOrders();
    } catch (err) {
        console.error('Failed to update order status:', err);
    }
}


// Calculate elapsed time since order was placed
function getElapsedTime(datetime) {
    const orderTime = new Date(datetime);
    const now = new Date();
    const diffMs = now - orderTime;
    const diffMin = Math.floor(diffMs / 60000);

    if (diffMin < 1) return kitchenTranslations.time_now;
    return `${diffMin} ${kitchenTranslations.time_min}`;
}


// Update the clock display
function updateClock() {
    const now = new Date();
    const timeStr = now.toLocaleTimeString('nl-NL', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    document.getElementById('kitchen-clock').textContent = timeStr;
}


// Initialize
loadKitchenOrders();
updateClock();

// Auto-refresh orders every 5 seconds
setInterval(loadKitchenOrders, REFRESH_INTERVAL);

// Update clock every second
setInterval(updateClock, 1000);
