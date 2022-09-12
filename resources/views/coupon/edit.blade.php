<x-app-layout>

<x-navbar>
<x-loader>
</x-loader>

<div style="display:none;" id="content">
    <center>
    <h1 class="p-3">Update a coupon</h1>
    <div class="w-25 p-3">
    <form action="{{ route('update') }}" method="POST">
        @csrf
        @method("PATCH")

        <input type="hidden" value="{{ $coupon->id }}" name="id">
        @if ($coupon->coupon_type == 1)
        <div class="mb-3 mt-3">
            <label for="exampleInputValue1" class="form-label">Subtype value</label>
            <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputValue1" aria-describedby="valueHelp">        
        </div>
        <label for="exampleInputStatus" class="form-label">Select coupon status</label>
        <select class="form-select" style=" color: white; background: #2a3038;" aria-label="Default select example" name="status">
            <option value="non-used">non-used</option>
            <option value="used">used</option>    
        </select>
        @elseif ($coupon->coupon_type == 2)
        <div class="mb-3 mt-3">
            <label for="exampleInputValue1" class="form-label">Subtype value</label>
            <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputValue1" aria-describedby="valueHelp">        
        </div>
        <div class="mb-3">
            <label for="exampleInputLimit" class="form-label">Limit</label>
            <input value="{{ $coupon->limit  }}" name="limit" type="text" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputLimit" aria-describedby="limitHelp">        
        </div>
        <label for="exampleInputStatus" class="form-label">Select coupon status</label>
            <select class="form-select" style=" color: white; background: #2a3038;" aria-label="Default select example" name="status">
                <option value="active">active</option>
                <option value="inactive">inactive</option>    
            </select>
        @error('limit')
            <p style="color: red">{{ $message }}</p>
        @enderror 
        @elseif ($coupon->coupon_type == 3 || $coupon->coupon_type == 4)
        <div class="mb-3 mt-3">
            <label for="exampleInputValue1" class="form-label">Subtype value</label>
            <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputValue1" aria-describedby="valueHelp">        
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Valid Until</label>
            <input value="{{ $coupon->valid_until }}" name="valid_until" type="date" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputDate" aria-describedby="dateHelp">        
        </div>
        <label for="exampleInputStatus" class="form-label">Select coupon status</label>
            <select class="form-select" style=" color: white; background: #2a3038;" aria-label="Default select example" name="status">
                <option value="active">active</option>
                <option value="inactive">inactive</option>    
            </select>
        @error('date')
            <p style="color: red">{{ $message }}</p>
        @enderror

        @else
        <div class="mb-3 mt-3">
            <label for="exampleInputValue1" class="form-label">Subtype value</label>
            <input value="{{ $coupon->value }}" name="value" type="text" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputValue1" aria-describedby="valueHelp">        
        </div>
        <label for="exampleInputStatus" class="form-label">Select coupon status</label>
        <select class="form-select" style=" color: white; background: #2a3038;" aria-label="Default select example" name="status">
            <option value="active">active</option>
            <option value="inactive">inactive</option>    
        </select>
        @endif
        <button type="submit" class="btn btn-primary bg-blue-500 mt-3">Update</button>
        </form>
</div>
</center>

</div>

</x-navbar>

</x-app-layout>