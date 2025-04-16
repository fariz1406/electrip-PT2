<?php

namespace App\Services;

use App\Models\Pesanan;
use Exception;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    protected string $serverKey;
    protected string $isProduction;
    protected string $isSanitized;
    protected string $is3ds;

    /**
     * MidtransService constructor.
     *
     * Menyiapkan konfigurasi Midtrans berdasarkan pengaturan yang ada di file konfigurasi.
     */
    public function __construct()
    {
        // Konfigurasi server key, environment, dan lainnya
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        // Mengatur konfigurasi global Midtrans
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }

    /**
     * Membuat snap token untuk transaksi berdasarkan data Pesanan.
     *
     * @param Pesanan $Pesanan Objek Pesanan yang berisi informasi transaksi.
     *
     * @return string Snap token yang dapat digunakan di front-end untuk proses pembayaran.
     * @throws Exception Jika terjadi kesalahan saat menghasilkan snap token.
     */
    public function createSnapToken(Pesanan $Pesanan): string
    {
        // data transaksi
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $Pesanan->id . '-' . time(), // Menggunakan order_id dari pesanan
                'gross_amount' => $Pesanan->biaya,
            ],
            'item_details' => $this->mapItemsToDetails($Pesanan),
            'customer_details' => $this->getCustomerDetails($Pesanan),
        ];

        try {
            // Membuat snap token
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            // Menangani error jika gagal mendapatkan snap token
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Memvalidasi apakah signature key yang diterima dari Midtrans sesuai dengan signature key yang dihitung di server.
     *
     * @return bool Status apakah signature key valid atau tidak.
     */
    public function isSignatureKeyVerified(): bool
    {
        $notification = new Notification();

        // Membuat signature key lokal dari data notifikasi
        $localSignatureKey = hash(
            'sha512',
            $notification->order_id . $notification->status_code .
                $notification->gross_amount . $this->serverKey
        );

        // Memeriksa apakah signature key valid
        return $localSignatureKey === $notification->signature_key;
    }

    /**
     * Mendapatkan data Pesanan berdasarkan Pesanan_id yang ada di notifikasi Midtrans.
     *
     * @return Pesanan Objek Pesanan yang sesuai dengan Pesanan_id yang diterima.
     */
    public function getPesanan(): Pesanan
    {
        $notification = new Notification();

        // Pisahkan order_id untuk mendapatkan ID sebenarnya
        $orderId = explode('-', $notification->order_id)[1] ?? null;

        return Pesanan::where('id', $orderId)->first();
    }


    /**
     * Mendapatkan status transaksi berdasarkan status yang diterima dari notifikasi Midtrans.
     *
     * @return string Status transaksi ('success', 'pending', 'expire', 'cancel', 'failed').
     */
    public function getStatus(): string
    {
        $notification = new Notification();
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        return match ($transactionStatus) {
            'capture' => ($fraudStatus == 'accept') ? 'success' : 'pending',
            'settlement' => 'success',
            'deny' => 'failed',
            'cancel' => 'cancel',
            'expire' => 'expire',
            'pending' => 'pending',
            default => 'unknown',
        };
    }

    /**
     * Memetakan item dalam Pesanan menjadi format yang dibutuhkan oleh Midtrans.
     *
     * @param Pesanan $Pesanan Objek Pesanan yang berisi daftar item.
     * @return array Daftar item yang dipetakan dalam format yang sesuai.
     */
    protected function mapItemsToDetails(Pesanan $Pesanan): array
    {
        // Karena pesanan hanya berisi satu kendaraan, ambil kendaraan dari pesanan
        $kendaraan = $Pesanan->kendaraan;

        return [
            [
                'id' => $kendaraan->id,
                'price' => $Pesanan->biaya,
                'quantity' => 1,
                'name' => $kendaraan->nama,
            ]
        ];
    }

    /**
     * Mendapatkan informasi customer dari Pesanan.
     * Data ini dapat diambil dari relasi dengan tabel lain seperti users atau tabel khusus customer.
     *
     * @param Pesanan $Pesanan Objek Pesanan yang berisi informasi tentang customer.
     * @return array Data customer yang akan dikirim ke Midtrans.
     */
    protected function getCustomerDetails(Pesanan $Pesanan): array
    {
        $user = $Pesanan->users; // Ambil user yang terkait dengan pesanan

        return [
            // 'first_name' => $user->name,
            // 'email' => $user->email,
            // 'phone' => $user->name,

            'first_name' => 'Ferdi Indra Satriady',
            'email' => 'ferd@gmail.com',
            'phone' => '085211451129',
        ];
    }
}
