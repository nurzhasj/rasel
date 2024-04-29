<!-- upload.blade.php -->
<form
    action="{{ route('orders.upload', $order->id) }}"
    method="post"
    enctype="multipart/form-data">
    @csrf
    <input type="file" name="pdf" accept="application/pdf">
    <button type="submit" class="btn btn-success">Upload</button>
</form>
