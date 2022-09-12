<x-app-layout>

<x-navbar>

<center><p>All email addresses ever came into system</p></center>

<form class="input-sm" action="{{ route('filter') }}" method="POST">

@csrf

<input type="hidden" name="current_table" value="email.all" />

<label for="startdate">from:</label>
<input type="date" class = "datepicker ml-4" name = "created_at" id="StartDate" placeholder = "Start Date" style = "display: inline; height: 40px; width:150px; background-color:#2C3034;"/>

<label class="ml-2" for="startdate">to:</label>
<input type="date" class = "datepicker ml-3" name = "created_to" id="EndDate" placeholder = "End Date" style = "display: inline; height: 40px; width:150px; background-color:#2C3034;"/>

<input style="display: inline; height: 40px; width:140px; background-color:#2C3034;" type="text" placeholder="coupons used" class="ml-5" name="coupons_used"/>
<input style="display: inline; height: 40px; width:120px; background-color:#2C3034;" type="text" placeholder="email" class="ml-5" name="email"/>
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
        <th scope="col">First Coupon Used</th>
        <th scope="col">Last Coupon Used</th>
        <th scope="col">Coupons Used</th>
        <th scope="col">Created At</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($coupons as $coupon)
      <tr>
        <th scope="row">{{ $coupon->id }}</th>
        <td>{{ $coupon->email }}</td>
        <td>{{ $coupon->first_coupon_use }}</td>
        <td>{{ $coupon->last_coupon_use }}</td>
        <td>{{ $coupon->coupons_used }}</td>
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