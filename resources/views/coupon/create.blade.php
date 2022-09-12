<x-app-layout>

<x-navbar>
<x-loader>
</x-loader>

<div style="display:none;" id="content">
    <center>
    <h1 class="p-3">Create a coupon</h1>
    <div class="w-25 p-3">
    <form action="{{ route('coupon_store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input value="{{old('email')}}" name="email" type="email" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputEmail1" aria-describedby="emailHelp">        
        </div>
        @error('email')
            <p style="color: red">{{ $message }}</p>
        @enderror 
        <label for="exampleInputType" class="form-label">Select coupon type</label>
        <select class="form-select" style=" color: white; background: #2a3038;" aria-label="Default select example" name="coupon_type">
        @foreach ($coupon_types as $type)
            <option value="{{ $type->id }}">{{ $type->type_name }}</option>  
        @endforeach
        </select>
        @error('coupon_type')
            <p style="color: red">{{ $message }}</p>
        @enderror 
        <label for="exampleInputSubType" class="form-label mt-2">Select coupon subtype</label>
        <select class="form-select" style=" color: white; background: #2a3038;" aria-label="Default select example" name="coupon_subtype">
          @foreach ($coupon_subtypes as $subtype)
            <option value="{{ $subtype->id }}">{{ $subtype->subtype_name }}</option>  
          @endforeach
        </select>
        @error('coupon_subtype')
            <p style="color: red">{{ $message }}</p>
        @enderror
        <div class="mb-3 mt-3">
            <label for="exampleInputValue1" class="form-label">Subtype value</label>
            <input value="{{old('value')}}" name="value" type="value" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputValue1" aria-describedby="valueHelp">        
        </div>
        <div class="mb-3">
            <label for="exampleInputLimit" class="form-label">Limit</label>
            <input value="{{old('limit')}}" name="limit" type="text" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputLimit" aria-describedby="limitHelp">        
        </div>
        @error('limit')
            <p style="color: red">{{ $message }}</p>
        @enderror 
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Valid Until</label>
            <input value="{{old('date')}}" name="valid_until" type="date" class="form-control" style=" color: white; background: #2a3038;" id="exampleInputDate" aria-describedby="dateHelp">        
        </div>
        @error('date')
            <p style="color: red">{{ $message }}</p>
        @enderror
        @if($errors->any())
        <h4 style="color: red">{{$errors->first()}}</h4>
        @endif
        <button type="submit" class="btn btn-primary bg-blue-500 mt-3">Submit</button>
      </form>
</div>
</center>

</div>

</x-navbar>

</x-app-layout>