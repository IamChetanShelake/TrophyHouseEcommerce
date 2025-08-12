@extends('website.layout.master')
@section('content')

@php
use App\Models\CartItem;

$cartItems = CartItem::with(['variant.product'])->where('user_id', auth()->id())->get();

$totalMRP = 0;
$totalDiscount = 0;
$platformFee = 20;
$shippingCharges = 0;

foreach ($cartItems as $item) {
    $variant = $item->variant;
    $originalPrice = $variant->price ?? 0;
    $discountedPrice = $variant->discounted_price ?? $originalPrice;
    $quantity = $item->quantity;

    $totalMRP += $originalPrice * $quantity;
    $totalDiscount += ($originalPrice - $discountedPrice) * $quantity;
}

$totalBase = $totalMRP - $totalDiscount;
$totalGST = $totalBase * 0.18;
$priceWithGST = $totalBase + $totalGST;
$totalAmount = $priceWithGST + $platformFee + $shippingCharges;
@endphp

<style>
  .payment-box {
    border: 1px solid #ccc;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
  }

  .payment-method-list {
    background-color: #e0e0e0;
    height: 100%;
  }

  .payment-option {
    padding: 16px;
    border-bottom: 1px solid #d6d6d6;
    cursor: pointer;
    font-weight: 500;
    transition: background 0.3s ease;
  }

  .payment-option:hover,
  .payment-option.active {
    background-color: #d6d6d6;
  }

  .payment-content {
    padding: 24px;
  }

  .custom-radio {
    appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #d32f2f;
    border-radius: 4px;
    background-color: transparent;
    display: inline-block;
    position: relative;
    margin-right: 10px;
    vertical-align: middle;
    cursor: pointer;
  }

  .custom-radio:checked::before {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    background-color: #ff7e6b;
    border-radius: 2px;
    top: 2px;
    left: 2px;
  }

  .payment-section {
    display: none;
  }

  .payment-section.active {
    display: block;
  }

  .btn-pay {
    background-color: #d32f2f;
    color: white;
    width: 100%;
    font-weight: 600;
    border: none;
  }

  .btn-pay:hover {
    background-color: #b71c1c;
  }

  .step {
    font-family: 'Source Sans 3', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #555;
  }

  .active-step {
    color: #00b050;
    font-weight: 700;
  }

  .dashed-line {
    width: 40px;
    height: 1px;
    border-bottom: 1px dashed #888;
  }
</style>

<section class="container my-5">
  <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom mb-4">
    <div style="cursor: pointer;" onclick="window.history.back();">
      <img src="{{ asset('website/assets/images/left.png') }}" alt="Back" width="20">
    </div>
    <div class="d-flex align-items-center gap-3">
      <span class="step">CART</span>
      <span class="dashed-line"></span>
      <span class="step">ADDRESS</span>
      <span class="dashed-line"></span>
      <span class="step active-step">PAYMENT</span>
    </div>
    <div class="d-flex align-items-center">
      <img src="{{ asset('website/assets/images/secure.png') }}" alt="Secure" width="20" class="me-2">
      <span style="font-size: 13px; letter-spacing: 0.5px; color: #666;">100% SECURE</span>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <h5 class="mb-3" style="font-family: 'Times New Roman', serif; font-weight: bold;">Choose Payment Method</h5>

      <div class="payment-box row g-0">
        <div class="col-md-4">
          <div class="payment-method-list h-100">
            <div class="payment-option active" data-target="upi">UPI (Pay via any App)</div>
            <div class="payment-option" data-target="credit">Credit Card</div>
            <div class="payment-option" data-target="debit">Debit Card</div>
            <div class="payment-option" data-target="netbanking">Net Banking</div>
            <div class="payment-option" data-target="emi">EMI</div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="payment-content">
            <div class="payment-section active" id="upi">
              <h6 class="mb-3">UPI (Pay via any App)</h6>
              <div class="mb-3 d-flex align-items-center">
                <input type="radio" name="upiOption" class="custom-radio">
                <img src="{{ asset('website/assets/images/pay1.png') }}" alt="QR" style="height: 40px; margin-right:10px;">
                <span>Scan and pay</span>
              </div>
              <div class="mb-3 d-flex align-items-center">
                <input type="radio" name="upiOption" class="custom-radio">
                <img src="{{ asset('website/assets/images/pay2.png') }}" alt="UPI" style="height: 30px; margin-right:10px;">
                <span>Enter your UPI ID</span>
              </div>
            </div>

            <div class="payment-section" id="credit">
              <h6>Credit Card Payment</h6>
              <form>
                <input type="text" class="form-control mb-3" placeholder="Credit Card Number">
                <input type="text" class="form-control mb-3" placeholder="Name on Card">
                <div class="row mb-3">
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Valid Thru (MM/YY)">
                  </div>
                  <div class="col">
                    <input type="password" class="form-control" placeholder="CVV">
                  </div>
                </div>
                <button type="button" class="btn btn-pay">Pay Now</button>
              </form>
            </div>

            <div class="payment-section" id="debit">
              <h6>Debit Card Payment</h6>
              <form>
                <input type="text" class="form-control mb-3" placeholder="Card Number">
                <input type="text" class="form-control mb-3" placeholder="Name on Card">
                <div class="row mb-3">
                  <div class="col">
                    <input type="text" class="form-control" placeholder="Valid Thru (MM/YY)">
                  </div>
                  <div class="col">
                    <input type="password" class="form-control" placeholder="CVV">
                  </div>
                </div>
                <button type="button" class="btn btn-pay">Pay Now</button>
              </form>
            </div>

            <div class="payment-section" id="netbanking">
              <p>Net Banking options coming soon.</p>
            </div>

            <div class="payment-section" id="emi">
              <p>EMI options coming soon.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Price Summary -->
    <div class="col-lg-4">
      <div class="payment-content">
        <h6>Price Details ({{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'Item' : 'Items' }})</h6>
        <div class="d-flex justify-content-between">
          <span>Total MRP (incl. 18% GST)</span>
          <span>₹{{ number_format($priceWithGST, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Discount on MRP</span>
          <span class="text-success">−₹{{ number_format($totalDiscount, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Platform Fees</span>
          <span>₹{{ number_format($platformFee, 2) }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Shipping Charges</span>
          <span class="{{ $shippingCharges == 0 ? 'text-success' : '' }}">
            {{ $shippingCharges == 0 ? 'FREE' : '₹' . number_format($shippingCharges, 2) }}
          </span>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-3">
          <strong>Total Amount</strong>
          <strong>₹{{ number_format($totalAmount, 2) }}</strong>
        </div>

        <form action="#" method="GET">
  <button type="submit" class="btn btn-pay mt-3 mb-3">Pay Now</button>
</form>

<form action="{{ route('generate.bill') }}" method="POST">
  @csrf
  <button type="submit" class="btn btn-pay">Generate bill</button>
</form>

      </div>
    </div>
  </div>
</section>

<script>
  document.querySelectorAll('.payment-option').forEach(option => {
    option.addEventListener('click', () => {
      document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('active'));
      option.classList.add('active');

      document.querySelectorAll('.payment-section').forEach(sec => sec.classList.remove('active'));
      document.getElementById(option.dataset.target).classList.add('active');
    });
  });
</script>
@endsection
