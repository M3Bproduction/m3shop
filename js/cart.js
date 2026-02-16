function getCart() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Si ancien format détecté (tableau de nombres)
  if (cart.length > 0 && typeof cart[0] === "number") {
    cart = [];
    localStorage.removeItem("cart");
  }

  return cart;
}

function saveCart(cart) {
  localStorage.setItem("cart", JSON.stringify(cart));
}

function updateCartCount() {
  const cart = getCart();
  const cartCount = document.getElementById("cart-count");

  if (cartCount) {
    const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalQuantity;
  }
}

// Ajouter au panier
function addToCart(id) {

  let cart = getCart();

  const existingProduct = cart.find(item => item.id === id);

  if (existingProduct) {
    existingProduct.quantity += 1;
  } else {
    cart.push({ id: id, quantity: 1 });
  }

  saveCart(cart);
  updateCartCount();
}

// Supprimer produit
function removeFromCart(id) {
  let cart = getCart().filter(item => item.id !== id);
  saveCart(cart);
  displayCart();
  updateCartCount();
}

// Modifier quantité
function changeQuantity(id, amount) {

  let cart = getCart();
  const product = cart.find(item => item.id === id);

  if (!product) return;

  product.quantity += amount;

  if (product.quantity <= 0) {
    cart = cart.filter(item => item.id !== id);
  }

  saveCart(cart);
  displayCart();
  updateCartCount();
}

document.addEventListener("DOMContentLoaded", updateCartCount);
