<?php
require_once __DIR__ . '/../Controllers/SaleController.php';
require_once __DIR__ . '/../../../db.php';
require_once __DIR__ . '/../../Product/Controllers/ProductController.php';

$error = '';
$success = '';

// Instantiate the SaleController
$saleController = new SaleController($conn);

// Get products
$productController = new ProductController($conn);
$products = $productController->getProducts();


// Convert Product objects to arrays if needed
$productsArray = [];
foreach ($products as $product) {
    // Check if $product is an object or array
    if (is_object($product)) {
        $productsArray[] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            
        ];
    } else {
        $productsArray[] = $product; // Already an array
    }
}
// Replace $products with our array version
$products = $productsArray;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $total = 0;
        $productsSelected = [];

        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            throw new Exception("Debe seleccionar al menos un producto.");
        }

        $product_ids = $_POST['product_id'];
        $quantities = $_POST['quantity'];

        foreach ($product_ids as $index => $prod_id) {
            $qty = (int)$quantities[$index];
            if ($qty <= 0) continue;
            $productsSelected[] = [
            'product_id' => $prod_id,
                'quantity' => $qty
                      
            ];
        }

        if (empty($productsSelected)) {
            throw new Exception("Debe seleccionar al menos un producto con cantidad válida.");
        }

        foreach ($productsSelected as $p) {
            foreach ($products as $prod) {
                if ($prod['id'] == $p['product_id']) {
                    $total += $prod['price'] * $p['quantity'];
                    break;
                }
            }
        }

        $data = [
            'total' => $total,
            'payment_method' => $_POST['payment_method'] ?? 'efectivo',
            'payment_details' => $_POST['payment_details'] ?? '',
            'status' => $_POST['status'] ?? 'Completada',
            'user_id' => 1,  // Por ahora fijo
            'shipping_name' => $_POST['shipping_name'] ?? '',
            'shipping_address' => $_POST['shipping_address'] ?? '',
            'shipping_city' => $_POST['shipping_city'] ?? '',
            'shipping_phone' => $_POST['shipping_phone'] ?? '',
            'products' => $productsSelected,
        ];

        // Handle specific payment method details
        switch($_POST['payment_method']) {
            case 'efectivo':
                $data['payment_details'] = json_encode([
                    'cash_received' => $_POST['cash_received'] ?? 0
                ]);
                break;
            case 'tarjeta_debito':
                $data['payment_details'] = json_encode([
                    'card_number' => $_POST['card_number_debit'] ?? '',
                    'card_holder' => $_POST['card_holder_debit'] ?? ''
                ]);
                break;
            case 'tarjeta_credito':
                $data['payment_details'] = json_encode([
                    'card_number' => $_POST['card_number_credit'] ?? '',
                    'card_holder' => $_POST['card_holder_credit'] ?? '',
                    'installments' => $_POST['installments'] ?? 1
                ]);
                break;
            case 'transferencia':
                $data['payment_details'] = json_encode([
                    'bank' => $_POST['bank'] ?? '',
                    'reference_number' => $_POST['reference_number'] ?? ''
                ]);
                break;
        }

        $saleController->createSale($data,$paymentData);
        $success = "Venta creada exitosamente.";
        header("Location: index.php?success=1");
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #selected-products {
            margin-top: 20px;
        }
        #selected-products table {
            width: 100%;
        }
        #selected-products th, #selected-products td {
            padding: 8px;
            text-align: center;
        }
        .modal-backdrop {
            opacity: 0.5;
        }
    </style>
    <script>
        // Productos disponibles desde PHP (pasados a JS)
        const products = <?php echo json_encode($products); ?>;
        let selectedProducts = [];

        function openProductModal() {
            // Mostrar el modal
            const productModal = new bootstrap.Modal(document.getElementById('productModal'));
            productModal.show();
        }

        function addProductFromModal() {
    const modalProductSelect = document.getElementById('modal-product');
    const modalQuantityInput = document.getElementById('modal-quantity');
    
    const productId = parseInt(modalProductSelect.value);
    const quantity = parseInt(modalQuantityInput.value);

    console.log("Seleccionado ID:", productId);
    console.log("Cantidad:", quantity);
    console.log("Productos:", products);
    
    if (!productId || isNaN(quantity) || quantity <= 0) {
        alert('Por favor, seleccione un producto y una cantidad válida');
        return;
    }
    
    const product = products.find(p => parseInt(p.id) === parseInt(productId));

    console.log("Producto encontrado:", product);

     if (!product) {
        alert('Producto no encontrado');
        return;
    }
    
    const existingIndex = selectedProducts.findIndex(p => p.id === productId);
    if (existingIndex !== -1) {
        const newQuantity = selectedProducts[existingIndex].quantity + quantity;
        if (newQuantity > product.stock) {
            alert(`No hay suficiente stock. Stock disponible: ${product.stock}`);
            return;
        }
        selectedProducts[existingIndex].quantity = newQuantity;
        selectedProducts[existingIndex].subtotal = product.price * newQuantity;
    } else {
        if (quantity > product.stock) {
            alert(`No hay suficiente stock. Stock disponible: ${product.stock}`);
            return;
        }
        selectedProducts.push({
            id: product.id,
            name: product.name,
            price: product.price,
            quantity: quantity,
            subtotal: product.price * quantity
        });
    }

    updateSelectedProducts();

    const productModalElement = document.getElementById('productModal');
    const productModal = bootstrap.Modal.getInstance(productModalElement);
    if (productModal) productModal.hide();

    modalProductSelect.value = '';
    modalQuantityInput.value = '1';
    modalQuantityInput.max = '';
    modalQuantityInput.disabled = true;
}


        function removeProduct(index) {
            selectedProducts.splice(index, 1);
            updateSelectedProducts();
        }

        function updateSelectedProducts() {
            const selectedProductsDiv = document.getElementById('selected-products');
            let html = `
                <h4>Productos seleccionados</h4>
                <table class="table">
                    <thead>
                        <tr class="table-light">
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            let total = 0;

            if (selectedProducts.length === 0) {
                html += `
                    <tr>
                        <td colspan="5" class="text-center">No hay productos seleccionados</td>
                    </tr>
                `;
            } else {
                selectedProducts.forEach((product, index) => {
                    const subtotal = product.price * product.quantity;
                    total += subtotal;
                    
                    html += `
                        <tr>
    <td>${product.name}</td>
    <td>${product.quantity}</td>
    <td>
        ${product.has_promotion
          ? `<del>${parseFloat(product.price).toFixed(2)}</del> <strong>${(product.price_with_discount).toFixed(2)}</strong>`
          : parseFloat(product.price).toFixed(2)}
    </td>
    <td>
        ${product.has_promotion
          ? (product.price_with_discount * product.quantity).toFixed(2)
          : (product.price * product.quantity).toFixed(2)}
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-danger" onclick="removeProduct(${index})">
            <i class="bi bi-trash"></i> Eliminar
        </button>
    </td>
</tr>

                    `;
                });
            }

            html += `
                    </tbody>
                </table>
                <h5>Total: $<span id="total-amount">${total.toFixed(2)}</span></h5>
            `;

            selectedProductsDiv.innerHTML = html;

            // Actualiza campo total oculto para enviar al backend
            document.getElementById('total').value = total.toFixed(2);

            // Actualiza cálculo de efectivo y cambio si visible
            if (document.getElementById('payment_method').value === 'efectivo') {
                calcularCambio();
            }

            // Preparar los campos ocultos para el envío del formulario
            const productIdsContainer = document.getElementById('product-ids-container');
            productIdsContainer.innerHTML = '';

            selectedProducts.forEach((product, index) => {
                const productIdInput = document.createElement('input');
                productIdInput.type = 'hidden';
                productIdInput.name = 'product_id[]';
                productIdInput.value = product.id;
                productIdsContainer.appendChild(productIdInput);

                const quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = 'quantity[]';
                quantityInput.value = product.quantity;
                productIdsContainer.appendChild(quantityInput);
            });
        }

        function onModalProductChange() {
            const productSelect = document.getElementById('modal-product');
            const quantityInput = document.getElementById('modal-quantity');
            
            if (!productSelect.value) {
                quantityInput.disabled = true;
                quantityInput.value = '';
                return;
            }
            
            const selectedProduct = products.find(p => p.id == productSelect.value);
            if (!selectedProduct) {
                quantityInput.disabled = true;
                quantityInput.value = '';
                return;
            }
            
            quantityInput.disabled = false;
            quantityInput.max = selectedProduct.stock;
            quantityInput.value = '1';
        }

        function onPaymentMethodChange() {
            const method = document.getElementById('payment_method').value;
            const contEfectivo = document.getElementById('payment-cash');
            const contDebito = document.getElementById('payment-debit');
            const contCredito = document.getElementById('payment-credit');
            const contTransferencia = document.getElementById('payment-transfer');

            contEfectivo.style.display = 'none';
            contDebito.style.display = 'none';
            contCredito.style.display = 'none';
            contTransferencia.style.display = 'none';

            if (method === 'efectivo') contEfectivo.style.display = 'block';
            else if (method === 'tarjeta_debito') contDebito.style.display = 'block';
            else if (method === 'tarjeta_credito') contCredito.style.display = 'block';
            else if (method === 'transferencia') contTransferencia.style.display = 'block';
        }

        function calcularCambio() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            const recibido = parseFloat(document.getElementById('cash_received').value) || 0;
            const cambio = recibido - total;
            document.getElementById('change').textContent = cambio >= 0 ? `${cambio.toFixed(2)}` : `$0.00`;
        }

        window.onload = () => {
            document.getElementById('add-product-btn').addEventListener('click', openProductModal);
            document.getElementById('payment_method').addEventListener('change', onPaymentMethodChange);
            document.getElementById('modal-product').addEventListener('change', onModalProductChange);
            onPaymentMethodChange();
            updateSelectedProducts();
        }
    </script>
</head>
<body class="container mt-4">
    
        
            <h4>Crear Venta

                <button type="button" id="add-product-btn" class="btn btn-primary float-end">
                    <i class="bi bi-plus-circle"></i> Añadir Producto
                </button>

            </h4>

        
   

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" id="total" name="total" value="0">
        <div id="product-ids-container">
            <!-- Aquí se generarán dinámicamente los inputs ocultos para product_id[] y quantity[] -->
        </div>
        

        <div id="selected-products"></div>
        
        <!-- Modal para seleccionar productos -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Seleccionar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modal-product" class="form-label">Producto</label>
                            <select id="modal-product" class="form-select">
                                <option value="">Selecciona un producto</option>
                                <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id'] ?>" data-stock="<?= $product['stock'] ?>" data-price="<?= $product['price'] ?>">
                                    <?= htmlspecialchars($product['name']) ?> (Stock: <?= $product['stock'] ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modal-quantity" class="form-label">Cantidad</label>
                            <input type="number" id="modal-quantity" class="form-control" min="1" value="1" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="addProductFromModal()">Añadir</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="card">
                <div class="card-header">
                    <label for="payment_method" class="form-label">Método de pago</label>


                </div>
                <div class="card-body">

                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta_debito">Tarjeta débito</option>
                        <option value="tarjeta_credito">Tarjeta crédito</option>
                        <option value="transferencia">Transferencia</option>
                    </select>


                    <div id="payment-cash" style="display:none;" class="mt-3">
                        <label for="cash_received" class="form-label">Monto recibido</label>
                        <input type="number" step="0.01" min="0" id="cash_received" name="cash_received" class="form-control" oninput="calcularCambio()" />
                        <p>Cambio: <span id="change">$0.00</span></p>
                    </div>
            
                    <!-- Tarjeta débito -->
                    <div id="payment-debit" style="display:none;" class="mb-3">
                        <label for="card_number_debit" class="form-label">Número de tarjeta</label>
                        <input type="text" name="card_number_debit" id="card_number_debit" class="form-control" />
                        <label for="card_holder_debit" class="form-label mt-2">Titular de la tarjeta</label>
                        <input type="text" name="card_holder_debit" id="card_holder_debit" class="form-control" />
                    </div>
            
                    <!-- Tarjeta crédito -->
                    <div id="payment-credit" style="display:none;" class="mb-3">
                        <label for="card_number_credit" class="form-label">Número de tarjeta</label>
                        <input type="text" name="card_number_credit" id="card_number_credit" class="form-control" />
                        <label for="card_holder_credit" class="form-label mt-2">Titular de la tarjeta</label>
                        <input type="text" name="card_holder_credit" id="card_holder_credit" class="form-control" />
                        <label for="installments" class="form-label mt-2">Número de cuotas</label>
                        <input type="number" name="installments" id="installments" min="1" class="form-control" />
                    </div>
            
                    <!-- Transferencia -->
                    <div id="payment-transfer" style="display:none;" class="mb-3">
                        <label for="bank" class="form-label">Banco</label>
                        <select name="bank" id="bank" class="form-select">
                            <option value="">Selecciona banco</option>
                            <option value="banco1">Banco 1</option>
                            <option value="banco2">Banco 2</option>
                            <option value="banco3">Banco 3</option>
                        </select>
                        <label for="reference_number" class="form-label mt-2">Número de referencia</label>
                        <input type="text" name="reference_number" id="reference_number" class="form-control" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Efectivo -->
                        <div class="card">
                            <div class="card-header">
                            Información de envío
                            </div>
                            <div class="card-body">


                                <div class="mb-3">
                                    <label for="shipping_name" class="form-label">Nombre para envío</label>
                                    <input type="text" name="shipping_name" id="shipping_name" class="form-control" />
                                </div>
                        
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Dirección de envío</label>
                                    <input type="text" name="shipping_address" id="shipping_address" class="form-control" />
                                </div>
                        
                                <div class="mb-3">
                                    <label for="shipping_city" class="form-label">Ciudad</label>
                                    <input type="text" name="shipping_city" id="shipping_city" class="form-control" />
                                </div>
                        
                                <div class="mb-3">
                                    <label for="shipping_phone" class="form-label">Teléfono de contacto</label>
                                    <input type="text" name="shipping_phone" id="shipping_phone" class="form-control" />
                                </div>
                            </div>
                        </div>

        <button type="submit" class="btn btn-primary mt-3">Registrar Venta</button>
    </form>
    
    <!-- Bootstrap JavaScript Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>