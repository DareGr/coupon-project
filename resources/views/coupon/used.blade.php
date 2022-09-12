<x-app-layout>

<x-navbar>
  
  <form class="input-sm" action="{{ route('filter') }}" method="POST">

    <center><p>All used coupons</p></center>

    @csrf

    <input type="hidden" name="current_table" value="coupon.used" />

    <label for="startdate">from:</label>
    <input type="date" class = "datepicker ml-4" name = "used_at" id="StartDate" placeholder = "Start Date" style = "display: inline; height: 40px; width:150px; background-color:#2C3034;"/>
    
    <label class="ml-2" for="startdate">to:</label>
    <input type="date" class = "datepicker ml-3" name = "used_to" id="EndDate" placeholder = "End Date" style = "display: inline; height: 40px; width:150px; background-color:#2C3034;"/>
    
    <select style="display: inline; height: 40px; width:120px; background-color:#2C3034; color:white;" class="form-select ml-5" aria-label="Default select example" name="coupon_type">
        <option value="" disabled selected>type</option>
    @foreach ($types as $type)
        <option value="{{ $type->id }}">{{ $type->type_name }}</option>  
    @endforeach
    </select>
    
    <select style="display: inline; height: 40px; width:120px; background-color:#2C3034; color:white;" class="form-select ml-5" aria-label="Default select example" name="coupon_subtype">
        <option value="" disabled selected>subtype</option>
    @foreach ($subtypes as $subtype)
        <option value="{{ $subtype->id }}">{{ $subtype->subtype_name }}</option>  
    @endforeach
    </select>
    
    <input style="display: inline; height: 40px; width:120px; background-color:#2C3034; " type="text" placeholder="value" class="ml-5" name="value"/>
    
    <select style="display: inline; height: 40px; width:120px; background-color:#2C3034; color:white;" class="form-select ml-5" aria-label="Default select example" name="status">
      <option value="" disabled selected>status</option>
      <option value="active">active</option>
      <option value="inactive">inactive</option>   
    </select>
    
    <input style="display: inline; height: 40px; width:120px; background-color:#2C3034;" type="text" placeholder="used times" class="ml-5" name="used_times"/>
    <input style="display: inline; height: 40px; width:120px; background-color:#2C3034;" type="text" placeholder="email" class="ml-5" name="email"/>
    <button type="submit" class="btn btn-primary px-4 py-2 ml-7">filter</button>
  </form>

<x-loader>
</x-loader>

<div style="display:none;" id="content">
  <table class="table table-dark table-striped mt-3">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Type</th>
        <th scope="col">Subtype</th>
        <th scope="col">Value</th>
        <th scope="col">Limit</th>
        <th scope="col">Email</th>
        <th scope="col">Code</th>
        <th scope="col">Used at</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($coupons as $coupon)
        
      <tr>
        <th scope="row">{{ $coupon->id }}</th>
        <td>{{ $coupon->type_name }}</td>
        <td>{{ $coupon->subtype_name }}</td>
        <td>{{ $coupon->value }}</td>
        <td>{{ $coupon->limit }}</td>
        <td>{{ $coupon->email }}</td>
        <td>{{ $coupon->code }}</td>
        <td>{{ $coupon->used_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
 
  @if($filter)
  @if ($coupons->hasPages())
  <nav aria-label="Page navigation example">
  <ul class="pagination mt-4" style="justify-content: center">
      {{-- Previous Page Link --}}
      @if ($coupons->onFirstPage())
          <li class="btn btn-primary disabled mr-2" style="background-color: #2C3034"><span>{{ __('Prev') }}</span></li>
      @else
          <li><a class="btn btn-primary mr-2" style="background-color: #1D9DEA" href="{{ $coupons->previousPageUrl() }}" rel="prev">{{ __('Prev') }}</a></li>
      @endif

      {{ "Page " . $coupons->currentPage() . "  of  " . $coupons->lastPage() }}
     
      {{-- Next Page Link --}}
      @if ($coupons->hasMorePages())
          <li><a class="btn btn-primary ml-2" style="background-color: #1D9DEA" href="{{ $coupons->nextPageUrl() }}" rel="next">{{ __('Next') }}</a></li>
      @else
          <li class="btn btn-primary disabled ml-2" style="background-color: #2C3034"><span>{{ __('Next') }}</span></li>
      @endif
  </ul>
  </nav>
@endif
@endif

</div>
</x-navbar>

</x-app-layout>