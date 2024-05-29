<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OrderController extends Controller
{
    public function index(): View
    {
        if (auth()->user()->id == env('ADMIN_ID')) {
            $orders = Order::with('user')->get();
        } else {
            $orders = Order::with('user')
                ->where('user_id', auth()->id())
                ->get();
        }

        return view('orders', compact('orders'));
    }

    public function create(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'order_type' => 'required',
            'description' => 'nullable|string',
            'language' => 'required',
            'delivery_method' => 'required',
        ]);

        Log::info(auth()->id());

        Order::query()
            ->create(
                [
                    'user_id' => auth()->id(),
                    'order_type' => $validatedData['order_type'],
                    'description' => $validatedData['description'],
                    'language' => $validatedData['language'],
                    'delivery_method' => $validatedData['delivery_method'],
                ]
            );

        return redirect()->route('send-order')
            ->with('success', 'Заказ был успешно отправлен!');
    }

    public function showUploadForm(int $id): View
    {
        $order = Order::query()
            ->findOrFail($id);

        return view('upload', compact('order'));
    }

    public function handleUpload(Request $request, int $id): RedirectResponse
    {
        $order = Order::query()->findOrFail($id);

        $request->validate(['pdf' => 'required|file|mimes:pdf']);

        $file = $request->file('pdf');

        // Generate a unique file name to prevent overwriting existing files
        $filename = uniqid().'_'.$file->getClientOriginalName();

        // Save the file to the 'public' disk (typically storage/app/public)
        $path = $file->storeAs('orders', $filename, 'public');

        // Store the path in the database
        $order->update(
            [
                'file' => $path,
                'status' => 'ready',
            ]
        );

        // Return success message
        return redirect()->route('orders.index')
            ->with('success', 'PDF uploaded successfully.');
    }

    public function downloadPdf($id): RedirectResponse|BinaryFileResponse
    {
        $order = Order::query()->findOrFail($id);

        if ($order->file) {
            return response()
                ->download(storage_path('app/public/'.$order->file));
        }

        return redirect()->back()->withErrors('File not found.');
    }
}
