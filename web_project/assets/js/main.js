/**
 * LMH E-commerce - Main JavaScript
 * Version: 1.0
 */

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Mobile nav toggle
    const mobileNavToggle = document.querySelector('.navbar-toggler');
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener('click', function() {
            document.body.classList.toggle('mobile-nav-active');
        });
    }
    
    // Flash message auto close
    const flashMessages = document.querySelectorAll('.alert-dismissible');
    flashMessages.forEach(function(flash) {
        setTimeout(function() {
            const closeButton = flash.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            }
        }, 5000); // Auto close after 5 seconds
    });
    
    // Product quantity control in product detail page
    const quantityDecrease = document.getElementById('decrease-quantity');
    const quantityIncrease = document.getElementById('increase-quantity');
    const quantityInput = document.getElementById('quantity');
    
    if (quantityDecrease && quantityIncrease && quantityInput) {
        quantityDecrease.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        quantityIncrease.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            let maxValue = parseInt(quantityInput.getAttribute('max'));
            
            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        });
        
        quantityInput.addEventListener('change', function() {
            let currentValue = parseInt(this.value);
            let minValue = parseInt(this.getAttribute('min'));
            let maxValue = parseInt(this.getAttribute('max'));
            
            if (currentValue < minValue) {
                this.value = minValue;
            } else if (currentValue > maxValue) {
                this.value = maxValue;
            }
        });
    }
    
    // Add to cart functionality
    const addToCartForm = document.getElementById('add-to-cart-form');
    
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const productId = this.querySelector('[name="product_id"]').value;
            const quantity = parseInt(this.querySelector('[name="quantity"]').value);
            
            addToCart(productId, quantity);
        });
    }
    
    // Buy now button
    const buyNowBtn = document.getElementById('buy-now-btn');
    
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            const productId = document.querySelector('[name="product_id"]').value;
            const quantity = parseInt(document.querySelector('[name="quantity"]').value);
            
            addToCart(productId, quantity, true);
        });
    }
    
    // Function to add product to cart
    function addToCart(productId, quantity, redirectToCheckout = false) {
        // AJAX request to add item to cart
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count in navbar
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cart_count;
                    
                    // Make sure cart count badge is visible
                    cartCountElement.classList.remove('d-none');
                }
                
                if (redirectToCheckout) {
                    // Redirect to checkout page
                    window.location.href = '/checkout';
                } else {
                    // Show success notification
                    showNotification('Sản phẩm đã được thêm vào giỏ hàng!', 'success');
                }
            } else {
                showNotification(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
        });
    }
    
    // Function to show notification
    function showNotification(message, type = 'success') {
        // Check if notification container exists, if not create it
        let notificationContainer = document.querySelector('.notification-container');
        
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.className = 'notification-container position-fixed top-0 end-0 p-3';
            notificationContainer.style.zIndex = '1050';
            document.body.appendChild(notificationContainer);
        }
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
        notification.setAttribute('role', 'alert');
        notification.setAttribute('aria-live', 'assertive');
        notification.setAttribute('aria-atomic', 'true');
        
        notification.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        notificationContainer.appendChild(notification);
        
        // Initialize and show toast
        const toast = new bootstrap.Toast(notification, {
            delay: 3000
        });
        
        toast.show();
        
        // Remove notification after it's hidden
        notification.addEventListener('hidden.bs.toast', function() {
            notification.remove();
        });
    }
    
    // Product gallery image change
    const galleryThumbnails = document.querySelectorAll('.thumbnail-image img');
    const mainImage = document.getElementById('main-product-image');
    
    if (galleryThumbnails.length > 0 && mainImage) {
        galleryThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                // Update active class on thumbnails
                galleryThumbnails.forEach(thumb => {
                    thumb.classList.remove('border-primary');
                });
                
                this.classList.add('border-primary');
                
                // Update main image
                mainImage.src = this.getAttribute('src');
            });
        });
    }
    
    // Cart page - quantity update
    const cartQuantityInputs = document.querySelectorAll('.cart-page .item-quantity');
    
    if (cartQuantityInputs.length > 0) {
        cartQuantityInputs.forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.getAttribute('data-item-id');
                const quantity = parseInt(this.value);
                
                updateCartItemQuantity(itemId, quantity);
            });
        });
    }
    
    // Cart page - remove item
    const removeItemButtons = document.querySelectorAll('.cart-page .remove-item-btn');
    
    if (removeItemButtons.length > 0) {
        removeItemButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                    const itemId = this.getAttribute('data-item-id');
                    removeCartItem(itemId);
                }
            });
        });
    }
    
    // Function to update cart item quantity
    function updateCartItemQuantity(itemId, quantity) {
        // AJAX request to update quantity
        fetch('/cart/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                item_id: itemId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count in navbar
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cart_count;
                }
                
                // Update item total and cart summary
                updateCartDisplay(data);
                
                showNotification('Giỏ hàng đã được cập nhật.', 'success');
            } else {
                showNotification(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
        });
    }
    
    // Function to remove cart item
    function removeCartItem(itemId) {
        // AJAX request to remove item
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                item_id: itemId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart count in navbar
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cart_count;
                }
                
                // Remove item row
                const itemRow = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                if (itemRow) {
                    itemRow.remove();
                }
                
                // Update cart summary
                updateCartDisplay(data);
                
                // If cart is empty, reload the page
                if (data.is_empty) {
                    location.reload();
                }
                
                showNotification('Sản phẩm đã được xóa khỏi giỏ hàng.', 'success');
            } else {
                showNotification(data.message || 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
        });
    }
    
    // Function to update cart display
    function updateCartDisplay(data) {
        // Update cart subtotal
        const subtotalElement = document.getElementById('cart-subtotal');
        if (subtotalElement) {
            subtotalElement.textContent = data.formatted_subtotal;
        }
        
        // Update shipping
        const shippingElement = document.getElementById('cart-shipping');
        if (shippingElement) {
            if (data.cart_shipping > 0) {
                shippingElement.textContent = data.formatted_shipping;
            } else {
                shippingElement.innerHTML = '<span class="text-success">Miễn phí</span>';
            }
        }
        
        // Update total
        const totalElement = document.getElementById('cart-total');
        if (totalElement) {
            totalElement.textContent = data.formatted_total;
        }
    }
});