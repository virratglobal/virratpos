# Payments Audit

## Gateways Integrated
- Stripe, PayPal, Toyyibpay, SSPay, PayTab, Cashfree, Aamarpay, PayTR, Payfast, IyziPay, YooKassa, Midtrans, Xendit, Nepalste, Paiement Pro, FedaPay, PayHere, CinetPay, Tap, AuthorizeNet, Khalti, Ozow, Paystack, Flutterwave, Razorpay, MercadoPago, Paytm, Mollie, CoinGate, Skrill, PaymentWall.
- Manual Methods: Bank Transfer, COD.

## Architecture
- Callbacks are primarily handled in `routes/web.php` directing to specific gateway controllers (e.g., `StripePaymentController`, `PaypalController`).
- Used for both SaaS Subscription Plans and Store Orders.
