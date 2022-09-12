<x-app-layout>

<x-navbar>

<center><p>All single non-used coupons</p></center>


<form class="input-sm" action="{{ route('filter') }}" method="POST">

@csrf

<input type="hidden" name="current_table" value="coupon.non_used" />

<label for="startdate">from:</label>
<input type="date" class = "datepicker ml-3 mr-2" name = "created_at" id="StartDate" placeholder = "Start Date" style = "display: inline; height: 40px; width:150px; background-color:#2C3034;"/>

<label for="startdate">to:</label>
<input type="date" class = "datepicker ml-3" name = "created_to" id="EndDate" placeholder = "End Date" style = "display: inline; height: 40px; width:150px; background-color:#2C3034;"/>

{{-- <select style="display: inline; height: 40px; width:150px; background-color:#2C3034; color:white;" class="form-select ml-3" aria-label="Default select example" name="coupon_type">
    <option value="" disabled selected>type</option>
@foreach ($types as $type)
    <option value="{{ $type->id }}">{{ $type->type_name }}</option>  
@endforeach
</select>
--}}

<select style="display: inline; height: 40px; width:150px; background-color:#2C3034; color:white;" class="form-select ml-3" aria-label="Default select example" name="coupon_subtype">
    <option value="" disabled selected>subtype</option>
@foreach ($subtypes as $subtype)
    <option value="{{ $subtype->id }}">{{ $subtype->subtype_name }}</option>  
@endforeach
</select>

<input style="display: inline; height: 40px; width:150px; background-color:#2C3034;" type="text" placeholder="value" class="ml-3" name="value"/>

<input style="display: inline; height: 40px; width:150px; background-color:#2C3034;" type="text" placeholder="email" class="ml-3" name="creator_email"/>

<button type="submit" class="btn btn-primary px-4 py-2 ml-7">filter</button>
</form>

<x-loader>
</x-loader>

<div style="display:none;" id="content">
<table class="table table-dark table-striped mt-4">
  <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Email</th>
    <th scope="col">Code</th>
    <th scope="col">Type</th>
    <th scope="col">Subtype</th>
    <th scope="col">Value</th>
    <th scope="col">Limit</th>
    <th scope="col">Status</th>
    <th scope="col">Created at</th>
  </tr>
</thead>
<tbody>
  @foreach ($coupons as $coupon)  
  <tr>
    <th scope="row">{{ $coupon->id }}</th>
    <td>{{ $coupon->creator_email }}</td>
    <td>{{ $coupon->code }}</td>
    <td>{{ $coupon->type->type_name }}</td>
    <td>{{ $coupon->subtype->subtype_name }}</td>
    <td>{{ $coupon->value }}</td>
    <td>{{ $coupon->limit }}</td>
    <td>{{$coupon->status }}</td>
    <td>{{ $coupon->created_at }}</td>
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