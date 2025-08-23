<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu - Qasr-Delights</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/menu.css">
  <!-- Dropdown Menu CSS (can be moved to separate file) -->
  <style>
   
</style>
</head>
  <!-- Dropdown Menu Button -->
  <button class="menu-button" onclick="toggleMenu()" aria-label="Toggle menu">☰</button>
  
  <!-- Dropdown Menu -->
  <ul id="menu" class="dropdown-menu">
    <li><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
    <li><a href="menu.php"><i class="fas fa-utensils"></i> Menu</a></li>
    <li><a href="about.html"><i class="fas fa-info-circle"></i> About Us</a></li>
    <li><a href="contact.html"><i class="fas fa-envelope"></i> Contact Us</a></li>
    <li><a href="gallery.html"><i class="fas fa-camera"></i> Gallery</a></li>
    <li><a href="branches.html"><i class="fas fa-map-marker-alt"></i> Branches</a></li>
    <li><a href="reservation.php"><i class="fas fa-calendar-check"></i> Reservation</a></li>
    <li><a href="review.php"><i class="fas fa-star"></i> Review</a></li>
  </ul>
  <!-- Cart Icon (Top-Right, next to menu button) -->
<div class="cart-icon" id="cartIcon">
    🛒
    <span class="cart-counter" id="cartCounter">0</span>
</div>

<!-- Cart Popup -->
<div class="cart-popup" id="cartPopup">
    <h4 style="color: var(--gold); border-bottom: 1px solid var(--gold); padding-bottom: 10px; margin-bottom: 15px;">Your Order</h4>
    <div id="cartItemsContainer">
        <p class="empty-cart">Your cart is empty</p>
    </div>
    <div class="cart-total" id="cartTotal">Total:₹0.00</div>
    <button class="btn btn-sm btn-warning w-100 mt-3" onclick="proceedToReservation()" style="background: var(--gold); color: black; border: none;">Proceed to Reservation</button>
</div>
    <!-- Main Content -->
  <div class="main-container">
    <h1 class="menu-heading">OUR MENU</h1>
    
    <div class="menu-grid">
      <div class="divider-3"></div>
      
      <!-- Starters Section -->
      <div class="menu-section">
        <h2 class="section-title">STARTERS</h2>
        <div class="menu-items">
          <div class="menu-item" onclick="showPopup('Hummus Bil Tahini', '₹260', 'Creamy blend of chickpeas, tahini, lemon, and garlic, topped with extra virgin olive oil', '../Menu/Hummus.jpg')">
            <img src="../Menu/Hummus.jpg" alt="Hummus Bil Tahini" class="item-image">
            <div class="item-details">
              <div class="item-name">Hummus Bil Tahini</div>
              <div class="item-price">Price:₹260</div>
              <div class="item-price">Qty:150g (serves 2)</div>
              <div class="item-desc">Creamy blend of chickpeas, tahini, lemon, and garlic, topped with extra virgin olive oil</div>
              <!-- Example for Hummus item (apply to ALL items) -->
                <div class="add-to-cart" onclick="addToCart('Hummus Bil Tahini', 260, '../Menu/Hummus.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Falafel Platter', '₹280 6pcs','Crispy golden chickpea patties served with fresh herbs and tahini dip', '../Menu/Falafel-platter-13.jpg')">
            <img src="../Menu/Falafel-platter-13.jpg" alt="Falafel Platter" class="item-image">
            <div class="item-details">
              <div class="item-name">Falafel Platter</div>
              <div class="item-price">Price:₹280</div>
              <div class="item-price">Qty:6 pcs</div>
              <div class="item-desc">Crispy golden chickpea patties served with fresh herbs and tahini dip</div>
              <div class="add-to-cart" onclick="addToCart('Falafel Platter', 280 , '../Menu/Falafel-platter-13.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Fattoush Salad', '₹240 200g bowl', 'Garden vegetables tossed with toasted pita and a zesty sumac vinaigrette', '../Menu/Fattoushsalad.jpg')">
            <img src="../Menu/Fattoushsalad.jpg" alt="Fattoush Salad" class="item-image">
            <div class="item-details">
              <div class="item-name">Fattoush Salad</div>
              <div class="item-price">Price:₹240</div>
              <div class="item-price">Qty:200g bowl</div>
              <div class="item-desc">Garden vegetables tossed with toasted pita and a zesty sumac vinaigrette</div>
              <div class="add-to-cart" onclick="addToCart('Fattoush Salad',240, '../Menu/Fattoushsalad.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Lentil Soup', '₹220 250ml bowl', 'A warm, comforting bowl of Arabian-style yellow lentil soup with cumin', '../Menu/lentil.jpg')">
            <img src="../Menu/lentil.jpg" alt="Lentil Soup" class="item-image">
            <div class="item-details">
              <div class="item-name">Lentil Soup</div>
              <div class="item-price">Price:₹220</div>
              <div class="item-price">Qty:250ml bowl</div>
              <div class="item-desc">A warm, comforting bowl of Arabian-style yellow lentil soup with cumin</div>
              <div class="add-to-cart" onclick="addToCart('Lentil Soup', 220 , '../Menu/lentil.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Stuffed Vine Leaves (Warak Enab)', '₹300 5 rolls', 'Grape leaves filled with seasoned rice and herbs, served chilled', '../Menu/vineleaves.jpg')">
            <img src="../Menu/vineleaves.jpg" alt="Stuffed Vine Leaves" class="item-image">
            <div class="item-details">
              <div class="item-name">Stuffed Vine Leaves (Warak Enab)</div>
              <div class="item-price">Price:₹300</div>
              <div class="item-price">Qty:5 rolls</div>
              <div class="item-desc">Grape leaves filled with seasoned rice and herbs, served chilled</div>
              <div class="add-to-cart" onclick="addToCart('Stuffed Vine Leaves (Warak Enab)', 300, '../Menu/vineleaves.jpg')">+</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Main Course Section -->
      <div class="menu-section">
        <h2 class="section-title">MAIN COURSE</h2>
        <div class="menu-items">
          <div class="menu-item" onclick="showPopup('Kabsa Chicken', '₹320 (Half) ₹520 (Full)', 'Fragrant basmati rice with spiced chicken, almonds, and golden raisins', '../Menu/Kabsachicken.jpg')">
            <img src="../Menu/Kabsachicken.jpg" alt="Kabsa Chicken" class="item-image">
            <div class="item-details">
              <div class="item-name">Kabsa Chicken</div>
              <div class="item-price">₹320 (Half)₹520 (Full)</div>
              <div class="item-desc">Fragrant basmati rice with spiced chicken, almonds, and golden raisins</div>
              <div class="add-to-cart" onclick="addToCart('Kabsa Chicken',520,'../Menu/Kabsachicken.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Mandi Lamb', '₹340 (Half) ₹560 (Full)', 'Slow-cooked lamb with smoked rice, saffron, and roasted nuts', '../Menu/MandiLamb.jpg')">
            <img src="../Menu/MandiLamb.jpg" alt="Mandi Lamb" class="item-image">
            <div class="item-details">
              <div class="item-name">Mandi Lamb</div>
              <div class="item-price">₹340 (Half)₹560 (Full)</div>
              <div class="item-desc">Slow-cooked lamb with smoked rice, saffron, and roasted nuts.Tender, smoky tradition</div>
              <div class="add-to-cart" onclick="addToCart('Mandi Lamb',560, '../Menu/MandiLamb.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Machboos', '₹330 (Half) ₹540 (Full)', 'Spicy rice dish made with meat, tomatoes, black lime, and saffron', '../Menu/Machboos.jpg')">
            <img src="../Menu/Machboos.jpg" alt="Machboos" class="item-image">
            <div class="item-details">
              <div class="item-name">Machboos</div>
              <div class="item-price">₹330 (Half)₹540 (Full)</div>
              <div class="item-desc">Spicy rice dish made with meat, tomatoes, black lime, and saffron. Bold spice, deep flavor</div>
              <div class="add-to-cart" onclick="addToCart('Machboos',330,, '../Menu/Machboos.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Samak Harra', '₹700', 'Spicy oven-baked fish fillet in tahini-chili sauce with herbed rice', '../Menu/SamakHarra.jpg')">
            <img src="../Menu/SamakHarra.jpg" alt="Samak Harra" class="item-image">
            <div class="item-details">
              <div class="item-name">Samak Harra</div>
              <div class="item-price">₹700</div>
              <div class="item-desc">Spicy oven-baked fish fillet in tahini-chili sauce with herbed rice. Fiery & flavorful from the coast.</div>
              <div class="add-to-cart" onclick="addToCart('Samak Harra',700,'../Menu/SamakHarra.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Vegetable Tagine', '₹320 (Half) ₹420 (Full)', 'Moroccan-style slow-cooked vegetables in an aromatic tomato broth', '../Menu/VegetableTagine.jpg')">
            <img src="../Menu/VegetableTagine.jpg" alt="Vegetable Tagine" class="item-image">
            <div class="item-details">
              <div class="item-name">Vegetable Tagine</div>
              <div class="item-price">₹320 (Half)₹420 (Full)</div>
              <div class="item-desc">Moroccan-style slow-cooked vegetables in an aromatic tomato broth. Slow-cooked comfort.</div>
              <div class="add-to-cart" onclick="addToCart('Vegetable Tagine',420,'../Menu/VegetableTagine.jpg')">+</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Desserts Section -->
      <div class="menu-section">
        <h2 class="section-title">DESSERTS</h2>
        <div class="menu-items">
          <div class="menu-item" onclick="showPopup('Baklava', '₹200 2 pcs', 'Flaky layers of phyllo pastry with pistachios, drenched in rosewater syrup', '../Menu/Baklava.jpg')">
            <img src="../Menu/Baklava.jpg" alt="Baklava" class="item-image">
            <div class="item-details">
              <div class="item-name">Baklava</div>
              <div class="item-price">Price:₹200</div>
              <div class="item-price">Qty:2 pcs</div>
              <div class="item-desc">Flaky layers of phyllo pastry with pistachios, drenched in rosewater syrup</div>
              <div class="add-to-cart" onclick="addToCart('Baklava',200, '../Menu/Baklava.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Basbousa', '₹180 1 square', 'Moist semolina cake soaked in sweet rose syrup and topped with almonds', '../Menu/Basbousa.jpg')">
            <img src="../Menu/Basbousa.jpg" alt="Basbousa" class="item-image">
            <div class="item-details">
              <div class="item-name">Basbousa</div>
              <div class="item-price">Price:₹180</div>
              <div class="item-price">Qty:1 square</div>
              <div class="item-desc">Moist semolina cake soaked in sweet rose syrup,topped with almonds</div>
              <div class="add-to-cart" onclick="addToCart('Basbousa',180, '../Menu/Basbousa.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Kunafa', '₹250 1 slice (150g)', 'Crispy kadaif pastry layered with cheese and finished with warm syrup', '../Menu/Kunafa.jpg')">
            <img src="../Menu/Kunafa.jpg" alt="Kunafa" class="item-image">
            <div class="item-details">
              <div class="item-name">Kunafa</div>
              <div class="item-price">Price:₹250</div>
              <div class="item-price">Qty:1 slice</div>
              <div class="item-desc">Crispy kadaif pastry layered with cheese and finished with warm syrup.Crisp top.</div>
              <div class="add-to-cart" onclick="addToCart('Kunafa',250,'../Menu/Kunafa.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Dates & Cream', '₹160 5 dates + cream', 'Premium Arabian dates served with whipped cream and crushed nuts', '../Menu/Dates.jpg')">
            <img src="../Menu/Dates.jpg" alt="Dates & Cream" class="item-image">
            <div class="item-details">
              <div class="item-name">Dates & Cream</div>
              <div class="item-price">Price:₹160</div>
              <div class="item-price">Qty:5 dates + cream</div>
              <div class="item-desc">Premium Arabian dates served with whipped cream and crushed nuts</div>
              <div class="add-to-cart" onclick="addToCart('Dates & Cream',160,'../Menu/Dates.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Um Ali', '₹220 Bowl (200g)', 'Rich bread pudding with warm milk, nuts, and golden raisins', '../Menu/UmAli.jpg')">
            <img src="../Menu/UmAli.jpg" alt="Um Ali" class="item-image">
            <div class="item-details">
              <div class="item-name">Um Ali</div>
              <div class="item-price">Price:₹220</div>
              <div class="item-price">Qty:Bowl (200g)</div>
              <div class="item-desc">Rich bread pudding with warm milk, nuts, and golden raisins</div>
              <div class="add-to-cart" onclick="addToCart('Um Ali',220,'../Menu/UmAli.jpg')">+</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Beverages Section -->
      <div class="menu-section">
        <h2 class="section-title">BEVERAGES</h2>
        <div class="menu-items">
          <div class="menu-item" onclick="showPopup('Arabic Qahwa', '₹140 120ml', 'Lightly roasted Arabic coffee brewed with cardamom.Spiced elegance in a cup', '../Menu/ArabicQahwa.jpg')">
            <img src="../Menu/ArabicQahwa.jpg" alt="Arabic Qahwa" class="item-image">
            <div class="item-details">
              <div class="item-name">Arabic Qahwa</div>
              <div class="item-price">Price:₹140</div>
              <div class="item-price">Qty:120ml</div>
              <div class="item-desc">Lightly roasted Arabic coffee brewed with cardamom.Spiced elegance in a cup.</div>
              <div class="add-to-cart" onclick="addToCart('Arabic Qahwa',140,'../Menu/ArabicQahwa.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Mint Tea', '₹100 150ml', 'Sweet Moroccan-style green tea with fresh mint.Freshness in every sip.', '../Menu/MintTea.jpg')">
            <img src="../Menu/MintTea.jpg" alt="Mint Tea" class="item-image">
            <div class="item-details">
              <div class="item-name">Mint Tea</div>
              <div class="item-price">₹100</div>
              <div class="item-price">Qty:150ml</div>
              <div class="item-desc">Sweet Moroccan-style green tea with fresh mint.Freshness in every sip.</div>
              <div class="add-to-cart" onclick="addToCart('Mint Tea',100,'../Menu/MintTea.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Rose Lemonade', '₹130 200ml', 'Refreshing lemonade infused with rose petals.Floral fizz & chill.', '../Menu/RoseLemonade.jpg')">
            <img src="../Menu/RoseLemonade.jpg" alt="Rose Lemonade" class="item-image">
            <div class="item-details">
              <div class="item-name">Rose Lemonade</div>
              <div class="item-price">₹130</div>
              <div class="item-price">Qty:200ml</div>
              <div class="item-desc">Refreshing lemonade infused with rose petals,Floral fizz & chill.</div>
              <div class="add-to-cart" onclick="addToCart('Rose Lemonade',130,'../Menu/RoseLemonade.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Jallab', '₹150 250ml', 'Cold drink made with date syrup, raisins, and pine nuts.Sweet Arabian energy.', '../Menu/Jallab.jpg')">
            <img src="../Menu/Jallab.jpg" alt="Jallab" class="item-image">
            <div class="item-details">
              <div class="item-name">Jallab</div>
              <div class="item-price">₹150</div>
              <div class="item-price">Qty:250ml</div>
              <div class="item-desc">Cold drink made with date syrup, raisins, and pine nuts,Sweet Arabian energy.</div>
              <div class="add-to-cart" onclick="addToCart('Jallab',150,'../Menu/Jallab.jpg')">+</div>
            </div>
          </div>
          
          <div class="menu-item" onclick="showPopup('Laban Ayran', '₹120 250ml', 'Chilled yogurt drink seasoned with mint and salt,Cool, tangy, refreshing.', '../Menu/LabanAyran.jpg')">
            <img src="../Menu/LabanAyran.jpg" alt="Laban Ayran" class="item-image">
            <div class="item-details">
              <div class="item-name">Laban Ayran</div>
              <div class="item-price">₹120</div>
              <div class="item-price">Qty:250ml </div>
              <div class="item-desc">Chilled yogurt drink seasoned with mint and salt,Cool, tangy, refreshing.</div>
              <div class="add-to-cart" onclick="addToCart('Laban Ayran',120)">+</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Item Popup -->
  <div class="item-popup" id="itemPopup">
    <div class="popup-content">
      <button class="close-popup" onclick="closePopup()">&times;</button>
      <img src="" alt="Menu Item" class="popup-image" id="popupImage">
      <div class="popup-details">
        <h2 class="popup-name" id="popupName"></h2>
        <div class="popup-price" id="popupPrice"></div>
        <p class="popup-desc" id="popupDesc"></p>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="arabian-footer">
    <div class="container">
      <div class="footer-links">
        <a href="index.html">Home</a>
        <a href="menu.php">Menu</a>
        <a href="about.html">About Us</a>
        <a href="contact.html">Contact</a>
        <a href="gallery.html">Gallery</a>
        <a href="branches.html">Branches</a>
        <a href="reservation.php">Reservation</a>
        <a href="review.php">Reviews</a>
      </div>
      <div class="copyright">
      © 2025 Qasr Delights | Arabian Fine Dining. All rights reserved.
      </div>
    </div>
  </footer>
  
  <!-- JavaScript (can be moved to separate file) -->
  <script>
    // Dropdown Menu Functions
    function toggleMenu() {
      const menu = document.getElementById("menu");
      menu.classList.toggle("show");
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
      const menuButton = document.querySelector('.menu-button');
      const dropdownMenu = document.getElementById('menu');
      
      if (!menuButton.contains(event.target)) {
        dropdownMenu.classList.remove('show');
      }
    });
    
    // Item Popup Functions
    function showPopup(name, price, desc, image) {
      document.getElementById('popupName').textContent = name;
      document.getElementById('popupPrice').textContent = price;
      document.getElementById('popupDesc').textContent = desc;
      document.getElementById('popupImage').src = image;
      document.getElementById('itemPopup').style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }
    
    function closePopup() {
      document.getElementById('itemPopup').style.display = 'none';
      document.body.style.overflow = 'auto';
    }
    
    // Close popup when clicking outside content
    document.getElementById('itemPopup').addEventListener('click', function(e) {
      if (e.target === this) {
        closePopup();
      }
    });
  </script>
<script>
// UPDATED CART MANAGEMENT SYSTEM (FIXED DISPLAY + QUANTITY)
let cart = [];
let orderLocked = false;

// 1. MODIFIED ADD TO CART (NOW HANDLES QUANTITY)
function addToCart(name, price, image) {
    if (orderLocked) {
        alert("Your order is being processed. Cannot modify cart now.");
        return;
    }
    
    // Check if item already exists in cart
    const existingItemIndex = cart.findIndex(item => item.name === name);
    if (existingItemIndex >= 0) {
        // Increment quantity if item exists
        cart[existingItemIndex].quantity += 1;
    } else {
        // Add new item with quantity 1
        cart.push({
            name: name,
            price: Number(price) || 0,
            quantity: 1,
            image: image || 'placeholder.jpg'
        });
    }
    updateCartDisplay();
}

// 2. MODIFIED UPDATE DISPLAY (SHOWS QUANTITY)
function updateCartDisplay() {
    const container = document.getElementById('cartItemsContainer');
    
    // Clear previous items
    container.innerHTML = '';
    
    // Add current items
    if (cart.length === 0) {
        container.innerHTML = '<p class="empty-cart">Your cart is empty</p>';
    } else {
        cart.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <span>${item.name} ${item.quantity > 1 ? '(×' + item.quantity + ')' : ''}</span>
                <span>₹${(item.price * item.quantity).toFixed(2)}</span>
                <span class="remove-item" onclick="removeFromCart(${index})">×</span>
            `;
            container.appendChild(itemElement);
        });
    }
    
    // Update total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('cartTotal').textContent = `Total: ₹${total.toFixed(2)}`;
    document.getElementById('cartCounter').textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
}

// 3. REST OF YOUR ORIGINAL CODE (EXACTLY AS IS)
function removeFromCart(index) {
    if (orderLocked) {
        alert("Your order is being processed. Cannot modify cart now.");
        return;
    }
    cart.splice(index, 1);
    updateCartDisplay();
}

function proceedToReservation() {
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    if (confirm("Lock your order and proceed to reservation?")) {
        orderLocked = true;
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../php/process_order.php';
        
        // Add each cart item as separate form fields
        cart.forEach((item, index) => {
            addHiddenInput(form, `items[${index}][name]`, item.name);
            addHiddenInput(form, `items[${index}][price]`, item.price);
            addHiddenInput(form, `items[${index}][quantity]`, item.quantity);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Helper function to add hidden inputs
function addHiddenInput(form, name, value) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    form.appendChild(input);
}
document.addEventListener('DOMContentLoaded', () => {
    fetch('../php/get_cart.php')
        .then(response => response.json())
        .then(data => {
            if (data.cart) {
                cart = data.cart;
                updateCartDisplay();
            }
        })
        .catch(console.error);

    document.getElementById('cartIcon').addEventListener('click', function() {
        const popup = document.getElementById('cartPopup');
        popup.classList.toggle('show');
        if (popup.classList.contains('show')) {
            updateCartDisplay();
        }
    });
});
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>