<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CustomerCardController extends Controller
{
    /**
     * Generate unique customer ID
     * Format: CUST-V1DT-{timestamp}{random}
     */
    private function generateCustomerId(): string
    {
        $prefix = 'CUST-V1DT-';
        $timestamp = time();
        $random = mt_rand(10, 99);

        return $prefix . $timestamp . $random;
    }

    /**
     * Generate QR code as base64 SVG image
     */
    private function generateQrCode(string $customerId): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(200, 1),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svgString = $writer->writeString($customerId);

        return 'data:image/svg+xml;base64,' . base64_encode($svgString);
    }

    /**
     * Generate PVC Card data for a customer
     * POST /admin/users/{id}/generate-card
     */
    public function generateCard($id)
    {
        $user = User::with('creator')->findOrFail($id);

        // Generate customer_id if not exists
        if (empty($user->customer_id)) {
            $user->customer_id = $this->generateCustomerId();
            $user->save();
        }

        // Generate QR code
        $qrCodeBase64 = $this->generateQrCode($user->customer_id);

        // Get photo URL
        $photoUrl = null;
        if ($user->photo) {
            $photoUrl = asset('storage/' . $user->photo);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'customer_id' => $user->customer_id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'address' => $user->address,
                'status' => $user->status,
                'photo' => $photoUrl,
                'qr_code' => $qrCodeBase64,
                'member_since' => $user->created_at->format('M Y'),
            ]
        ]);
    }

    /**
     * Show card preview page
     * GET /admin/users/{id}/card-preview
     */
    public function cardPreview($id)
    {
        $user = User::with('creator')->findOrFail($id);

        // Generate customer_id if not exists
        if (empty($user->customer_id)) {
            $user->customer_id = $this->generateCustomerId();
            $user->save();
        }

        // Generate QR code
        $qrCodeBase64 = $this->generateQrCode($user->customer_id);

        // Get photo URL
        $photoUrl = null;
        if ($user->photo) {
            $photoUrl = asset('storage/' . $user->photo);
        }

        return view('Admin.users.card-preview', [
            'user' => $user,
            'qrCode' => $qrCodeBase64,
            'photoUrl' => $photoUrl,
        ]);
    }

    /**
     * Generate and download PDF for PVC card printing
     * GET /admin/users/{id}/card-pdf
     */
    public function downloadPdf($id)
    {
        $user = User::with('creator')->findOrFail($id);

        // Generate customer_id if not exists
        if (empty($user->customer_id)) {
            $user->customer_id = $this->generateCustomerId();
            $user->save();
        }

        // Generate QR code
        $qrCodeBase64 = $this->generateQrCode($user->customer_id);

        // Get photo as base64 for PDF embedding
        $photoBase64 = null;
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            $photoPath = Storage::disk('public')->path($user->photo);
            $photoData = file_get_contents($photoPath);
            $photoMime = mime_content_type($photoPath);
            $photoBase64 = 'data:' . $photoMime . ';base64,' . base64_encode($photoData);
        }

        $pdf = Pdf::loadView('Admin.users.card-pdf', [
            'user' => $user,
            'qrCode' => $qrCodeBase64,
            'photoBase64' => $photoBase64,
        ]);

        // A4 Landscape for PVC card printing (Front + Back on same page)
        $pdf->setPaper('a4', 'landscape');

        $filename = 'PVC_Card_' . $user->customer_id . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Stream PDF in browser for preview
     * GET /admin/users/{id}/card-pdf-preview
     */
    public function streamPdf($id)
{
    $user = User::with('creator')->findOrFail($id);

    // Generate customer_id if not exists
    if (empty($user->customer_id)) {
        $user->customer_id = $this->generateCustomerId();
        $user->save();
    }

    // Generate QR code
    $qrCodeBase64 = $this->generateQrCode($user->customer_id);

    // Get photo as base64 for PDF embedding
    $photoBase64 = null;
    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
        $photoPath = Storage::disk('public')->path($user->photo);
        $photoData = file_get_contents($photoPath);
        $photoMime = mime_content_type($photoPath);
        $photoBase64 = 'data:' . $photoMime . ';base64,' . base64_encode($photoData);
    }

    $pdf = Pdf::loadView('Admin.users.card-pdf', [
        'user' => $user,
        'qrCode' => $qrCodeBase64,
        'photoBase64' => $photoBase64,
    ]);

    // ✅ CR80 size in points (DomPDF unit)
    $width  = 150.60 * 2.83465;
    $height = 100.98 * 2.83465;

    // ✅ IMPORTANT: DomPDF requires [x0, y0, x1, y1]
    $pdf->setPaper([0, 0, $width, $height], 'portrait');

    return $pdf->stream('PVC_Card_' . $user->customer_id . '.pdf');
}

}
